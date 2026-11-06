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
 * A right circular cone: slant height g = √(r² + h²), lateral area π × r × g, S = π × r × (r + g), and
 * V = π × r² × h / 3.
 */
final readonly class Cone implements SolidFigure
{
    private const string THIRD = '1/3';

    public function __construct(
        private Length $radius,
        private Length $height,
    ) {}

    /**
     * The base and the lateral area, π × r × (r + g).
     */
    public function surfaceArea(): Area
    {
        return $this->base()->plus($this->lateralArea());
    }

    /**
     * One third of the base times the height.
     */
    public function volume(): Volume
    {
        return $this->base()->timesLength($this->height)->multipliedBy(self::THIRD);
    }

    /**
     * The slant height and the lateral area.
     *
     * @return list<ResultValue>
     */
    public function intermediates(): array
    {
        return [
            ResultValue::quantity('slant_height', $this->slantHeight(), FixedUnit::of(BaseUnit::Metre)),
            ResultValue::quantity('lateral_area', $this->lateralArea(), FixedUnit::of(BaseUnit::SquareMetre)),
        ];
    }

    /**
     * π × r².
     */
    private function base(): Area
    {
        return $this->radius->timesLength($this->radius)->multipliedBy(RealNumbers::pi());
    }

    /**
     * π × r × g.
     */
    private function lateralArea(): Area
    {
        return $this->radius->timesLength($this->slantHeight())->multipliedBy(RealNumbers::pi());
    }

    /**
     * √(r² + h²).
     */
    private function slantHeight(): Length
    {
        $squared = $this->radius->timesLength($this->radius)->plus($this->height->timesLength($this->height));

        return Length::fromMetres(RealNumbers::squareRoot($squared->toSquareMetres()));
    }
}
