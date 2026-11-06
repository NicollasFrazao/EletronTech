<?php

declare(strict_types=1);

use App\Domain\Calculator\Electrical\SeriesParallelResistance;
use App\Domain\Calculator\InputProblem;
use App\Domain\Calculator\Inputs;
use App\Domain\Calculator\Result;
use App\Domain\Quantity\Resistance;
use Tests\Support\Results;

// Resistors in series add, R = R₁ + R₂; in parallel their conductances add, 1/R = 1/R₁ + 1/R₂, so
// R = R₁ × R₂ / (R₁ + R₂): 6 Ω and 3 Ω in parallel make 2 Ω, two equal resistors half of one.

/**
 * The three resistances, in ohms, with the given ones in ohms.
 *
 * @param  array<string, int|string>  $ohms
 *
 * @return array{string, string, string}
 */
function resistors(string $connection, array $ohms): array
{
    $given = array_map(Resistance::fromOhms(...), $ohms);
    $result = (new SeriesParallelResistance)->calculate(new Inputs(['connection' => $connection, ...$given]));

    return [
        Results::exact($result, 'first_resistance'),
        Results::exact($result, 'second_resistance'),
        Results::exact($result, 'equivalent_resistance'),
    ];
}

it('solves for whichever resistance is left empty', function (string $connection, array $ohms, array $expected): void {
    expect(resistors($connection, $ohms))->toBe($expected);
})->with([
    'series, equivalent' => ['series', ['first_resistance' => 100, 'second_resistance' => 220], ['100', '220', '320']],
    'series, first' => ['series', ['second_resistance' => 220, 'equivalent_resistance' => 320], ['100', '220', '320']],
    'series, second' => ['series', ['first_resistance' => 100, 'equivalent_resistance' => 320], ['100', '220', '320']],
    'parallel, equivalent' => ['parallel', ['first_resistance' => 6, 'second_resistance' => 3], ['6', '3', '2']],
    'parallel, first' => ['parallel', ['second_resistance' => 3, 'equivalent_resistance' => 2], ['6', '3', '2']],
    'parallel, second' => ['parallel', ['first_resistance' => 6, 'equivalent_resistance' => 2], ['6', '3', '2']],
    'parallel, two equal' => ['parallel', ['first_resistance' => 100, 'second_resistance' => 100], ['100', '100', '50']],
    'parallel, exact fraction' => ['parallel', ['first_resistance' => 100, 'second_resistance' => 220], ['100', '220', '275/4']],
]);

it('refuses an equivalent no resistor makes up (2015: negative or infinite resistances)', function (string $connection, array $ohms): void {
    expectInvalid(fn (): array => resistors($connection, $ohms), 'inputs', InputProblem::NoSolution);
})->with([
    'series, below the known one' => ['series', ['second_resistance' => 220, 'equivalent_resistance' => 100]],
    'series, equal to the known one' => ['series', ['second_resistance' => 220, 'equivalent_resistance' => 220]],
    'parallel, above the known one' => ['parallel', ['second_resistance' => 3, 'equivalent_resistance' => 4]],
    'parallel, equal to the known one' => ['parallel', ['first_resistance' => 3, 'equivalent_resistance' => 3]],
]);

it('needs exactly one resistance left empty', function (): void {
    expectInvalid(fn (): array => resistors('series', ['first_resistance' => 1]), 'inputs', InputProblem::WrongNumberOfValues);
});

it('needs the connection', function (): void {
    expectInvalid(
        fn (): Result => (new SeriesParallelResistance)->calculate(new Inputs(['first_resistance' => Resistance::fromOhms(1)])),
        'connection',
        InputProblem::Missing,
    );
});

it('refuses a resistance that is not greater than zero', function (): void {
    expectInvalid(
        fn (): array => resistors('parallel', ['first_resistance' => 0, 'second_resistance' => 3]),
        'first_resistance',
        InputProblem::NotPositive,
    );
});
