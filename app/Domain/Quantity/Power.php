<?php

declare(strict_types=1);

namespace App\Domain\Quantity;

use Brick\Math\BigNumber;
use Brick\Math\BigRational;

/**
 * Active power, stored in watts.
 */
final readonly class Power extends Quantity
{
    /**
     * The dimension every value of this quantity has.
     */
    public static function dimension(): Dimension
    {
        return Dimension::Power;
    }

    /**
     * The power of a value in watts.
     */
    public static function fromWatts(BigNumber|int|string $watts): self
    {
        return new self(BigRational::of($watts));
    }

    /**
     * The exact value in watts.
     */
    public function toWatts(): BigRational
    {
        return $this->value;
    }

    /**
     * The current a load of this power draws at a voltage (I = P / V).
     *
     * @throws DivisionByZero
     */
    public function dividedByVoltage(Voltage $voltage): Current
    {
        return Current::fromAmperes(self::quotient($this->value, $voltage->toVolts()));
    }

    /**
     * The voltage at which a load of this power draws a current (V = P / I).
     *
     * @throws DivisionByZero
     */
    public function dividedByCurrent(Current $current): Voltage
    {
        return Voltage::fromVolts(self::quotient($this->value, $current->toAmperes()));
    }

    /**
     * The apparent power a load of this active power takes at a power factor (S = P / pf).
     *
     * @api
     */
    public function dividedByPowerFactor(PowerFactor $powerFactor): ApparentPower
    {
        return ApparentPower::fromVoltAmperes($this->value->dividedBy($powerFactor->value()));
    }

    /**
     * The energy a load of this power uses over a duration (E = P × t).
     */
    public function timesDuration(Duration $duration): Energy
    {
        return Energy::fromJoules($this->value->multipliedBy($duration->toSeconds()));
    }
}
