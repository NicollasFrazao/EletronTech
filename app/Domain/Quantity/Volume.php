<?php

declare(strict_types=1);

namespace App\Domain\Quantity;

use Brick\Math\BigNumber;
use Brick\Math\BigRational;

/**
 * A volume, stored in cubic metres.
 */
final readonly class Volume extends Quantity
{
    /**
     * The dimension every value of this quantity has.
     */
    public static function dimension(): Dimension
    {
        return Dimension::Volume;
    }

    /**
     * The volume of a value in cubic metres.
     */
    public static function fromCubicMetres(BigNumber|int|string $cubicMetres): self
    {
        return new self(BigRational::of($cubicMetres));
    }
}
