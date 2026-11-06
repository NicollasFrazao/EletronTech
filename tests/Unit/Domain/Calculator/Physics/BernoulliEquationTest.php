<?php

declare(strict_types=1);

use App\Domain\Calculator\InputProblem;
use App\Domain\Calculator\Inputs;
use App\Domain\Calculator\Physics\BernoulliEquation;
use App\Domain\Calculator\Result;
use App\Domain\Quantity\Density;
use App\Domain\Quantity\Length;
use App\Domain\Quantity\Pressure;
use App\Domain\Quantity\Velocity;
use Tests\Support\Results;

// Bernoulli's equation for an ideal fluid, p + ½ρv² + ρg₀h constant along a streamline, g₀ = 9.80665 m/s²
// (Halliday, Resnick and Walker, Fundamentals of Physics, ch. 14). Water (1000 kg/m³) at 200 kPa and 2 m/s
// speeding up to 4 m/s in a level pipe drops to 194 kPa; a tank 5 m deep empties at √(2g₀h) = 9.90285312423 m/s
// (Torricelli).

/**
 * The water flow of the example, with one value left out.
 *
 * @return array<string, Density|Pressure|Velocity|Length>
 */
function levelPipe(string $without): array
{
    $values = [
        'density' => Density::fromKilogramsPerCubicMetre(1000),
        'pressure_1' => Pressure::fromPascals(200000),
        'velocity_1' => Velocity::fromMetresPerSecond(2),
        'height_1' => Length::zero(),
        'pressure_2' => Pressure::fromPascals(194000),
        'velocity_2' => Velocity::fromMetresPerSecond(4),
        'height_2' => Length::zero(),
    ];
    unset($values[$without]);

    return $values;
}

it('solves for whichever of the six values is left empty', function (string $unknown, string $expected): void {
    $result = (new BernoulliEquation)->calculate(new Inputs(levelPipe($unknown)));

    expect(Results::shown($result, $unknown))->toBe($expected)
        ->and(Results::shown($result, 'total_pressure'))->toBe('202000');
})->with([
    'pressure at the second point' => ['pressure_2', '194000'],
    'velocity at the second point' => ['velocity_2', '4'],
    'height at the second point' => ['height_2', '0'],
    'pressure at the first point' => ['pressure_1', '200000'],
    'velocity at the first point' => ['velocity_1', '2'],
    'height at the first point' => ['height_1', '0'],
]);

it('lists the six values in order', function (): void {
    $result = (new BernoulliEquation)->calculate(new Inputs(levelPipe('velocity_1')));

    expect(Results::names($result))->toBe(['pressure_1', 'velocity_1', 'height_1', 'pressure_2', 'velocity_2', 'height_2'])
        ->and(Results::unit($result, 'pressure_1'))->toBe('Pa')
        ->and(Results::unit($result, 'velocity_1'))->toBe('m/s');
});

it('finds a height (2015: the height branch tested a property of a string and never ran)', function (): void {
    $given = [...levelPipe('height_2'), 'pressure_2' => Pressure::fromPascals(150000), 'velocity_2' => Velocity::fromMetresPerSecond(2)];

    $result = (new BernoulliEquation)->calculate(new Inputs($given));

    expect(Results::shown($result, 'height_2'))->toBe('5.09858106489');
});

it('gives Torricelli\'s law for a tank draining from 5 m', function (): void {
    $result = (new BernoulliEquation)->calculate(new Inputs([
        'density' => Density::fromKilogramsPerCubicMetre(1000),
        'pressure_1' => Pressure::zero(),
        'velocity_1' => Velocity::zero(),
        'height_1' => Length::fromMetres(5),
        'pressure_2' => Pressure::zero(),
        'height_2' => Length::zero(),
    ]));

    expect(Results::shown($result, 'velocity_2'))->toBe('9.90285312423');
});

it('adds pressures as numbers (2015: "200000" + 2000 was the text "2000002000")', function (): void {
    $result = (new BernoulliEquation)->calculate(new Inputs(levelPipe('pressure_2')));

    expect(Results::exact($result, 'pressure_2'))->toBe('194000');
});

it('accepts gauge pressures below the atmosphere and heights below the reference', function (): void {
    $given = [...levelPipe('pressure_2'), 'height_2' => Length::fromMetres(-1), 'pressure_1' => Pressure::fromPascals(-10000)];

    $result = (new BernoulliEquation)->calculate(new Inputs($given));

    expect(Results::shown($result, 'pressure_2'))->toBe('-6193.35');
});

it('refuses a speed no flow can have', function (): void {
    $given = [...levelPipe('velocity_2'), 'pressure_2' => Pressure::fromPascals(300000)];

    expectInvalid(fn (): Result => (new BernoulliEquation)->calculate(new Inputs($given)), 'inputs', InputProblem::NoSolution);
});

it('refuses a negative velocity, a density that is not positive, and the wrong number of values', function (): void {
    $negative = [...levelPipe('pressure_2'), 'velocity_1' => Velocity::fromMetresPerSecond(-2)];
    $noDensity = [...levelPipe('pressure_2'), 'density' => Density::zero()];

    expectInvalid(fn (): Result => (new BernoulliEquation)->calculate(new Inputs($negative)), 'velocity_1', InputProblem::Negative);
    expectInvalid(fn (): Result => (new BernoulliEquation)->calculate(new Inputs($noDensity)), 'density', InputProblem::NotPositive);
    expectInvalid(
        fn (): Result => (new BernoulliEquation)->calculate(new Inputs(levelPipe('nothing'))),
        'inputs',
        InputProblem::WrongNumberOfValues,
    );
});
