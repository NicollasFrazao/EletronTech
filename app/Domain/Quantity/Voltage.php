<?php

declare(strict_types=1);

namespace App\Domain\Quantity;

use Brick\Math\BigNumber;
use Brick\Math\BigRational;

/**
 * An electric potential difference, stored in volts.
 */
final readonly class Voltage extends Quantity
{
    /**
     * The dimension every value of this quantity has.
     */
    public static function dimension(): Dimension
    {
        return Dimension::Voltage;
    }

    /**
     * The voltage of a value in volts.
     */
    public static function fromVolts(BigNumber|int|string $volts): self
    {
        return new self(BigRational::of($volts));
    }

    /**
     * The exact value in volts.
     */
    public function toVolts(): BigRational
    {
        return $this->value;
    }

    /**
     * The power a load takes at this voltage and current (P = V × I, for direct current or a resistive load).
     */
    public function timesCurrent(Current $current): Power
    {
        return Power::fromWatts($this->value->multipliedBy($current->toAmperes()));
    }

    /**
     * The resistance that draws this current at this voltage (Ohm's law, R = V / I).
     *
     * @throws DivisionByZero
     *
     * @api
     */
    public function dividedByCurrent(Current $current): Resistance
    {
        return Resistance::fromOhms(self::quotient($this->value, $current->toAmperes()));
    }

    /**
     * The current this voltage drives through a resistance (Ohm's law, I = V / R).
     *
     * @throws DivisionByZero
     *
     * @api
     */
    public function dividedByResistance(Resistance $resistance): Current
    {
        return Current::fromAmperes(self::quotient($this->value, $resistance->toOhms()));
    }
}
