<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Geometry;

use App\Domain\Calculator\FixedUnit;
use App\Domain\Calculator\RealNumbers;
use App\Domain\Calculator\ResultValue;
use App\Domain\Quantity\Area;
use App\Domain\Quantity\BaseUnit;
use App\Domain\Quantity\Length;
use Brick\Math\BigRational;

/**
 * A regular pentagon or hexagon given by its side: P = n × s, and A = P × a / 2 with the apothem
 * a = s / (2 × tan(180° / n)), the distance from the centre to the middle of a side.
 *
 * tan 30° = 1 / √3 and tan 36° = √(5 − 2√5) are written with square roots, so no trigonometry is needed.
 */
final readonly class RegularPolygon implements PlaneFigure
{
    private const string HALF = '1/2';

    private const int PENTAGON_SIDES = 5;

    private const int HEXAGON_SIDES = 6;

    /**
     * tan²(30°), the hexagon's half-angle.
     */
    private const string HEXAGON_TANGENT_SQUARED = '1/3';

    /**
     * The 5 of tan²(36°) = 5 − 2√5, the pentagon's half-angle.
     */
    private const int FIVE = 5;

    private const int TWICE = 2;

    /**
     * @param  BigRational  $apothemPerSide  The apothem of a polygon of side one: 1 / (2 × tan(180° / n)).
     */
    private function __construct(
        private Length $side,
        private int $sides,
        private BigRational $apothemPerSide,
    ) {}

    /**
     * A regular pentagon: a = s / (2 × √(5 − 2√5)).
     */
    public static function pentagon(Length $side): self
    {
        $five = BigRational::of(self::FIVE);
        $tangentSquared = $five->minus(RealNumbers::squareRoot($five)->multipliedBy(self::TWICE));

        return new self($side, self::PENTAGON_SIDES, self::apothemPerSide($tangentSquared));
    }

    /**
     * A regular hexagon: a = s / (2 × tan 30°) = s × √3 / 2.
     */
    public static function hexagon(Length $side): self
    {
        return new self($side, self::HEXAGON_SIDES, self::apothemPerSide(BigRational::of(self::HEXAGON_TANGENT_SQUARED)));
    }

    /**
     * The area, P × a / 2.
     */
    public function area(): Area
    {
        return $this->perimeter()->timesLength($this->apothem())->multipliedBy(self::HALF);
    }

    /**
     * The perimeter, n × s.
     */
    public function perimeter(): Length
    {
        return $this->side->multipliedBy($this->sides);
    }

    /**
     * The apothem.
     *
     * @return list<ResultValue>
     */
    public function intermediates(): array
    {
        return [ResultValue::quantity('apothem', $this->apothem(), FixedUnit::of(BaseUnit::Metre))];
    }

    /**
     * The apothem of a polygon of side one, from the square of the tangent of its half-angle: 1 / (2 × tan).
     */
    private static function apothemPerSide(BigRational $tangentSquared): BigRational
    {
        return BigRational::one()->dividedBy(RealNumbers::squareRoot($tangentSquared)->multipliedBy(self::TWICE));
    }

    /**
     * The distance from the centre to the middle of a side.
     */
    private function apothem(): Length
    {
        return $this->side->multipliedBy($this->apothemPerSide);
    }
}
