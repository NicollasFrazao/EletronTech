<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Geometry;

use App\Domain\Calculator\ResultValue;
use App\Domain\Quantity\Area;
use App\Domain\Quantity\Length;
use App\Domain\Quantity\Volume;

/**
 * A cube: six square faces, S = 6 × a², and V = a³.
 */
final readonly class Cube implements SolidFigure
{
    private const int FACES = 6;

    public function __construct(
        private Length $edge,
    ) {}

    /**
     * Six faces of a².
     */
    public function surfaceArea(): Area
    {
        return $this->face()->multipliedBy(self::FACES);
    }

    /**
     * a³.
     */
    public function volume(): Volume
    {
        return $this->face()->timesLength($this->edge);
    }

    /**
     * Nothing: each value is one step.
     *
     * @return list<ResultValue>
     */
    public function intermediates(): array
    {
        return [];
    }

    /**
     * The area of one face.
     */
    private function face(): Area
    {
        return $this->edge->timesLength($this->edge);
    }
}
