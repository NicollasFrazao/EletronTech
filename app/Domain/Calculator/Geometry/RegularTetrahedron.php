<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Geometry;

use App\Domain\Calculator\RealNumbers;
use App\Domain\Calculator\ResultValue;
use App\Domain\Quantity\Area;
use App\Domain\Quantity\Length;
use App\Domain\Quantity\Volume;
use Brick\Math\BigRational;

/**
 * A regular tetrahedron: four equilateral triangles, S = √3 × a², and V = a³ / (6 × √2) = √2 × a³ / 12.
 */
final readonly class RegularTetrahedron implements SolidFigure
{
    private const int THREE = 3;

    private const int TWO = 2;

    private const int TWELVE = 12;

    public function __construct(
        private Length $edge,
    ) {}

    /**
     * Four equilateral triangles, √3 × a².
     */
    public function surfaceArea(): Area
    {
        return $this->square()->multipliedBy(RealNumbers::squareRoot(BigRational::of(self::THREE)));
    }

    /**
     * √2 × a³ / 12.
     */
    public function volume(): Volume
    {
        $factor = RealNumbers::squareRoot(BigRational::of(self::TWO))->dividedBy(self::TWELVE);

        return $this->square()->timesLength($this->edge)->multipliedBy($factor);
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
     * a².
     */
    private function square(): Area
    {
        return $this->edge->timesLength($this->edge);
    }
}
