<?php

declare(strict_types=1);

namespace App\Domain\Quantity;

use Brick\Math\BigDecimal;
use Brick\Math\BigNumber;
use Brick\Math\BigRational;
use Brick\Math\RoundingMode;
use InvalidArgumentException;

/**
 * How many digits a result is shown with, and the one rounding rule every displayed result follows.
 *
 * Quantities keep their value exact; rounding happens only here, when a value is about to be shown, and
 * always half up (0.125 to two places is 0.13), the rule people apply by hand.
 *
 * @api
 */
final readonly class Precision
{
    private const RoundingMode ROUNDING = RoundingMode::HalfUp;

    /**
     * @param  int<0, max>  $digits  Significant digits (at least 1) or decimal places.
     */
    private function __construct(
        private int $digits,
        private bool $countsSignificantDigits,
    ) {}

    /**
     * Rounds to a number of significant digits, never dropping a digit of the integer part, and strips
     * trailing zeros: with 4 digits, 1/3 is 0.3333, 2/3 is 0.6667, 0.000123456 is 0.0001235 and 123456 stays.
     */
    public static function significantDigits(int $digits): self
    {
        if ($digits < 1) {
            throw new InvalidArgumentException('At least one significant digit is needed.');
        }

        return new self($digits, true);
    }

    /**
     * Rounds to a fixed number of decimal places and keeps them: with 2 places, 2.5 is 2.50.
     */
    public static function decimalPlaces(int $places): self
    {
        if ($places < 0) {
            throw new InvalidArgumentException('The number of decimal places cannot be negative.');
        }

        return new self($places, false);
    }

    /**
     * The value rounded as this precision says.
     */
    public function apply(BigNumber $value): BigDecimal
    {
        if (! $this->countsSignificantDigits) {
            return $value->toScale($this->digits, self::ROUNDING);
        }

        $exact = $value->toBigRational();

        if ($exact->isZero()) {
            return BigDecimal::zero();
        }

        $scale = $this->digits - 1 - $this->exponentOf($exact->abs());

        return $exact->toScale(max($scale, 0), self::ROUNDING)->strippedOfTrailingZeros();
    }

    /**
     * The power of ten of the first significant digit of a positive value: 2 for 345, -3 for 0.00345.
     */
    private function exponentOf(BigRational $value): int
    {
        $exponent = strlen($value->getNumerator()->toString()) - strlen($value->getDenominator()->toString());

        return $value->isLessThan(BigRational::ten()->power($exponent)) ? $exponent - 1 : $exponent;
    }
}
