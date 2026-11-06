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
 * A right pyramid on a square base: its four triangular faces have the slant height g = √(h² + (a / 2)²), so
 * S = a² + 2 × a × g, and V = a² × h / 3.
 */
final readonly class SquarePyramid implements SolidFigure
{
    private const string HALF = '1/2';

    private const string THIRD = '1/3';

    /**
     * Four triangles of area a × g / 2.
     */
    private const int TWICE = 2;

    public function __construct(
        private Length $edge,
        private Length $height,
    ) {}

    /**
     * The base and four triangles, a² + 2 × a × g.
     */
    public function surfaceArea(): Area
    {
        return $this->base()->plus($this->edge->timesLength($this->slantHeight())->multipliedBy(self::TWICE));
    }

    /**
     * One third of the base times the height.
     */
    public function volume(): Volume
    {
        return $this->base()->timesLength($this->height)->multipliedBy(self::THIRD);
    }

    /**
     * The slant height, the height of each triangular face.
     *
     * @return list<ResultValue>
     */
    public function intermediates(): array
    {
        return [ResultValue::quantity('slant_height', $this->slantHeight(), FixedUnit::of(BaseUnit::Metre))];
    }

    /**
     * The area of the square base.
     */
    private function base(): Area
    {
        return $this->edge->timesLength($this->edge);
    }

    /**
     * √(h² + (a / 2)²).
     */
    private function slantHeight(): Length
    {
        $halfEdge = $this->edge->multipliedBy(self::HALF);
        $squared = $this->height->timesLength($this->height)->plus($halfEdge->timesLength($halfEdge));

        return Length::fromMetres(RealNumbers::squareRoot($squared->toSquareMetres()));
    }
}
