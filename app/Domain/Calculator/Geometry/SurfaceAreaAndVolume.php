<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Geometry;

use App\Domain\Calculator\Calculator;
use App\Domain\Calculator\FixedUnit;
use App\Domain\Calculator\InputField;
use App\Domain\Calculator\Inputs;
use App\Domain\Calculator\InvalidInput;
use App\Domain\Calculator\Result;
use App\Domain\Calculator\ResultValue;
use App\Domain\Quantity\BaseUnit;
use App\Domain\Quantity\Length;

/**
 * Surface area and volume of a solid: the 2015 mobile site's "volumetric shapes" screen, which had a form and no
 * calculation.
 *
 * Each shape reads only the dimensions it is given by (see SolidShape); the others are ignored for that shape.
 */
final readonly class SurfaceAreaAndVolume implements Calculator
{
    private const string SHAPE = 'shape';

    private const string EDGE = 'edge';

    private const string RADIUS = 'radius';

    private const string HEIGHT = 'height';

    /**
     * The tool's identifier.
     */
    public function id(): string
    {
        return 'surface-area-and-volume';
    }

    /**
     * The shape and every dimension a shape can be given by.
     *
     * @return non-empty-list<InputField>
     */
    public function inputs(): array
    {
        $metre = FixedUnit::of(BaseUnit::Metre);

        return [
            InputField::choice(self::SHAPE, SolidShape::cases()),
            InputField::quantity(self::EDGE, $metre)->optional(),
            InputField::quantity(self::RADIUS, $metre)->optional(),
            InputField::quantity(self::HEIGHT, $metre)->optional(),
        ];
    }

    /**
     * The surface area and the volume, with the measures found on the way.
     *
     * @throws InvalidInput When a dimension the shape needs is missing or not greater than zero.
     */
    public function calculate(Inputs $inputs): Result
    {
        $figure = $this->figure($inputs->choice(self::SHAPE, SolidShape::class), $inputs);

        return new Result(
            [
                ResultValue::quantity('surface_area', $figure->surfaceArea(), FixedUnit::of(BaseUnit::SquareMetre)),
                ResultValue::quantity('volume', $figure->volume(), FixedUnit::of(BaseUnit::CubicMetre)),
            ],
            $figure->intermediates(),
        );
    }

    /**
     * The figure of a shape, built from the dimensions it is given by.
     *
     * @throws InvalidInput
     */
    private function figure(SolidShape $shape, Inputs $inputs): SolidFigure
    {
        return match ($shape) {
            SolidShape::Cube => new Cube($this->length($inputs, self::EDGE)),
            SolidShape::SquarePyramid => new SquarePyramid(
                $this->length($inputs, self::EDGE),
                $this->length($inputs, self::HEIGHT),
            ),
            SolidShape::RegularTetrahedron => new RegularTetrahedron($this->length($inputs, self::EDGE)),
            SolidShape::Cone => new Cone($this->length($inputs, self::RADIUS), $this->length($inputs, self::HEIGHT)),
            SolidShape::Cylinder => new Cylinder(
                $this->length($inputs, self::RADIUS),
                $this->length($inputs, self::HEIGHT),
            ),
        };
    }

    /**
     * A dimension the shape needs, greater than zero.
     *
     * @throws InvalidInput
     */
    private function length(Inputs $inputs, string $name): Length
    {
        return $inputs->positiveQuantity($name, Length::class);
    }
}
