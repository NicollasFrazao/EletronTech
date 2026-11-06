<?php

declare(strict_types=1);

namespace App\Domain\Quantity;

use Brick\Math\BigNumber;
use Brick\Math\BigRational;

/**
 * An electric charge, stored in coulombs.
 */
final readonly class Charge extends Quantity
{
    /**
     * The dimension every value of this quantity has.
     */
    public static function dimension(): Dimension
    {
        return Dimension::Charge;
    }

    /**
     * The charge of a value in coulombs.
     */
    public static function fromCoulombs(BigNumber|int|string $coulombs): self
    {
        return new self(BigRational::of($coulombs));
    }

    /**
     * The exact value in coulombs.
     *
     * @api
     */
    public function toCoulombs(): BigRational
    {
        return $this->value;
    }

    /**
     * The capacitance that holds this charge at a voltage (C = Q / V).
     *
     * @throws DivisionByZero
     */
    public function dividedByVoltage(Voltage $voltage): Capacitance
    {
        return Capacitance::fromFarads(self::quotient($this->value, $voltage->toVolts()));
    }

    /**
     * The voltage across a capacitance holding this charge (V = Q / C).
     *
     * @throws DivisionByZero
     *
     * @api
     */
    public function dividedByCapacitance(Capacitance $capacitance): Voltage
    {
        return Voltage::fromVolts(self::quotient($this->value, $capacitance->toFarads()));
    }
}
