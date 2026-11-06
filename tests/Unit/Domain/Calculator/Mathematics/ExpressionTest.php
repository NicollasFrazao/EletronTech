<?php

declare(strict_types=1);

use App\Domain\Calculator\InputProblem;
use App\Domain\Calculator\Inputs;
use App\Domain\Calculator\InvalidInput;
use App\Domain\Calculator\Mathematics\BasicCalculator;
use App\Domain\Calculator\Mathematics\Expression;
use App\Domain\Calculator\Mathematics\InvalidExpression;
use App\Domain\Calculator\Result;
use Brick\Math\BigRational;
use Eris\Generators;
use Tests\Support\Property;
use Tests\Support\Results;

// Arithmetic with the usual order of operations: brackets, then signs, then × and ÷ left to right, then + and −
// left to right (ISO 80000-2, 2-9); a bracket written against a factor multiplies it. Exact fractions throughout.

/**
 * The exact value of an expression, as a fraction.
 */
function evaluated(string $expression): string
{
    return Expression::evaluate($expression)->toString();
}

/**
 * Asserts that an expression is refused for one reason.
 */
function expectRefusedExpression(string $expression, InputProblem $problem): void
{
    expect(fn (): BigRational => Expression::evaluate($expression))
        ->toThrow(function (InvalidExpression $error) use ($problem): void {
            expect($error->problem)->toBe($problem);
        });
}

it('evaluates with the usual order of operations', function (string $expression, string $expected): void {
    expect(evaluated($expression))->toBe($expected);
})->with([
    'products before sums' => ['1 + 2 * 3', '7'],
    'brackets first' => ['(1 + 2) * 3', '9'],
    'left to right division' => ['8 / 2 / 2', '2'],
    'left to right subtraction' => ['2 - 3 - 4', '-5'],
    'unary signs' => ['-3 - -2', '-1'],
    'a leading plus' => ['+5', '5'],
    'typographic operators' => ['2 × 3 ÷ 4 − 1', '1/2'],
    'square and curly brackets' => ['{[1,5 + 2] / 7}', '1/2'],
    'nested brackets' => ['((1 + 2))', '3'],
    'decimal comma' => ['1,25 * 4', '5'],
    'scientific notation' => ['4.7e-6 * 1e6', '47/10'],
    'a fraction stays exact' => ['1 / 3 * 3', '1'],
    'no spaces' => ['2*(3+4)-5', '9'],
]);

it('multiplies a bracket written against a number or another bracket', function (string $expression, string $expected): void {
    expect(evaluated($expression))->toBe($expected);
})->with([
    'number before a bracket' => ['2(3 + 1)', '8'],
    'bracket before a bracket' => ['(1 + 1)(2)', '4'],
    'bracket before a number' => ['(2)3', '6'],
    'signed bracket' => ['-(2)(3)', '-6'],
]);

it('is exact where floating point is not (2015: eval gave 0.30000000000000004)', function (): void {
    expect(evaluated('0.1 + 0.2'))->toBe('3/10');
});

it('refuses anything that is not arithmetic (2015: the text went to eval)', function (string $expression): void {
    expectRefusedExpression($expression, InputProblem::NotAnExpression);
})->with([
    'code' => ['alert(1)'],
    'two numbers side by side' => ['2 3'],
    'a trailing operator' => ['2 +'],
    'an unclosed bracket' => ['(2'],
    'an unopened bracket' => ['2)'],
    'mismatched brackets' => ['(2]'],
    'a power' => ['2 ^ 3'],
    'a doubled decimal point' => ['1..2'],
    'a decimal point without digits after it' => ['1.'],
    'only spaces' => ['   '],
    'an empty bracket' => ['()'],
    'a number beyond 40 digits' => ['1e99'],
]);

it('refuses a division by zero', function (string $expression): void {
    expectRefusedExpression($expression, InputProblem::DivisionByZero);
})->with([
    'by zero' => ['1 / 0'],
    'by an expression worth zero' => ['1 / (2 - 2)'],
]);

it('evaluates up to 255 characters and refuses a longer text', function (): void {
    expect(evaluated(str_repeat('1+', 127).'1'))->toBe('128');

    expectRefusedExpression(str_repeat('1+', 128).'1', InputProblem::TooLong);
});

it('agrees with exact arithmetic on any integers', function (): void {
    Property::check(100, [
        Generators::choose(-1_000_000, 1_000_000),
        Generators::choose(-1_000_000, 1_000_000),
        Generators::suchThat(static fn (int $value): bool => $value !== 0, Generators::choose(-1000, 1000)),
    ], function (int $first, int $second, int $third): void {
        $sum = BigRational::of($first)->plus($second);

        expect(evaluated("{$first} + {$second} * {$third}"))->toBe(BigRational::of($first)->plus($second * $third)->toString())
            ->and(evaluated("({$first} + {$second}) / {$third}"))->toBe($sum->dividedBy($third)->toString())
            ->and(evaluated("{$first}({$second})"))->toBe(BigRational::of($first * $second)->toString());
    });
});

it('is the basic calculator', function (): void {
    $calculator = new BasicCalculator;

    $result = $calculator->calculate(new Inputs(['expression' => '(2 + 3) × 4']));

    expect(Results::exact($result, 'result'))->toBe('20')
        ->and(Results::shown($calculator->calculate(new Inputs(['expression' => '2 / 3'])), 'result'))->toBe('0.666666666667');
});

it('refuses an expression the calculator cannot evaluate on its field', function (): void {
    expectInvalid(
        fn (): Result => (new BasicCalculator)->calculate(new Inputs(['expression' => '1 / 0'])),
        'expression',
        InputProblem::DivisionByZero,
    );
    expectInvalid(fn (): Result => (new BasicCalculator)->calculate(new Inputs([])), 'expression', InputProblem::Missing);
});

it('says why an expression was refused', function (): void {
    (new BasicCalculator)->calculate(new Inputs(['expression' => '2 +']));
})->throws(InvalidInput::class, 'Input "expression": the text is not an arithmetic expression.');
