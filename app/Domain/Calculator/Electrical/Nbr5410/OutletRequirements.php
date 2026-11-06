<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Electrical\Nbr5410;

use App\Domain\Calculator\Electrical\RoomDimensions;
use App\Domain\Calculator\Electrical\RoomType;
use App\Domain\Quantity\ApparentPower;
use Brick\Math\BigInteger;
use Brick\Math\RoundingMode;

/**
 * The minimum number of general-purpose outlets of a room and the load assigned to them, NBR 5410:2004
 * sections 9.5.2.2.1 and 9.5.2.2.2, as a table per kind of room.
 *
 * Count rules: in a bathroom or on a veranda at least one outlet (a and c); in kitchens, pantries, service
 * areas and laundries one per 3.5 m, or fraction, of perimeter (b); in living rooms and bedrooms one per 5 m, or
 * fraction, of perimeter (d); in the other rooms one when the area is at most 6 m², otherwise one per 5 m, or
 * fraction, of perimeter (e).
 *
 * Loads: in bathrooms, kitchens, pantries, service areas and laundries ("wet" rooms) 600 VA for each of the
 * first three outlets and 100 VA for each one beyond them; elsewhere 100 VA per outlet.
 */
final class OutletRequirements
{
    /**
     * Per room type: the count rule, the perimeter step in metres for the rules that use one, and whether the
     * room takes the wet-room loads.
     *
     * @var array<string, array{rule: string, step: string, wet: bool}>
     */
    private const array ROOMS = [
        'bathroom' => ['rule' => self::AT_LEAST_ONE, 'step' => '0', 'wet' => true],
        'kitchen' => ['rule' => self::PER_PERIMETER, 'step' => '3.5', 'wet' => true],
        'pantry' => ['rule' => self::PER_PERIMETER, 'step' => '3.5', 'wet' => true],
        'service_area' => ['rule' => self::PER_PERIMETER, 'step' => '3.5', 'wet' => true],
        'laundry' => ['rule' => self::PER_PERIMETER, 'step' => '3.5', 'wet' => true],
        'veranda' => ['rule' => self::AT_LEAST_ONE, 'step' => '0', 'wet' => false],
        'bedroom' => ['rule' => self::PER_PERIMETER, 'step' => '5', 'wet' => false],
        'living_room' => ['rule' => self::PER_PERIMETER, 'step' => '5', 'wet' => false],
        'garage' => ['rule' => self::PER_PERIMETER_ABOVE_SMALL_AREA, 'step' => '5', 'wet' => false],
        'attic' => ['rule' => self::PER_PERIMETER_ABOVE_SMALL_AREA, 'step' => '5', 'wet' => false],
        'basement' => ['rule' => self::PER_PERIMETER_ABOVE_SMALL_AREA, 'step' => '5', 'wet' => false],
    ];

    private const string AT_LEAST_ONE = 'at_least_one';

    private const string PER_PERIMETER = 'per_perimeter';

    private const string PER_PERIMETER_ABOVE_SMALL_AREA = 'per_perimeter_above_small_area';

    /**
     * Up to this area, in square metres, a room of the "other rooms" rule needs a single outlet.
     */
    private const string SMALL_AREA_SQUARE_METRES = '6';

    /**
     * How many outlets of a wet room take the higher load.
     */
    private const int WET_ROOM_HIGH_LOAD_OUTLETS = 3;

    private const string HIGH_LOAD_VOLT_AMPERES = '600';

    private const string LOAD_VOLT_AMPERES = '100';

    /**
     * The minimum number of general-purpose outlets of the room.
     */
    public static function count(RoomType $type, RoomDimensions $room): BigInteger
    {
        $row = self::ROOMS[$type->value];

        $isSmall = $room->area()->toSquareMetres()->isLessThanOrEqualTo(self::SMALL_AREA_SQUARE_METRES);

        return match ($row['rule']) {
            self::AT_LEAST_ONE => BigInteger::one(),
            self::PER_PERIMETER_ABOVE_SMALL_AREA => $isSmall ? BigInteger::one() : self::perPerimeter($room, $row['step']),
            default => self::perPerimeter($room, $row['step']),
        };
    }

    /**
     * How many of the outlets take the higher load of a wet room (600 VA); zero in other rooms.
     */
    public static function highLoadOutlets(RoomType $type, BigInteger $outlets): BigInteger
    {
        if (! self::ROOMS[$type->value]['wet']) {
            return BigInteger::zero();
        }

        return BigInteger::min($outlets, BigInteger::of(self::WET_ROOM_HIGH_LOAD_OUTLETS));
    }

    /**
     * The load assigned to the outlets: 600 VA for each high-load outlet, 100 VA for each of the others.
     */
    public static function load(BigInteger $highLoadOutlets, BigInteger $otherOutlets): ApparentPower
    {
        return ApparentPower::fromVoltAmperes(self::HIGH_LOAD_VOLT_AMPERES)->multipliedBy($highLoadOutlets)
            ->plus(ApparentPower::fromVoltAmperes(self::LOAD_VOLT_AMPERES)->multipliedBy($otherOutlets));
    }

    /**
     * One outlet per step of perimeter, or fraction of a step.
     */
    private static function perPerimeter(RoomDimensions $room, string $stepInMetres): BigInteger
    {
        return $room->perimeter()->toMetres()->dividedBy($stepInMetres)->toScale(0, RoundingMode::Ceiling)->toBigInteger();
    }
}
