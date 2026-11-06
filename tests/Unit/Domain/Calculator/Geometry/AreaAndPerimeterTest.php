<?php

declare(strict_types=1);

use App\Domain\Calculator\Geometry\AreaAndPerimeter;
use App\Domain\Calculator\InputProblem;
use App\Domain\Calculator\Inputs;
use App\Domain\Calculator\Result;
use App\Domain\Quantity\Length;
use Tests\Support\Results;

// Plane geometry: rectangle A = l × w, P = 2(l + w); circle A = πr², C = 2πr; triangle by Heron's formula,
// A = √(s(s − a)(s − b)(s − c)); rhombus A = D × d / 2, side √((D/2)² + (d/2)²); parallelogram A = b × h;
// trapezoid A = (B + b) × h / 2, h from the triangle of sides B − b and the legs; regular polygon A = P × a / 2,
// apothem a = s / (2 tan(180°/n)), so a = s√3/2 for the hexagon and 0.688190960236 × s for the pentagon.

/**
 * The result for a shape, its dimensions given in metres.
 *
 * @param  array<string, int|string>  $metres
 */
function planeFigure(string $shape, array $metres): Result
{
    $lengths = array_map(Length::fromMetres(...), $metres);

    return (new AreaAndPerimeter)->calculate(new Inputs(['shape' => $shape, ...$lengths]));
}

it('calculates the area and the perimeter of each shape', function (string $shape, array $metres, string $area, string $perimeter): void {
    $result = planeFigure($shape, $metres);

    expect([Results::shown($result, 'area'), Results::shown($result, 'perimeter')])->toBe([$area, $perimeter])
        ->and([Results::unit($result, 'area'), Results::unit($result, 'perimeter')])->toBe(['m²', 'm']);
})->with([
    'rectangle' => ['rectangle', ['length' => 5, 'width' => 4], '20', '18'],
    'rectangle with decimals' => ['rectangle', ['length' => '2.5', 'width' => '1.2'], '3', '7.4'],
    'square' => ['square', ['side' => 3], '9', '12'],
    'circle' => ['circle', ['radius' => 1], '3.14159265359', '6.28318530718'],
    'right triangle 3-4-5' => ['triangle', ['side_a' => 3, 'side_b' => 4, 'side_c' => 5], '6', '12'],
    'isosceles triangle' => ['triangle', ['side_a' => 2, 'side_b' => 2, 'side_c' => 3], '1.9843134833', '7'],
    'rhombus' => ['rhombus', ['major_diagonal' => 8, 'minor_diagonal' => 6], '24', '20'],
    'parallelogram' => ['parallelogram', ['base' => 10, 'side' => 5, 'height' => 4], '40', '30'],
    'trapezoid' => ['trapezoid', ['major_base' => 10, 'minor_base' => 4, 'side_a' => 5, 'side_b' => 5], '28', '24'],
    'regular hexagon' => ['regular_hexagon', ['side' => 2], '10.3923048454', '12'],
    'regular pentagon' => ['regular_pentagon', ['side' => 1], '1.72047740059', '5'],
]);

it('shows the measures found on the way', function (string $shape, array $metres, string $name, string $expected): void {
    expect(Results::shown(planeFigure($shape, $metres), $name))->toBe($expected);
})->with([
    'circle diameter' => ['circle', ['radius' => '1.5'], 'diameter', '3'],
    'triangle semi-perimeter' => ['triangle', ['side_a' => 3, 'side_b' => 4, 'side_c' => 5], 'semi_perimeter', '6'],
    'rhombus side' => ['rhombus', ['major_diagonal' => 8, 'minor_diagonal' => 6], 'side', '5'],
    'trapezoid height' => ['trapezoid', ['major_base' => 10, 'minor_base' => 4, 'side_a' => 5, 'side_b' => 5], 'height', '4'],
    'hexagon apothem' => ['regular_hexagon', ['side' => 2], 'apothem', '1.73205080757'],
    'pentagon apothem' => ['regular_pentagon', ['side' => 1], 'apothem', '0.688190960236'],
]);

it('keeps a rectangle exact (2015: rounded to two places on the web, three on the mobile site)', function (): void {
    $result = planeFigure('rectangle', ['length' => '0.123', 'width' => '0.0045']);

    expect(Results::exact($result, 'area'))->toBe('1107/2000000');
});

it('reads only the dimensions of the chosen shape', function (): void {
    $result = planeFigure('square', ['side' => 2, 'length' => 99, 'radius' => 99]);

    expect(Results::shown($result, 'area'))->toBe('4');
});

it('refuses dimensions that do not make up the shape', function (string $shape, array $metres): void {
    expectInvalid(fn (): Result => planeFigure($shape, $metres), 'inputs', InputProblem::NoSolution);
})->with([
    'flat triangle' => ['triangle', ['side_a' => 1, 'side_b' => 2, 'side_c' => 3]],
    'open triangle' => ['triangle', ['side_a' => 1, 'side_b' => 1, 'side_c' => 5]],
    'parallelogram taller than its side' => ['parallelogram', ['base' => 10, 'side' => 3, 'height' => 4]],
    'trapezoid with equal bases' => ['trapezoid', ['major_base' => 4, 'minor_base' => 4, 'side_a' => 1, 'side_b' => 1]],
    'trapezoid with short legs' => ['trapezoid', ['major_base' => 10, 'minor_base' => 4, 'side_a' => 1, 'side_b' => 1]],
]);

it('accepts the boundary cases of each shape', function (): void {
    expect(Results::shown(planeFigure('parallelogram', ['base' => 10, 'side' => 4, 'height' => 4]), 'area'))->toBe('40')
        ->and(Results::shown(planeFigure('triangle', ['side_a' => 1, 'side_b' => 1, 'side_c' => '1.999']), 'perimeter'))
        ->toBe('3.999');
});

it('refuses a missing or non-positive dimension of the chosen shape', function (): void {
    expectInvalid(fn (): Result => planeFigure('rectangle', ['length' => 5]), 'width', InputProblem::Missing);
    expectInvalid(fn (): Result => planeFigure('circle', ['radius' => 0]), 'radius', InputProblem::NotPositive);
    expectInvalid(fn (): Result => planeFigure('hexagon', ['side' => 1]), 'shape', InputProblem::UnknownOption);
});
