<?php

declare(strict_types=1);

use App\Domain\Quantity\Precision;
use Brick\Math\BigRational;

it('rounds to significant digits half up and strips trailing zeros', function (string $value, int $digits, string $expected): void {
    expect(Precision::significantDigits($digits)->apply(BigRational::of($value))->toString())->toBe($expected);
})->with([
    'a third' => ['1/3', 4, '0.3333'],
    'two thirds' => ['2/3', 4, '0.6667'],
    'half up' => ['0.125', 2, '0.13'],
    'negative half up, away from zero' => ['-0.125', 2, '-0.13'],
    'small value' => ['0.000123456', 4, '0.0001235'],
    'integer digits are never dropped' => ['123456', 4, '123456'],
    'rounding carries into a new digit' => ['9.9996', 4, '10'],
    'trailing zeros stripped' => ['2.5', 6, '2.5'],
    'exact power of ten' => ['1000', 1, '1000'],
    'zero' => ['0', 3, '0'],
]);

it('rounds to decimal places half up and keeps them', function (string $value, int $places, string $expected): void {
    expect(Precision::decimalPlaces($places)->apply(BigRational::of($value))->toString())->toBe($expected);
})->with([
    ['2.5', 2, '2.50'],
    ['0.125', 2, '0.13'],
    ['2/3', 0, '1'],
    ['-1/8', 2, '-0.13'],
]);

it('needs at least one significant digit', function (): void {
    Precision::significantDigits(0);
})->throws(InvalidArgumentException::class);

it('refuses a negative number of decimal places', function (): void {
    Precision::decimalPlaces(-1);
})->throws(InvalidArgumentException::class);
