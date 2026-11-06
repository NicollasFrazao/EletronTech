<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Physics;

use App\Domain\Quantity\Density;
use App\Domain\Quantity\Length;
use App\Domain\Quantity\Pressure;
use App\Domain\Quantity\Velocity;

/**
 * One point of a flow along a pipe: the fluid's pressure, its velocity and the point's height above a reference
 * level.
 */
final readonly class FlowPoint
{
    public function __construct(
        public Pressure $pressure,
        public Velocity $velocity,
        public Length $height,
    ) {}

    /**
     * The fluid's energy per unit of volume at this point, the quantity Bernoulli's equation keeps constant:
     * p + ½ × ρ × v² + ρ × g₀ × h.
     */
    public function totalPressure(Density $density): Pressure
    {
        return $this->pressure
            ->plus($density->dynamicPressureAt($this->velocity))
            ->plus($density->hydrostaticPressureAt($this->height));
    }

    /**
     * The same point with another pressure.
     */
    public function withPressure(Pressure $pressure): self
    {
        return new self($pressure, $this->velocity, $this->height);
    }

    /**
     * The same point with another velocity.
     */
    public function withVelocity(Velocity $velocity): self
    {
        return new self($this->pressure, $velocity, $this->height);
    }

    /**
     * The same point with another height.
     */
    public function withHeight(Length $height): self
    {
        return new self($this->pressure, $this->velocity, $height);
    }
}
