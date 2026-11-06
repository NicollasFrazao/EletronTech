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
 * A triangle given by its three sides: P = a + b + c, and the area by Heron's formula,
 * A = √(s × (s − a) × (s − b) × (s − c)) with the semi-perimeter s = P / 2.
 */
final readonly class Triangle implements PlaneFigure
{
    private const string HALF = '1/2';

    private function __construct(
        private Length $first,
        private Length $second,
        private Length $third,
    ) {}

    /**
     * The triangle with these sides; null unless each side is shorter than the other two together (the triangle
     * inequality), since otherwise the sides do not close into a triangle.
     */
    public static function tryOf(Length $first, Length $second, Length $third): ?self
    {
        $closes = $first->isLessThan($second->plus($third))
            && $second->isLessThan($first->plus($third))
            && $third->isLessThan($first->plus($second));

        return $closes ? new self($first, $second, $third) : null;
    }

    /**
     * The area, by Heron's formula.
     */
    public function area(): Area
    {
        $semi = $this->semiPerimeter();
        $product = $semi->toMetres()
            ->multipliedBy($semi->minus($this->first)->toMetres())
            ->multipliedBy($semi->minus($this->second)->toMetres())
            ->multipliedBy($semi->minus($this->third)->toMetres());

        return Area::fromSquareMetres(RealNumbers::squareRoot($product));
    }

    /**
     * The perimeter, a + b + c.
     */
    public function perimeter(): Length
    {
        return $this->first->plus($this->second)->plus($this->third);
    }

    /**
     * The semi-perimeter Heron's formula starts from.
     *
     * @return list<ResultValue>
     */
    public function intermediates(): array
    {
        return [ResultValue::quantity('semi_perimeter', $this->semiPerimeter(), FixedUnit::of(BaseUnit::Metre))];
    }

    /**
     * Half the perimeter.
     */
    private function semiPerimeter(): Length
    {
        return $this->perimeter()->multipliedBy(self::HALF);
    }
}
