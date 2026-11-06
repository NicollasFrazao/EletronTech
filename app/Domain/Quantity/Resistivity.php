<?php

declare(strict_types=1);

namespace App\Domain\Quantity;

use Brick\Math\BigNumber;
use Brick\Math\BigRational;

/**
 * The electrical resistivity of a material, stored in ohm-metres; electricians read it in Ω·mm²/m (copper is
 * about 0.0172).
 */
final readonly class Resistivity extends Quantity
{
    /**
     * The dimension every value of this quantity has.
     */
    public static function dimension(): Dimension
    {
        return Dimension::Resistivity;
    }

    /**
     * The resistivity of a value in ohm-metres.
     */
    public static function fromOhmMetres(BigNumber|int|string $ohmMetres): self
    {
        return new self(BigRational::of($ohmMetres));
    }

    /**
     * The resistance of a conductor of this material with a length and a cross-section (Ohm's second law,
     * R = ρ × L / A).
     *
     * @throws DivisionByZero
     */
    public function resistanceOf(Length $length, Area $crossSection): Resistance
    {
        return Resistance::fromOhms(
            self::quotient($this->value->multipliedBy($length->toMetres()), $crossSection->toSquareMetres()),
        );
    }
}
