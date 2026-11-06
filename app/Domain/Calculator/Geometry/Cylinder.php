<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Geometry;

use App\Domain\Calculator\FixedUnit;
use App\Domain\Calculator\RealNumbers;
use App\Domain\Calculator\ResultValue;
use App\Domain\Quantity\Area;
use App\Domain\Quantity\BaseUnit;
use App\Domain\Quantity\Length;
use App\Domain\Quantity\Volume;

/**
 * A right circular cylinder: lateral area 2 × π × r × h, S = 2 × π × r × (r + h), and V = π × r² × h.
 */
final readonly class Cylinder implements SolidFigure
{
    private const int TWO_BASES = 2;

    public function __construct(
        private Length $radius,
        private Length $height,
    ) {}

    /**
     * Two bases and the lateral area, 2 × π × r × (r + h).
     */
    public function surfaceArea(): Area
    {
        return $this->base()->multipliedBy(self::TWO_BASES)->plus($this->lateralArea());
    }

    /**
     * The base times the height, π × r² × h.
     */
    public function volume(): Volume
    {
        return $this->base()->timesLength($this->height);
    }

    /**
     * The lateral area.
     *
     * @return list<ResultValue>
     */
    public function intermediates(): array
    {
        return [ResultValue::quantity('lateral_area', $this->lateralArea(), FixedUnit::of(BaseUnit::SquareMetre))];
    }

    /**
     * π × r².
     */
    private function base(): Area
    {
        return $this->radius->timesLength($this->radius)->multipliedBy(RealNumbers::pi());
    }

    /**
     * The circumference times the height, 2 × π × r × h.
     */
    private function lateralArea(): Area
    {
        return $this->radius->timesLength($this->height)->multipliedBy(RealNumbers::pi())->multipliedBy(self::TWO_BASES);
    }
}
