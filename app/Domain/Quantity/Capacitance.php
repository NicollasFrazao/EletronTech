<?php

declare(strict_types=1);

namespace App\Domain\Quantity;

use Brick\Math\BigNumber;
use Brick\Math\BigRational;

/**
 * A capacitance, stored in farads.
 */
final readonly class Capacitance extends Quantity
{
    /**
     * The dimension every value of this quantity has.
     */
    public static function dimension(): Dimension
    {
        return Dimension::Capacitance;
    }

    /**
     * The capacitance of a value in farads.
     */
    public static function fromFarads(BigNumber|int|string $farads): self
    {
        return new self(BigRational::of($farads));
    }

    /**
     * The exact value in farads.
     */
    public function toFarads(): BigRational
    {
        return $this->value;
    }

    /**
     * The charge this capacitance holds at a voltage (Q = C × V).
     *
     * @api
     */
    public function timesVoltage(Voltage $voltage): Charge
    {
        return Charge::fromCoulombs($this->value->multipliedBy($voltage->toVolts()));
    }
}
