<?php

declare(strict_types=1);

namespace App\Domain\Quantity;

use Brick\Math\BigNumber;
use Brick\Math\BigRational;

/**
 * An electrical resistance or impedance magnitude, stored in ohms.
 */
final readonly class Resistance extends Quantity
{
    /**
     * The dimension every value of this quantity has.
     */
    public static function dimension(): Dimension
    {
        return Dimension::Resistance;
    }

    /**
     * The resistance of a value in ohms.
     */
    public static function fromOhms(BigNumber|int|string $ohms): self
    {
        return new self(BigRational::of($ohms));
    }

    /**
     * The exact value in ohms.
     */
    public function toOhms(): BigRational
    {
        return $this->value;
    }

    /**
     * The voltage across this resistance when a current flows through it (Ohm's law, V = R × I).
     */
    public function timesCurrent(Current $current): Voltage
    {
        return $current->timesResistance($this);
    }

    /**
     * The conductance of this resistance (G = 1 / R).
     *
     * @throws DivisionByZero
     */
    public function reciprocal(): Conductance
    {
        return Conductance::fromSiemens(self::quotient(BigRational::one(), $this->value));
    }
}
