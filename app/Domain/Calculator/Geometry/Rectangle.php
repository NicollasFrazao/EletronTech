<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Geometry;

use App\Domain\Calculator\ResultValue;
use App\Domain\Quantity\Area;
use App\Domain\Quantity\Length;

/**
 * A rectangle, or a square when both sides are equal: A = l × w, P = 2 × (l + w).
 */
final readonly class Rectangle implements PlaneFigure
{
    private const int SIDES_OF_EACH_LENGTH = 2;

    public function __construct(
        private Length $length,
        private Length $width,
    ) {}

    /**
     * The area, l × w.
     */
    public function area(): Area
    {
        return $this->length->timesLength($this->width);
    }

    /**
     * The perimeter, 2 × (l + w).
     */
    public function perimeter(): Length
    {
        return $this->length->plus($this->width)->multipliedBy(self::SIDES_OF_EACH_LENGTH);
    }

    /**
     * Nothing: the area and the perimeter are one step each.
     *
     * @return list<ResultValue>
     */
    public function intermediates(): array
    {
        return [];
    }
}
