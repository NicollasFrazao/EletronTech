<?php

declare(strict_types=1);

use App\Domain\Calculator\RealNumbers;
use App\Domain\Quantity\Precision;
use Brick\Math\BigRational;

it('gives exact roots of squares of short decimals', function (string $square, string $root): void {
    expect(RealNumbers::squareRoot(BigRational::of($square))->toString())->toBe($root);
})->with([
    ['0', '0'],
    ['0.36', '3/5'],
    ['144', '12'],
    ['1/4', '1/2'],
]);

it('gives irrational roots to 32 significant digits, whatever the magnitude', function (string $value, string $root): void {
    $digits = Precision::significantDigits(32)->apply(RealNumbers::squareRoot(BigRational::of($value)));

    expect($digits->toString())->toBe($root);
})->with([
    ['3', '1.7320508075688772935274463415059'],
    ['2e-20', '0.00000000014142135623730950488016887242097'],
    ['2e20', '14142135623.730950488016887242097'],
]);

it('refuses the root of a negative number', function (): void {
    RealNumbers::squareRoot(BigRational::of(-1));
})->throws(InvalidArgumentException::class);

it('knows π to more digits than any result shows', function (): void {
    expect(Precision::significantDigits(20)->apply(RealNumbers::pi())->toString())->toBe('3.1415926535897932385');
});
