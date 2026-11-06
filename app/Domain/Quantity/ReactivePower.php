<?php

declare(strict_types=1);

namespace App\Domain\Quantity;

use Brick\Math\BigNumber;
use Brick\Math\BigRational;

/**
 * Reactive power, the part of the apparent power that flows back and forth without doing work, stored in
 * volt-amperes reactive.
 */
final readonly class ReactivePower extends Quantity
{
    /**
     * The dimension every value of this quantity has.
     */
    public static function dimension(): Dimension
    {
        return Dimension::ReactivePower;
    }

    /**
     * The reactive power of a value in volt-amperes reactive.
     */
    public static function fromVoltAmperesReactive(BigNumber|int|string $voltAmperesReactive): self
    {
        return new self(BigRational::of($voltAmperesReactive));
    }
}
