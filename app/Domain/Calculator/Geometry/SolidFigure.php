<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Geometry;

use App\Domain\Calculator\ResultValue;
use App\Domain\Quantity\Area;
use App\Domain\Quantity\Volume;

/**
 * A solid with its dimensions known: its total surface area, its volume and the measures found on the way.
 */
interface SolidFigure
{
    /**
     * The area of every face together, bases included.
     */
    public function surfaceArea(): Area;

    /**
     * The space the solid encloses.
     */
    public function volume(): Volume;

    /**
     * The measures a person would write down on the way, such as a cone's slant height.
     *
     * @return list<ResultValue>
     */
    public function intermediates(): array;
}
