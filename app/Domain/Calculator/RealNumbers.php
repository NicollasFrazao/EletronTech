<?php

declare(strict_types=1);

namespace App\Domain\Calculator;

use Brick\Math\BigRational;
use Brick\Math\RoundingMode;
use InvalidArgumentException;

/**
 * The irrational numbers the calculators need (π, square roots), as exact fractions close enough to them.
 *
 * Quantities are exact fractions (ADR 0002); an irrational value cannot be one, so it is computed to
 * SIGNIFICANT_DIGITS significant digits, far beyond the 12 a result is shown with, and the rest of the
 * calculation stays exact.
 */
final class RealNumbers
{
    /**
     * Digits kept in an irrational value; the error is below 10⁻³⁰ of the value.
     */
    private const int SIGNIFICANT_DIGITS = 32;

    /**
     * π to 40 decimal places.
     */
    private const string PI = '3.1415926535897932384626433832795028841972';

    /**
     * A square has twice the digits of its root: the root of a value near 10ⁿ is near 10^(n/2).
     */
    private const int SQUARE = 2;

    /**
     * π, to more digits than any result is shown with.
     */
    public static function pi(): BigRational
    {
        return BigRational::of(self::PI);
    }

    /**
     * The square root of a value that is not negative, to SIGNIFICANT_DIGITS significant digits, rounded half up;
     * exact when the value is the square of a short decimal (the root of 0.36 is exactly 0.6).
     */
    public static function squareRoot(BigRational $value): BigRational
    {
        if ($value->isNegative()) {
            throw new InvalidArgumentException('A negative number has no real square root.');
        }

        if ($value->isZero()) {
            return BigRational::zero();
        }

        $exponent = strlen($value->getNumerator()->toString()) - strlen($value->getDenominator()->toString());
        $scale = max(0, self::SIGNIFICANT_DIGITS - intdiv($exponent, self::SQUARE) + 1);

        return $value->toScale(self::SQUARE * $scale, RoundingMode::Down)
            ->sqrt($scale, RoundingMode::HalfUp)
            ->strippedOfTrailingZeros()
            ->toBigRational();
    }
}
