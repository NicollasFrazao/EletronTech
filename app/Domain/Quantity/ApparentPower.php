<?php

declare(strict_types=1);

namespace App\Domain\Quantity;

use Brick\Math\BigNumber;
use Brick\Math\BigRational;

/**
 * Apparent power, the product of RMS voltage and current, stored in volt-amperes.
 */
final readonly class ApparentPower extends Quantity
{
    /**
     * The dimension every value of this quantity has.
     */
    public static function dimension(): Dimension
    {
        return Dimension::ApparentPower;
    }

    /**
     * The apparent power of a value in volt-amperes.
     */
    public static function fromVoltAmperes(BigNumber|int|string $voltAmperes): self
    {
        return new self(BigRational::of($voltAmperes));
    }

    /**
     * The apparent power of a load that draws an RMS current at an RMS voltage (S = V × I).
     */
    public static function fromVoltageAndCurrent(Voltage $voltage, Current $current): self
    {
        return new self($voltage->toVolts()->multipliedBy($current->toAmperes()));
    }

    /**
     * The exact value in volt-amperes.
     */
    public function toVoltAmperes(): BigRational
    {
        return $this->value;
    }

    /**
     * The active power of a load of this apparent power at a power factor (P = S × pf).
     */
    public function timesPowerFactor(PowerFactor $powerFactor): Power
    {
        return Power::fromWatts($this->value->multipliedBy($powerFactor->value()));
    }

    /**
     * The current a load of this apparent power draws at a voltage (I = S / V), as circuits are sized.
     *
     * @throws DivisionByZero
     */
    public function dividedByVoltage(Voltage $voltage): Current
    {
        return Current::fromAmperes(self::quotient($this->value, $voltage->toVolts()));
    }
}
