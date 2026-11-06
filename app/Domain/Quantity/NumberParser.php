<?php

declare(strict_types=1);

namespace App\Domain\Quantity;

use Brick\Math\BigNumber;
use Brick\Math\BigRational;
use Brick\Math\Exception\MathException;
use Brick\Math\NumberSyntax;

/**
 * Reads a number typed by a person, such as "1.5", "-20" or "4.7e-6", into an exact value.
 *
 * The number of digits is limited, as written and once the exponent is applied, so "1e999999999" is rejected
 * instead of expanding into gigabytes.
 */
final class NumberParser
{
    private const int MAX_DIGITS = 40;

    /**
     * The exact value of the text; surrounding spaces are ignored.
     *
     * @throws InvalidNumber
     */
    public static function parse(string $text): BigRational
    {
        $trimmed = trim($text);

        try {
            return BigNumber::parse($trimmed, NumberSyntax::SCIENTIFIC, self::MAX_DIGITS)->toBigRational();
        } catch (MathException $exception) {
            throw InvalidNumber::fromText($trimmed, $exception);
        }
    }
}
