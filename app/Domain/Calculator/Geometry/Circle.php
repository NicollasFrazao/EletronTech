<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Geometry;

use App\Domain\Calculator\FixedUnit;
use App\Domain\Calculator\RealNumbers;
use App\Domain\Calculator\ResultValue;
use App\Domain\Quantity\Area;
use App\Domain\Quantity\BaseUnit;
use App\Domain\Quantity\Length;

/**
 * A circle: A = π × r², and its perimeter is the circumference, C = 2 × π × r.
 */
final readonly class Circle implements PlaneFigure
{
    private const int DIAMETER_IN_RADII = 2;

    public function __construct(
        private Length $radius,
    ) {}

    /**
     * The area, π × r².
     */
    public function area(): Area
    {
        return $this->radius->timesLength($this->radius)->multipliedBy(RealNumbers::pi());
    }

    /**
     * The circumference, π × d.
     */
    public function perimeter(): Length
    {
        return $this->diameter()->multipliedBy(RealNumbers::pi());
    }

    /**
     * The diameter.
     *
     * @return list<ResultValue>
     */
    public function intermediates(): array
    {
        return [ResultValue::quantity('diameter', $this->diameter(), FixedUnit::of(BaseUnit::Metre))];
    }

    /**
     * Twice the radius.
     */
    private function diameter(): Length
    {
        return $this->radius->multipliedBy(self::DIAMETER_IN_RADII);
    }
}
