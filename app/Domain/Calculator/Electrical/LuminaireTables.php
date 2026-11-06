<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Electrical;

use Brick\Math\BigRational;

/**
 * The two factors of the lumen method read from tables: the utilisation factor of the luminaire and the
 * depreciation factor of the installation.
 *
 * Both tables are those of the 2015 version. The utilisation factors are a luminaire manufacturer's table (in
 * percent) by room index and by the reflectances of ceiling, walls and work plane; between two room indexes the
 * factor is interpolated linearly, and outside the table's range the nearest row is used. The depreciation
 * factors are the share of the initial luminous flux left before the next cleaning, by how clean the room is
 * and how often the luminaires are cleaned.
 */
final class LuminaireTables
{
    /**
     * The room indexes of the rows of UTILISATION_FACTORS.
     *
     * @var non-empty-list<string>
     */
    private const array ROOM_INDEXES = ['0.6', '0.8', '1', '1.25', '1.5', '2', '2.5', '3', '4', '5'];

    /**
     * Utilisation factor in percent, one column per reflectance combination, one entry per row of ROOM_INDEXES.
     *
     * @var array<string, non-empty-list<string>>
     */
    private const array UTILISATION_FACTORS = [
        '80_80_30' => ['51', '58', '62', '66', '68', '71', '73', '74', '76', '76'],
        '80_50_30' => ['38', '45', '50', '56', '60', '64', '67', '69', '71', '73'],
        '80_30_30' => ['33', '41', '46', '52', '56', '60', '64', '66', '69', '71'],
        '50_50_30' => ['37', '44', '48', '53', '56', '60', '62', '64', '65', '67'],
        '50_30_30' => ['33', '40', '44', '50', '53', '57', '60', '62', '64', '65'],
        '70_70_20' => ['43', '49', '53', '57', '60', '62', '64', '66', '67', '67'],
        '70_50_20' => ['37', '43', '48', '53', '56', '59', '62', '63', '65', '66'],
        '70_30_20' => ['33', '40', '44', '50', '53', '57', '59', '62', '63', '65'],
        '80_80_10' => ['46', '51', '54', '58', '59', '61', '62', '63', '64', '64'],
        '80_50_10' => ['36', '43', '47', '52', '54', '57', '59', '61', '62', '62'],
        '80_30_10' => ['32', '39', '43', '52', '55', '57', '59', '60', '62', '62'],
        '50_50_10' => ['35', '42', '46', '50', '53', '55', '57', '59', '60', '61'],
        '50_30_10' => ['32', '39', '43', '48', '51', '54', '56', '58', '59', '60'],
        '30_30_10' => ['32', '38', '42', '47', '50', '53', '55', '57', '58', '59'],
    ];

    /**
     * Depreciation factor by room cleanliness, then by maintenance interval.
     */
    private const array DEPRECIATION_FACTORS = [
        'clean' => ['2500_hours' => '0.95', '5000_hours' => '0.91', '7500_hours' => '0.88'],
        'normal' => ['2500_hours' => '0.91', '5000_hours' => '0.85', '7500_hours' => '0.80'],
        'dirty' => ['2500_hours' => '0.80', '5000_hours' => '0.66', '7500_hours' => '0.57'],
    ];

    private const int PERCENT = 100;

    /**
     * The utilisation factor, as a fraction, for a room index and the room's reflectances.
     */
    public static function utilisationFactor(BigRational $roomIndex, SurfaceReflectances $reflectances): BigRational
    {
        $column = self::UTILISATION_FACTORS[$reflectances->value];
        $last = count(self::ROOM_INDEXES) - 1;

        if ($roomIndex->isLessThanOrEqualTo(self::ROOM_INDEXES[0])) {
            return BigRational::of($column[0])->dividedBy(self::PERCENT);
        }

        for ($row = 0; $row < $last; $row++) {
            if ($roomIndex->isLessThanOrEqualTo(self::ROOM_INDEXES[$row + 1])) {
                return self::interpolate($roomIndex, $row, $column)->dividedBy(self::PERCENT);
            }
        }

        return BigRational::of($column[$last])->dividedBy(self::PERCENT);
    }

    /**
     * The depreciation factor for the room's cleanliness and the maintenance interval.
     */
    public static function depreciationFactor(RoomCleanliness $cleanliness, MaintenanceInterval $interval): BigRational
    {
        return BigRational::of(self::DEPRECIATION_FACTORS[$cleanliness->value][$interval->value]);
    }

    /**
     * The factor, in percent, at a room index between one row and the next, on the straight line through them.
     *
     * @param  int  $row  The row at or just below the room index; never the last.
     * @param  non-empty-list<string>  $column
     */
    private static function interpolate(BigRational $roomIndex, int $row, array $column): BigRational
    {
        $lower = BigRational::of(self::ROOM_INDEXES[$row]);
        $upper = BigRational::of(self::ROOM_INDEXES[$row + 1]);
        $position = $roomIndex->minus($lower)->dividedBy($upper->minus($lower));

        $factor = BigRational::of($column[$row]);

        return $factor->plus($position->multipliedBy(BigRational::of($column[$row + 1])->minus($factor)));
    }
}
