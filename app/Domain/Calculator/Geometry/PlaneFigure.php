<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Geometry;

use App\Domain\Calculator\ResultValue;
use App\Domain\Quantity\Area;
use App\Domain\Quantity\Length;

/**
 * A flat shape with its dimensions known: its area, its perimeter and the measures found on the way.
 */
interface PlaneFigure
{
    /**
     * The area enclosed by the shape.
     */
    public function area(): Area;

    /**
     * The length of the shape's outline.
     */
    public function perimeter(): Length;

    /**
     * The measures a person would write down on the way, such as a circle's diameter or a polygon's apothem.
     *
     * @return list<ResultValue>
     */
    public function intermediates(): array;
}
