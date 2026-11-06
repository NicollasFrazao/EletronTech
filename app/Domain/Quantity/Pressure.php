<?php

declare(strict_types=1);

namespace App\Domain\Quantity;

use Brick\Math\BigNumber;
use Brick\Math\BigRational;

/**
 * A pressure, or an energy per unit of volume, stored in pascals.
 *
 * A negative value is a gauge pressure below the atmosphere's; whether it makes sense is the calculator's rule.
 */
final readonly class Pressure extends Quantity
{
    /**
     * The dimension every value of this quantity has.
     */
    public static function dimension(): Dimension
    {
        return Dimension::Pressure;
    }

    /**
     * The pressure of a value in pascals.
     */
    public static function fromPascals(BigNumber|int|string $pascals): self
    {
        return new self(BigRational::of($pascals));
    }
}
