<?php

declare(strict_types=1);

namespace App\Domain\Quantity;

use Brick\Math\BigNumber;
use Brick\Math\BigRational;

/**
 * An electrical conductance, stored in siemens.
 */
final readonly class Conductance extends Quantity
{
    /**
     * The dimension every value of this quantity has.
     */
    public static function dimension(): Dimension
    {
        return Dimension::Conductance;
    }

    /**
     * The conductance of a value in siemens.
     */
    public static function fromSiemens(BigNumber|int|string $siemens): self
    {
        return new self(BigRational::of($siemens));
    }

    /**
     * The exact value in siemens.
     */
    public function toSiemens(): BigRational
    {
        return $this->value;
    }

    /**
     * The resistance of this conductance (R = 1 / G).
     *
     * @throws DivisionByZero
     *
     * @api
     */
    public function reciprocal(): Resistance
    {
        return Resistance::fromOhms(self::quotient(BigRational::one(), $this->value));
    }

    /**
     * The current this conductance lets through at a voltage (I = G × V).
     */
    public function timesVoltage(Voltage $voltage): Current
    {
        return Current::fromAmperes($this->value->multipliedBy($voltage->toVolts()));
    }
}
