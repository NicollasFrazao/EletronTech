<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Geometry;

use App\Domain\Calculator\Calculator;
use App\Domain\Calculator\FixedUnit;
use App\Domain\Calculator\InputField;
use App\Domain\Calculator\InputProblem;
use App\Domain\Calculator\Inputs;
use App\Domain\Calculator\InvalidInput;
use App\Domain\Calculator\Result;
use App\Domain\Calculator\ResultValue;
use App\Domain\Quantity\BaseUnit;
use App\Domain\Quantity\Length;

/**
 * Area and perimeter of a flat shape: a rectangle (the 2015 tool), and the shapes of the 2015 mobile site's
 * unfinished "surface shapes" screen.
 *
 * Each shape reads only the dimensions it is given by (see PlaneShape); the others are optional in the schema and
 * ignored for that shape.
 */
final readonly class AreaAndPerimeter implements Calculator
{
    private const string SHAPE = 'shape';

    private const array DIMENSIONS = [
        'length', 'width', 'side', 'radius', 'side_a', 'side_b', 'side_c',
        'major_diagonal', 'minor_diagonal', 'base', 'height', 'major_base', 'minor_base',
    ];

    /**
     * The tool's identifier.
     */
    public function id(): string
    {
        return 'area-and-perimeter';
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
            InputField::choice(self::SHAPE, PlaneShape::cases()),
            ...array_map(
                static fn (string $name): InputField => InputField::quantity($name, $metre)->optional(),
                self::DIMENSIONS,
            ),
        ];
    }

    /**
     * The area and the perimeter, with the measures found on the way.
     *
     * @throws InvalidInput When a dimension the shape needs is missing or not greater than zero, or the dimensions
     *                      do not make up the shape.
     */
    public function calculate(Inputs $inputs): Result
    {
        $figure = $this->figure($inputs->choice(self::SHAPE, PlaneShape::class), $inputs);

        return new Result(
            [
                ResultValue::quantity('area', $figure->area(), FixedUnit::of(BaseUnit::SquareMetre)),
                ResultValue::quantity('perimeter', $figure->perimeter(), FixedUnit::of(BaseUnit::Metre)),
            ],
            $figure->intermediates(),
        );
    }

    /**
     * The figure of a shape, built from the dimensions it is given by.
     *
     * @throws InvalidInput
     */
    private function figure(PlaneShape $shape, Inputs $inputs): PlaneFigure
    {
        $figure = match ($shape) {
            PlaneShape::Rectangle => new Rectangle(...$this->lengths($inputs, 'length', 'width')),
            PlaneShape::Square => new Rectangle(...$this->lengths($inputs, 'side', 'side')),
            PlaneShape::Circle => new Circle(...$this->lengths($inputs, 'radius')),
            PlaneShape::Triangle => Triangle::tryOf(...$this->lengths($inputs, 'side_a', 'side_b', 'side_c')),
            PlaneShape::Rhombus => new Rhombus(...$this->lengths($inputs, 'major_diagonal', 'minor_diagonal')),
            PlaneShape::Parallelogram => Parallelogram::tryOf(...$this->lengths($inputs, 'base', 'side', 'height')),
            PlaneShape::Trapezoid => Trapezoid::tryOf(
                ...$this->lengths($inputs, 'major_base', 'minor_base', 'side_a', 'side_b'),
            ),
            PlaneShape::RegularPentagon => RegularPolygon::pentagon(...$this->lengths($inputs, 'side')),
            PlaneShape::RegularHexagon => RegularPolygon::hexagon(...$this->lengths($inputs, 'side')),
        };

        return $figure ?? throw InvalidInput::of(InvalidInput::ALL_INPUTS, InputProblem::NoSolution);
    }

    /**
     * The dimensions a shape needs, in order, each greater than zero.
     *
     * @return list<Length>
     *
     * @throws InvalidInput
     */
    private function lengths(Inputs $inputs, string ...$names): array
    {
        $lengths = [];

        foreach ($names as $name) {
            $lengths[] = $inputs->positiveQuantity($name, Length::class);
        }

        return $lengths;
    }
}
