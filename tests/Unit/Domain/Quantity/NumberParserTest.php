<?php

declare(strict_types=1);

use App\Domain\Quantity\InvalidNumber;
use App\Domain\Quantity\NumberParser;

it('reads integers, decimals and scientific notation exactly', function (string $text, string $expected): void {
    expect(NumberParser::parse($text)->toString())->toBe($expected);
})->with([
    ['42', '42'],
    [' -1.5 ', '-3/2'],
    ['4.7e-6', '47/10000000'],
    ['.5', '1/2'],
    ['1E3', '1000'],
]);

it('rejects what is not a number', function (string $text): void {
    NumberParser::parse($text);
})->with([
    'empty' => [''],
    'words' => ['twelve'],
    'a fraction' => ['1/3'],
    'two points' => ['1.2.3'],
    'a decimal comma' => ['1,5'],
])->throws(InvalidNumber::class);

it('rejects a number that expands into too many digits', function (string $text): void {
    NumberParser::parse($text);
})->with([
    'huge exponent' => ['1e999999999'],
    'too many digits' => [str_repeat('9', 41)],
])->throws(InvalidNumber::class);

it('names the text it could not read', function (): void {
    NumberParser::parse(' abc ');
})->throws(InvalidNumber::class, '"abc" is not a valid number.');
