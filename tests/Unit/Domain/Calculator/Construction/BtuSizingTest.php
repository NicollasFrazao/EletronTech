<?php

declare(strict_types=1);

use App\Domain\Calculator\Construction\BtuSizing;
use App\Domain\Calculator\InputProblem;
use App\Domain\Calculator\Inputs;
use App\Domain\Calculator\Result;
use App\Domain\Quantity\Area;
use Brick\Math\BigRational;
use Tests\Support\Results;

// The retail rule of thumb for room air conditioners in Brazil: 600 BTU/h per m² (one person included), plus
// 600 BTU/h per further person and per heat-giving appliance. A 12 m² bedroom for two with a TV needs
// 7200 + 600 + 600 = 8400 BTU/h. The rule is an estimate; ABNT NBR 16401-1 is the engineering method.

/**
 * The cooling capacity, in BTU/h, of a room.
 */
function coolingCapacity(int|string $squareMetres, int|string $people, int|string $appliances): Result
{
    return (new BtuSizing)->calculate(new Inputs([
        'area' => Area::fromSquareMetres($squareMetres),
        'people' => BigRational::of($people),
        'appliances' => BigRational::of($appliances),
    ]));
}

it('adds 600 BTU/h per square metre, per further person and per appliance', function (
    int|string $area,
    int $people,
    int $appliances,
    string $expected,
): void {
    $result = coolingCapacity($area, $people, $appliances);

    expect(Results::shown($result, 'cooling_capacity'))->toBe($expected)
        ->and(Results::unit($result, 'cooling_capacity'))->toBe('BTU/h');
})->with([
    'bedroom for two with a TV' => [12, 2, 1, '8400'],
    'one person, no appliance' => [12, 1, 0, '7200'],
    'an empty room counts as one person' => [12, 0, 0, '7200'],
    'living room' => [20, 4, 3, '15600'],
]);

it('shows each share', function (): void {
    $result = coolingCapacity(12, 3, 2);

    expect([
        Results::shown($result, 'area_load'),
        Results::shown($result, 'people_load'),
        Results::shown($result, 'appliance_load'),
    ])->toBe(['7200', '1200', '1200']);
});

it('counts the first person in the area (2015: one person added 600 BTU and two people as many as one)', function (): void {
    expect(Results::shown(coolingCapacity(10, 1, 0), 'cooling_capacity'))->toBe('6000')
        ->and(Results::shown(coolingCapacity(10, 2, 0), 'cooling_capacity'))->toBe('6600');
});

it('keeps the fraction of a square metre (2015: parseInt dropped it, so 12.5 m² counted as 12)', function (): void {
    expect(Results::shown(coolingCapacity('12.5', 1, 0), 'cooling_capacity'))->toBe('7500');
});

it('refuses a count that is not a whole number of at least zero', function (
    string $field,
    int|string $people,
    int|string $appliances,
    InputProblem $problem,
): void {
    expectInvalid(fn (): Result => coolingCapacity(10, $people, $appliances), $field, $problem);
})->with([
    'half a person' => ['people', '1.5', 0, InputProblem::NotWhole],
    'negative appliances' => ['appliances', 1, -1, InputProblem::Negative],
]);

it('refuses an area that is not greater than zero', function (): void {
    expectInvalid(fn (): Result => coolingCapacity(0, 1, 0), 'area', InputProblem::NotPositive);
});
