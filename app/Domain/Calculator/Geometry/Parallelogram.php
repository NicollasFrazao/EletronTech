<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Geometry;

use App\Domain\Calculator\ResultValue;
use App\Domain\Quantity\Area;
use App\Domain\Quantity\Length;

/**
 * A parallelogram (a rhomboid when its sides differ) given by its base, its slanted side and its height:
 * A = b × h, P = 2 × (b + s).
 */
final readonly class Parallelogram implements PlaneFigure
{
    private const int SIDES_OF_EACH_LENGTH = 2;

    private function __construct(
        private Length $base,
        private Length $side,
        private Length $height,
    ) {}

    /**
     * The parallelogram with these measures; null when the height is longer than the slanted side, which no
     * parallelogram has (the height is at most the side, when the shape is a rectangle).
     */
    public static function tryOf(Length $base, Length $side, Length $height): ?self
    {
        return $height->isGreaterThan($side) ? null : new self($base, $side, $height);
    }

    /**
     * The area, b × h.
     */
    public function area(): Area
    {
        return $this->base->timesLength($this->height);
    }

    /**
     * The perimeter, 2 × (b + s).
     */
    public function perimeter(): Length
    {
        return $this->base->plus($this->side)->multipliedBy(self::SIDES_OF_EACH_LENGTH);
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
