<?php

declare(strict_types=1);

namespace App\Domain\Quantity;

use Brick\Math\BigNumber;
use Brick\Math\BigRational;

/**
 * An electric current, stored in amperes.
 */
final readonly class Current extends Quantity
{
    /**
     * The dimension every value of this quantity has.
     */
    public static function dimension(): Dimension
    {
        return Dimension::Current;
    }

    /**
     * The current of a value in amperes.
     */
    public static function fromAmperes(BigNumber|int|string $amperes): self
    {
        return new self(BigRational::of($amperes));
    }

    /**
     * The exact value in amperes.
     */
    public function toAmperes(): BigRational
    {
        return $this->value;
    }

    /**
     * The power a load takes at this current and voltage (P = V × I, for direct current or a resistive load).
     */
    public function timesVoltage(Voltage $voltage): Power
    {
        return $voltage->timesCurrent($this);
    }

    /**
     * The voltage this current develops across a resistance (Ohm's law, V = R × I).
     */
    public function timesResistance(Resistance $resistance): Voltage
    {
        return Voltage::fromVolts($this->value->multipliedBy($resistance->toOhms()));
    }

    /**
     * The conductance that lets this current through at a voltage (G = I / V).
     *
     * @throws DivisionByZero
     */
    public function dividedByVoltage(Voltage $voltage): Conductance
    {
        return Conductance::fromSiemens(self::quotient($this->value, $voltage->toVolts()));
    }

    /**
     * The voltage that drives this current through a conductance (V = I / G).
     *
     * @throws DivisionByZero
     */
    public function dividedByConductance(Conductance $conductance): Voltage
    {
        return Voltage::fromVolts(self::quotient($this->value, $conductance->toSiemens()));
    }
}
