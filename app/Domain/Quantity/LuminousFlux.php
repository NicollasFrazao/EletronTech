<?php

declare(strict_types=1);

namespace App\Domain\Quantity;

use Brick\Math\BigNumber;
use Brick\Math\BigRational;

/**
 * A luminous flux, the light a source emits as the eye perceives it, stored in lumens.
 */
final readonly class LuminousFlux extends Quantity
{
    /**
     * The dimension every value of this quantity has.
     */
    public static function dimension(): Dimension
    {
        return Dimension::LuminousFlux;
    }

    /**
     * The luminous flux of a value in lumens.
     */
    public static function fromLumens(BigNumber|int|string $lumens): self
    {
        return new self(BigRational::of($lumens));
    }
}
