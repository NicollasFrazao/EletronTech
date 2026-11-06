<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Geometry;

use App\Domain\Calculator\FixedUnit;
use App\Domain\Calculator\ResultValue;
use App\Domain\Quantity\Area;
use App\Domain\Quantity\BaseUnit;
use App\Domain\Quantity\Length;

/**
 * A trapezoid given by its four sides: the parallel major and minor bases and the two legs. P = B + b + c + d;
 * A = (B + b) × h / 2.
 *
 * Moving one leg along the bases until it meets the other leaves a triangle with sides B − b, c and d and the
 * trapezoid's height, so h = 2 × (area of that triangle) / (B − b), the area by Heron's formula.
 */
final readonly class Trapezoid implements PlaneFigure
{
    private const string HALF = '1/2';

    private const int TWICE = 2;

    /**
     * @param  Length  $legs  Both legs together.
     * @param  Triangle  $legsTriangle  The triangle of sides B − b, c and d.
     */
    private function __construct(
        private Length $majorBase,
        private Length $minorBase,
        private Length $legs,
        private Triangle $legsTriangle,
    ) {}

    /**
     * The trapezoid with these sides; null unless the major base is longer than the minor one and the legs close
     * a triangle with their difference, which every trapezoid's sides do.
     */
    public static function tryOf(Length $majorBase, Length $minorBase, Length $firstLeg, Length $secondLeg): ?self
    {
        if (! $majorBase->isGreaterThan($minorBase)) {
            return null;
        }

        $triangle = Triangle::tryOf($majorBase->minus($minorBase), $firstLeg, $secondLeg);

        return $triangle instanceof Triangle
            ? new self($majorBase, $minorBase, $firstLeg->plus($secondLeg), $triangle)
            : null;
    }

    /**
     * The area, (B + b) × h / 2.
     */
    public function area(): Area
    {
        return $this->majorBase->plus($this->minorBase)->timesLength($this->height())->multipliedBy(self::HALF);
    }

    /**
     * The perimeter, B + b + c + d.
     */
    public function perimeter(): Length
    {
        return $this->majorBase->plus($this->minorBase)->plus($this->legs);
    }

    /**
     * The height.
     *
     * @return list<ResultValue>
     */
    public function intermediates(): array
    {
        return [ResultValue::quantity('height', $this->height(), FixedUnit::of(BaseUnit::Metre))];
    }

    /**
     * Twice the area of the legs' triangle over its base, B − b, which is never zero.
     */
    private function height(): Length
    {
        $base = $this->majorBase->minus($this->minorBase)->toMetres();

        return Length::fromMetres(
            $this->legsTriangle->area()->toSquareMetres()->multipliedBy(self::TWICE)->dividedBy($base),
        );
    }
}
