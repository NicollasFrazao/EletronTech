<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Electrical;

use App\Domain\Quantity\Resistance;
use Brick\Math\BigRational;

/**
 * The first three bands of a four-band resistor: two digits and a multiplier, the first digit not zero.
 */
final readonly class ResistorBands
{
    /**
     * Digits are decimal: the first band counts tens, the second units.
     */
    private const int BASE = 10;

    /**
     * The two digit bands write numbers below this one.
     */
    private const int SMALLEST_THREE_DIGIT_NUMBER = 100;

    private function __construct(
        public ResistorColour $first,
        public ResistorColour $second,
        public ResistorColour $multiplier,
    ) {}

    /**
     * The bands of three colours; null when the first is not a digit from 1 to 9 or the second not a digit.
     */
    public static function tryOf(ResistorColour $first, ResistorColour $second, ResistorColour $multiplier): ?self
    {
        if (($first->digit() ?? 0) === 0 || $second->digit() === null) {
            return null;
        }

        return new self($first, $second, $multiplier);
    }

    /**
     * The bands of a resistance; null unless it is a two-digit whole number times a power of ten a multiplier
     * band stands for (4.7 kΩ is 47 × 10², yellow violet red; 4.75 kΩ has no four-band code).
     */
    public static function tryOfResistance(Resistance $resistance): ?self
    {
        foreach (ResistorColour::multiplierExponents() as $exponent) {
            $significand = $resistance->toOhms()->dividedBy(BigRational::ten()->power($exponent));

            if (self::isTwoDigitWholeNumber($significand)) {
                $number = $significand->getNumerator()->toInt();

                return new self(
                    ResistorColour::ofDigit(intdiv($number, self::BASE)),
                    ResistorColour::ofDigit($number % self::BASE),
                    ResistorColour::ofMultiplierExponent($exponent),
                );
            }
        }

        return null;
    }

    /**
     * The resistance the bands stand for: (10 × first digit + second digit) × 10^multiplier.
     */
    public function resistance(): Resistance
    {
        $significand = self::BASE * ($this->first->digit() ?? 0) + ($this->second->digit() ?? 0);

        return Resistance::fromOhms(
            BigRational::of($significand)->multipliedBy(BigRational::ten()->power($this->multiplier->multiplierExponent())),
        );
    }

    /**
     * Whether a value is a whole number from 10 to 99.
     */
    private static function isTwoDigitWholeNumber(BigRational $value): bool
    {
        return $value->getDenominator()->isEqualTo(1)
            && $value->isGreaterThanOrEqualTo(self::BASE)
            && $value->isLessThan(self::SMALLEST_THREE_DIGIT_NUMBER);
    }
}
