<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Electrical\Nbr5410;

use App\Domain\Quantity\ApparentPower;
use App\Domain\Quantity\Area;
use Brick\Math\BigInteger;
use Brick\Math\RoundingMode;

/**
 * The minimum lighting load of a room, NBR 5410:2004 section 9.5.2.1.2: 100 VA for the first 6 m² of floor, plus
 * 60 VA for each whole 4 m² beyond them.
 */
final class LightingLoad
{
    private const string FIRST_AREA_SQUARE_METRES = '6';

    private const string FIRST_LOAD_VOLT_AMPERES = '100';

    private const string STEP_AREA_SQUARE_METRES = '4';

    private const string STEP_LOAD_VOLT_AMPERES = '60';

    /**
     * How many whole 4 m² steps the area has beyond the first 6 m²; zero for 6 m² or less.
     */
    public static function additionalSteps(Area $area): BigInteger
    {
        $beyond = $area->toSquareMetres()->minus(self::FIRST_AREA_SQUARE_METRES);

        if ($beyond->isNegativeOrZero()) {
            return BigInteger::zero();
        }

        return $beyond->dividedBy(self::STEP_AREA_SQUARE_METRES)->toScale(0, RoundingMode::Down)->toBigInteger();
    }

    /**
     * The minimum lighting load for a floor area.
     */
    public static function forArea(Area $area): ApparentPower
    {
        $steps = self::additionalSteps($area);

        return ApparentPower::fromVoltAmperes(self::FIRST_LOAD_VOLT_AMPERES)
            ->plus(ApparentPower::fromVoltAmperes(self::STEP_LOAD_VOLT_AMPERES)->multipliedBy($steps));
    }
}
