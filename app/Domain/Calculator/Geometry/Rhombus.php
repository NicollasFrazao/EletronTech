<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Geometry;

use App\Domain\Calculator\FixedUnit;
use App\Domain\Calculator\RealNumbers;
use App\Domain\Calculator\ResultValue;
use App\Domain\Quantity\Area;
use App\Domain\Quantity\BaseUnit;
use App\Domain\Quantity\Length;

/**
 * A rhombus given by its diagonals, which cross at right angles in their middles: A = D × d / 2, and each side is
 * the hypotenuse of half of each diagonal, s = √((D / 2)² + (d / 2)²), so P = 4 × s.
 */
final readonly class Rhombus implements PlaneFigure
{
    private const string HALF = '1/2';

    private const int SIDES = 4;

    public function __construct(
        private Length $majorDiagonal,
        private Length $minorDiagonal,
    ) {}

    /**
     * The area, D × d / 2.
     */
    public function area(): Area
    {
        return $this->majorDiagonal->timesLength($this->minorDiagonal)->multipliedBy(self::HALF);
    }

    /**
     * The perimeter, four sides.
     */
    public function perimeter(): Length
    {
        return $this->side()->multipliedBy(self::SIDES);
    }

    /**
     * The side.
     *
     * @return list<ResultValue>
     */
    public function intermediates(): array
    {
        return [ResultValue::quantity('side', $this->side(), FixedUnit::of(BaseUnit::Metre))];
    }

    /**
     * √((D / 2)² + (d / 2)²).
     */
    private function side(): Length
    {
        $halfMajor = $this->majorDiagonal->multipliedBy(self::HALF);
        $halfMinor = $this->minorDiagonal->multipliedBy(self::HALF);
        $squared = $halfMajor->timesLength($halfMajor)->plus($halfMinor->timesLength($halfMinor));

        return Length::fromMetres(RealNumbers::squareRoot($squared->toSquareMetres()));
    }
}
