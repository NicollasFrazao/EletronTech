<?php

declare(strict_types=1);

namespace App\Domain\Quantity;

use Brick\Math\BigNumber;
use Brick\Math\BigRational;

/**
 * The mass per unit of volume of a material or a fluid, stored in kilograms per cubic metre.
 */
final readonly class Density extends Quantity
{
    /**
     * Standard gravity, g₀ = 9.80665 m/s², exact by definition (CGPM 1901); the acceleration a column of fluid is
     * weighed under.
     */
    private const string STANDARD_GRAVITY = '9.80665';

    /**
     * The kinetic energy per unit of volume is half the density times the square of the speed.
     */
    private const int HALF = 2;

    /**
     * The dimension every value of this quantity has.
     */
    public static function dimension(): Dimension
    {
        return Dimension::Density;
    }

    /**
     * The density of a value in kilograms per cubic metre.
     */
    public static function fromKilogramsPerCubicMetre(BigNumber|int|string $kilogramsPerCubicMetre): self
    {
        return new self(BigRational::of($kilogramsPerCubicMetre));
    }

    /**
     * The dynamic pressure of a fluid of this density moving at a velocity: its kinetic energy per unit of
     * volume, q = ½ × ρ × v².
     */
    public function dynamicPressureAt(Velocity $velocity): Pressure
    {
        $speed = $velocity->toMetresPerSecond();

        return Pressure::fromPascals($this->value->multipliedBy($speed)->multipliedBy($speed)->dividedBy(self::HALF));
    }

    /**
     * The pressure of a column of a fluid of this density as tall as a height, under standard gravity: its
     * potential energy per unit of volume, p = ρ × g₀ × h.
     */
    public function hydrostaticPressureAt(Length $height): Pressure
    {
        return Pressure::fromPascals(
            $this->value->multipliedBy(self::STANDARD_GRAVITY)->multipliedBy($height->toMetres()),
        );
    }
}
