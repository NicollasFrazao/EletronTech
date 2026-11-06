<?php

declare(strict_types=1);

use App\Domain\Calculator\InputProblem;
use App\Domain\Calculator\Inputs;
use App\Domain\Calculator\Mathematics\BinaryConverter;
use App\Domain\Calculator\Result;
use Tests\Support\Results;

// Positional notation: a whole number is Σ dᵢ × bⁱ in base b, with digits 0–1 (binary), 0–7 (octal), 0–9
// (decimal) and 0–9, A–F (hexadecimal). 255 = 11111111₂ = 377₈ = FF₁₆; 2⁶⁴ = 10000000000000000₁₆.

/**
 * The number in the four bases, as the converter writes it.
 *
 * @return array{string, string, string, string}
 */
function inEveryBase(string $value, string $base): array
{
    $result = (new BinaryConverter)->calculate(new Inputs(['value' => $value, 'base' => $base]));

    return [
        Results::exact($result, 'binary'),
        Results::exact($result, 'octal'),
        Results::exact($result, 'decimal'),
        Results::exact($result, 'hexadecimal'),
    ];
}

it('writes a number in binary, octal, decimal and hexadecimal', function (string $value, string $base, array $expected): void {
    expect(inEveryBase($value, $base))->toBe($expected);
})->with([
    'from decimal' => ['255', 'decimal', ['11111111', '377', '255', 'FF']],
    'from lower-case hexadecimal' => ['ff', 'hexadecimal', ['11111111', '377', '255', 'FF']],
    'from binary' => ['1010', 'binary', ['1010', '12', '10', 'A']],
    'from octal with leading zeros' => ['0007', 'octal', ['111', '7', '7', '7']],
    'zero' => ['0', 'binary', ['0', '0', '0', '0']],
    'beyond 64 bits, exactly' => [
        '18446744073709551616',
        'decimal',
        ['1'.str_repeat('0', 64), '2'.str_repeat('0', 21), '18446744073709551616', '1'.str_repeat('0', 16)],
    ],
]);

it('lists the four bases as its answers', function (): void {
    $result = (new BinaryConverter)->calculate(new Inputs(['value' => '1', 'base' => 'binary']));

    expect(Results::names($result))->toBe(['binary', 'octal', 'decimal', 'hexadecimal']);
});

it('refuses a digit its base does not have (2015: parseInt stopped there: binary 102 was 2)', function (string $value, string $base): void {
    expectInvalid(
        fn (): Result => (new BinaryConverter)->calculate(new Inputs(['value' => $value, 'base' => $base])),
        'value',
        InputProblem::NotANumber,
    );
})->with([
    'binary 102' => ['102', 'binary'],
    'octal 8' => ['8', 'octal'],
    'hexadecimal 12G' => ['12G', 'hexadecimal'],
    'a fraction' => ['1.5', 'decimal'],
    'spaces inside' => ['1 0', 'binary'],
]);

it('refuses a negative number', function (): void {
    expectInvalid(
        fn (): Result => (new BinaryConverter)->calculate(new Inputs(['value' => '-5', 'base' => 'decimal'])),
        'value',
        InputProblem::Negative,
    );
});

it('refuses a base it does not know', function (): void {
    expectInvalid(
        fn (): Result => (new BinaryConverter)->calculate(new Inputs(['value' => '5', 'base' => 'base64'])),
        'base',
        InputProblem::UnknownOption,
    );
});
