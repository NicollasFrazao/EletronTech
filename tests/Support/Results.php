<?php

declare(strict_types=1);

namespace Tests\Support;

use App\Domain\Calculator\Result;
use App\Domain\Calculator\ResultValue;
use App\Domain\Quantity\Precision;
use Brick\Math\BigRational;
use OutOfBoundsException;

/**
 * Reads the values of a calculator's result by name, the way the tests assert them.
 */
final class Results
{
    /**
     * The exact value, as a fraction in the unit it is shown in ("1/1200"), or the text, of a named value; the
     * answers are searched first, then the intermediate values.
     */
    public static function exact(Result $result, string $name): string
    {
        $value = self::find($result, $name)->value;

        return $value instanceof BigRational ? $value->toString() : $value;
    }

    /**
     * The value rounded as the application shows it, to 12 significant digits.
     */
    public static function shown(Result $result, string $name): string
    {
        $value = self::find($result, $name)->value;

        return $value instanceof BigRational ? Precision::significantDigits(12)->apply($value)->toString() : $value;
    }

    /**
     * The symbol of the unit a named value is shown in.
     */
    public static function unit(Result $result, string $name): ?string
    {
        return self::find($result, $name)->unit?->symbol();
    }

    /**
     * The names of the answers, in order.
     *
     * @return list<string>
     */
    public static function names(Result $result): array
    {
        return array_map(static fn (ResultValue $value): string => $value->name, $result->values);
    }

    /**
     * The named value.
     */
    private static function find(Result $result, string $name): ResultValue
    {
        foreach ([...$result->values, ...$result->intermediates] as $value) {
            if ($value->name === $name) {
                return $value;
            }
        }

        throw new OutOfBoundsException("The result has no value \"{$name}\".");
    }
}
