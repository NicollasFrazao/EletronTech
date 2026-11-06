<?php

declare(strict_types=1);

namespace App\Domain\Quantity;

use Brick\Math\BigNumber;
use Brick\Math\BigRational;

/**
 * An illuminance, the luminous flux falling on each unit of area, stored in lux.
 */
final readonly class Illuminance extends Quantity
{
    /**
     * The dimension every value of this quantity has.
     */
    public static function dimension(): Dimension
    {
        return Dimension::Illuminance;
    }

    /**
     * The illuminance of a value in lux.
     */
    public static function fromLux(BigNumber|int|string $lux): self
    {
        return new self(BigRational::of($lux));
    }

    /**
     * The luminous flux that falls on an area lit at this illuminance (Φ = E × A).
     */
    public function timesArea(Area $area): LuminousFlux
    {
        return LuminousFlux::fromLumens($this->value->multipliedBy($area->toSquareMetres()));
    }
}
