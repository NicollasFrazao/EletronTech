<?php

declare(strict_types=1);

namespace App\Domain\Quantity;

use Brick\Math\BigNumber;

/**
 * Builds the value object that matches a unit, for code that works on any dimension, such as the unit converter.
 */
final class Quantities
{
    /**
     * The quantity of a value given in a unit: a Voltage for volts, a Length for feet, and so on.
     */
    public static function of(BigNumber|int|string $value, Unit $unit): Quantity
    {
        $coherent = $unit->toCoherentUnit($value);

        return match ($unit->dimension()) {
            Dimension::Voltage => Voltage::fromVolts($coherent),
            Dimension::Current => Current::fromAmperes($coherent),
            Dimension::Power => Power::fromWatts($coherent),
            Dimension::ApparentPower => ApparentPower::fromVoltAmperes($coherent),
            Dimension::Resistance => Resistance::fromOhms($coherent),
            Dimension::Conductance => Conductance::fromSiemens($coherent),
            Dimension::Capacitance => Capacitance::fromFarads($coherent),
            Dimension::Inductance => Inductance::fromHenries($coherent),
            Dimension::Charge => Charge::fromCoulombs($coherent),
            Dimension::Frequency => Frequency::fromHertz($coherent),
            Dimension::Length => Length::fromMetres($coherent),
            Dimension::Area => Area::fromSquareMetres($coherent),
        };
    }
}
