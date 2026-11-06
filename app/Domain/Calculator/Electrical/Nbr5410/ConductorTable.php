<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Electrical\Nbr5410;

use App\Domain\Calculator\Electrical\CircuitPurpose;
use App\Domain\Calculator\FixedUnit;
use App\Domain\Quantity\Area;
use App\Domain\Quantity\BaseUnit;
use App\Domain\Quantity\Current;

/**
 * Copper conductors by cross-section, with their current-carrying capacity and the smallest section each kind of
 * circuit may use.
 *
 * Capacities are NBR 5410:2004 table 36, reference method B1 (insulated conductors in a conduit on or in a
 * masonry wall), PVC insulation at 70 °C, ambient temperature 30 °C, one circuit in the conduit, so no correction
 * factor applies. Minimum sections are table 47 for copper in fixed installations: 1.5 mm² for lighting circuits,
 * 2.5 mm² for power circuits.
 */
final class ConductorTable
{
    /**
     * Section in mm², and the capacity in amperes with two and with three loaded conductors.
     */
    private const array CAPACITIES = [
        ['section' => '1.5', 'two_loaded' => '17.5', 'three_loaded' => '15.5'],
        ['section' => '2.5', 'two_loaded' => '24', 'three_loaded' => '21'],
        ['section' => '4', 'two_loaded' => '32', 'three_loaded' => '28'],
        ['section' => '6', 'two_loaded' => '41', 'three_loaded' => '36'],
        ['section' => '10', 'two_loaded' => '57', 'three_loaded' => '50'],
        ['section' => '16', 'two_loaded' => '76', 'three_loaded' => '68'],
        ['section' => '25', 'two_loaded' => '101', 'three_loaded' => '89'],
        ['section' => '35', 'two_loaded' => '125', 'three_loaded' => '110'],
        ['section' => '50', 'two_loaded' => '151', 'three_loaded' => '134'],
    ];

    /**
     * Three loaded conductors read the last column of CAPACITIES; two, the one before.
     */
    private const int THREE_LOADED_CONDUCTORS = 3;

    /**
     * The smallest section, in mm², of each circuit purpose.
     */
    private const array MINIMUM_SECTION = ['lighting' => '1.5', 'power' => '2.5'];

    /**
     * The smallest section the circuit may use.
     */
    public static function minimumSection(CircuitPurpose $purpose): Area
    {
        return self::section(self::MINIMUM_SECTION[$purpose->value]);
    }

    /**
     * The smallest conductor, no thinner than the circuit's minimum, that carries at least the current; null when
     * none in the table does.
     *
     * @param  2|3  $loadedConductors
     *
     * @return array{Area, Current}|null The section and its capacity.
     */
    public static function smallestCarrying(Current $current, int $loadedConductors, CircuitPurpose $purpose): ?array
    {
        $column = $loadedConductors === self::THREE_LOADED_CONDUCTORS ? 'three_loaded' : 'two_loaded';
        $minimum = self::minimumSection($purpose);

        foreach (self::CAPACITIES as $row) {
            $section = self::section($row['section']);
            $capacity = Current::fromAmperes($row[$column]);

            if (! $section->isLessThan($minimum) && ! $capacity->isLessThan($current)) {
                return [$section, $capacity];
            }
        }

        return null;
    }

    /**
     * A section given in square millimetres.
     */
    private static function section(string $squareMillimetres): Area
    {
        return Area::fromSquareMetres(FixedUnit::of(BaseUnit::SquareMillimetre)->toCoherentUnit($squareMillimetres));
    }
}
