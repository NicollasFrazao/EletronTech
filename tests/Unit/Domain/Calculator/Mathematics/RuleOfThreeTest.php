<?php

declare(strict_types=1);

use App\Domain\Calculator\InputProblem;
use App\Domain\Calculator\Inputs;
use App\Domain\Calculator\Mathematics\RuleOfThree;
use App\Domain\Calculator\Result;
use Brick\Math\BigRational;
use Tests\Support\Results;

// Rule of three. Directly proportional: a / c = b / d, so a × d = b × c (2 kg cost 10, 3 kg cost 15).
// Inversely proportional: a × b = c × d (4 workers take 6 days, 8 workers take 3).

/**
 * The four values with the given ones as exact numbers.
 *
 * @param  array<string, int|string>  $given
 */
function ruleOfThree(string $proportion, array $given): Result
{
    $values = array_map(BigRational::of(...), $given);

    return (new RuleOfThree)->calculate(new Inputs(['proportion' => $proportion, ...$values]));
}

it('solves for whichever value is left empty', function (string $proportion, array $given, string $unknown, string $expected): void {
    $result = ruleOfThree($proportion, $given);

    expect(Results::exact($result, $unknown))->toBe($expected)
        ->and(Results::names($result))->toBe(['first', 'second', 'third', 'fourth']);
})->with([
    'direct, fourth' => ['direct', ['first' => 2, 'second' => 10, 'third' => 3], 'fourth', '15'],
    'direct, third' => ['direct', ['first' => 2, 'second' => 10, 'fourth' => 15], 'third', '3'],
    'direct, second' => ['direct', ['first' => 2, 'third' => 3, 'fourth' => 15], 'second', '10'],
    'direct, first' => ['direct', ['second' => 10, 'third' => 3, 'fourth' => 15], 'first', '2'],
    'inverse, fourth' => ['inverse', ['first' => 4, 'second' => 6, 'third' => 8], 'fourth', '3'],
    'inverse, third' => ['inverse', ['first' => 4, 'second' => 6, 'fourth' => 3], 'third', '8'],
    'inverse, second' => ['inverse', ['first' => 4, 'third' => 8, 'fourth' => 3], 'second', '6'],
    'inverse, first' => ['inverse', ['second' => 6, 'third' => 8, 'fourth' => 3], 'first', '4'],
    'an exact fraction' => ['direct', ['first' => 3, 'second' => 1, 'third' => 7], 'fourth', '7/3'],
    'decimals' => ['direct', ['first' => '1.5', 'second' => '4.5', 'third' => '2.5'], 'fourth', '15/2'],
]);

it('calculates something at all (2015: the page loaded the breaker script and computed nothing)', function (): void {
    expect(Results::shown(ruleOfThree('direct', ['first' => 100, 'second' => 30, 'third' => 250]), 'fourth'))->toBe('75');
});

it('needs exactly one value left empty', function (array $given): void {
    expectInvalid(fn (): Result => ruleOfThree('direct', $given), 'inputs', InputProblem::WrongNumberOfValues);
})->with([
    'two empty' => [['first' => 1, 'second' => 2]],
    'none empty' => [['first' => 1, 'second' => 2, 'third' => 3, 'fourth' => 6]],
]);

it('refuses a value that is not greater than zero', function (int $value): void {
    expectInvalid(
        fn (): Result => ruleOfThree('inverse', ['first' => 4, 'second' => $value, 'third' => 8]),
        'second',
        InputProblem::NotPositive,
    );
})->with([0, -6]);

it('needs to know whether the proportion is direct or inverse', function (): void {
    expectInvalid(
        fn (): Result => (new RuleOfThree)->calculate(new Inputs(['first' => BigRational::of(1)])),
        'proportion',
        InputProblem::Missing,
    );
});
