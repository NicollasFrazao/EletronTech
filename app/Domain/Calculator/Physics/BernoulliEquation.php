<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Physics;

use App\Domain\Calculator\Calculator;
use App\Domain\Calculator\FixedUnit;
use App\Domain\Calculator\InputField;
use App\Domain\Calculator\InputProblem;
use App\Domain\Calculator\Inputs;
use App\Domain\Calculator\InvalidInput;
use App\Domain\Calculator\RealNumbers;
use App\Domain\Calculator\Result;
use App\Domain\Calculator\ResultValue;
use App\Domain\Quantity\BaseUnit;
use App\Domain\Quantity\Density;
use App\Domain\Quantity\DivisionByZero;
use App\Domain\Quantity\Length;
use App\Domain\Quantity\Pressure;
use App\Domain\Quantity\Velocity;

/**
 * Bernoulli's equation for an ideal fluid (incompressible, without friction) along a pipe, between two points:
 *
 *     p₁ + ½ × ρ × v₁² + ρ × g₀ × h₁ = p₂ + ½ × ρ × v₂² + ρ × g₀ × h₂
 *
 * solved for whichever of the six values is left empty, with standard gravity g₀ = 9.80665 m/s².
 *
 * The side with the unknown must make up the other side's total: the unknown term is that total minus the side's
 * known terms. A pressure may be negative (a gauge pressure below the atmosphere) and so may a height (below the
 * reference level); a speed cannot, so when the remaining term is negative no speed solves the equation.
 */
final readonly class BernoulliEquation implements Calculator
{
    private const string DENSITY = 'density';

    private const string PRESSURE = 'pressure_';

    private const string VELOCITY = 'velocity_';

    private const string HEIGHT = 'height_';

    private const array POINTS = ['1', '2'];

    /**
     * The tool's identifier.
     */
    public function id(): string
    {
        return 'bernoulli-equation';
    }

    /**
     * The fluid's density, then the pressure, velocity and height at each point; exactly one of those six is left
     * empty.
     *
     * @return non-empty-list<InputField>
     */
    public function inputs(): array
    {
        $fields = [InputField::quantity(self::DENSITY, FixedUnit::of(BaseUnit::KilogramPerCubicMetre))];

        foreach (self::POINTS as $point) {
            $fields[] = InputField::quantity(self::PRESSURE.$point, FixedUnit::of(BaseUnit::Pascal))->optional();
            $fields[] = InputField::quantity(self::VELOCITY.$point, FixedUnit::of(BaseUnit::MetrePerSecond))->optional();
            $fields[] = InputField::quantity(self::HEIGHT.$point, FixedUnit::of(BaseUnit::Metre))->optional();
        }

        return $fields;
    }

    /**
     * The six values, the one left empty calculated from the others, and the total pressure both points share.
     *
     * @throws InvalidInput When the density is not greater than zero, not exactly one value is empty, a velocity is
     *                      negative, or no speed solves the equation.
     * @throws DivisionByZero
     */
    public function calculate(Inputs $inputs): Result
    {
        $density = $inputs->positiveQuantity(self::DENSITY, Density::class);
        [$unknown] = $inputs->missing($this->pointValueNames(), 1);
        [$knownPoint, $unknownPoint] = str_ends_with($unknown, self::POINTS[0]) ? array_reverse(self::POINTS) : self::POINTS;

        $known = $this->point($inputs, $knownPoint);
        $total = $known->totalPressure($density);
        $partial = $this->partialPoint($inputs, $unknownPoint);
        $solved = $this->solve($unknown, $partial, $total->minus($partial->totalPressure($density)), $density);

        [$first, $second] = $unknownPoint === self::POINTS[0] ? [$solved, $known] : [$known, $solved];

        return new Result(
            [...$this->values($first, self::POINTS[0]), ...$this->values($second, self::POINTS[1])],
            [ResultValue::quantity('total_pressure', $total, FixedUnit::of(BaseUnit::Pascal))],
        );
    }

    /**
     * The names of the six values of the two points.
     *
     * @return non-empty-list<string>
     */
    private function pointValueNames(): array
    {
        $names = [];

        foreach (self::POINTS as $point) {
            $names[] = self::PRESSURE.$point;
            $names[] = self::VELOCITY.$point;
            $names[] = self::HEIGHT.$point;
        }

        return $names;
    }

    /**
     * A point with all three values given.
     *
     * @throws InvalidInput
     */
    private function point(Inputs $inputs, string $point): FlowPoint
    {
        return new FlowPoint(
            $inputs->quantity(self::PRESSURE.$point, Pressure::class),
            $inputs->nonNegativeQuantity(self::VELOCITY.$point, Velocity::class),
            $inputs->quantity(self::HEIGHT.$point, Length::class),
        );
    }

    /**
     * The point with the unknown, its empty value taken as zero so that its total is the sum of its known terms.
     *
     * @throws InvalidInput
     */
    private function partialPoint(Inputs $inputs, string $point): FlowPoint
    {
        $has = $inputs->has(...);

        return new FlowPoint(
            $has(self::PRESSURE.$point) ? $inputs->quantity(self::PRESSURE.$point, Pressure::class) : Pressure::zero(),
            $has(self::VELOCITY.$point)
                ? $inputs->nonNegativeQuantity(self::VELOCITY.$point, Velocity::class)
                : Velocity::zero(),
            $has(self::HEIGHT.$point) ? $inputs->quantity(self::HEIGHT.$point, Length::class) : Length::zero(),
        );
    }

    /**
     * The point completed with the value whose term is the remainder: a pressure is the remainder itself, a
     * velocity has ½ × ρ × v² equal to it, a height has ρ × g₀ × h equal to it.
     *
     * @throws InvalidInput When the remainder is negative and the unknown is a velocity.
     * @throws DivisionByZero
     */
    private function solve(string $unknown, FlowPoint $partial, Pressure $remainder, Density $density): FlowPoint
    {
        return match (true) {
            str_starts_with($unknown, self::PRESSURE) => $partial->withPressure($remainder),
            str_starts_with($unknown, self::VELOCITY) => $partial->withVelocity($this->speedFor($remainder, $density)),
            default => $partial->withHeight(
                Length::fromMetres($remainder->ratioTo($density->hydrostaticPressureAt(Length::fromMetres(1)))),
            ),
        };
    }

    /**
     * The speed whose dynamic pressure is the remainder: q grows with v², so v² in (m/s)² is the remainder over the
     * dynamic pressure at 1 m/s.
     *
     * @throws InvalidInput
     * @throws DivisionByZero
     */
    private function speedFor(Pressure $remainder, Density $density): Velocity
    {
        if ($remainder->isNegative()) {
            throw InvalidInput::of(InvalidInput::ALL_INPUTS, InputProblem::NoSolution);
        }

        $squared = $remainder->ratioTo($density->dynamicPressureAt(Velocity::fromMetresPerSecond(1)));

        return Velocity::fromMetresPerSecond(RealNumbers::squareRoot($squared));
    }

    /**
     * The three values of a point, as results.
     *
     * @return non-empty-list<ResultValue>
     */
    private function values(FlowPoint $point, string $suffix): array
    {
        return [
            ResultValue::quantity(self::PRESSURE.$suffix, $point->pressure, FixedUnit::of(BaseUnit::Pascal)),
            ResultValue::quantity(self::VELOCITY.$suffix, $point->velocity, FixedUnit::of(BaseUnit::MetrePerSecond)),
            ResultValue::quantity(self::HEIGHT.$suffix, $point->height, FixedUnit::of(BaseUnit::Metre)),
        ];
    }
}
