<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Mathematics;

/**
 * A positional numeral system the binary converter reads and writes whole numbers in.
 */
enum NumberBase: string
{
    case Binary = 'binary';
    case Octal = 'octal';
    case Decimal = 'decimal';
    case Hexadecimal = 'hexadecimal';

    /**
     * The digits of each base, as a character class; hexadecimal digits in either case.
     */
    private const array DIGITS = [
        'binary' => '01',
        'octal' => '0-7',
        'decimal' => '0-9',
        'hexadecimal' => '0-9A-Fa-f',
    ];

    private const int BINARY_RADIX = 2;

    private const int OCTAL_RADIX = 8;

    private const int DECIMAL_RADIX = 10;

    private const int HEXADECIMAL_RADIX = 16;

    /**
     * How many digits the base has: 2, 8, 10 or 16.
     *
     * @return 2|8|10|16
     */
    public function radix(): int
    {
        return match ($this) {
            self::Binary => self::BINARY_RADIX,
            self::Octal => self::OCTAL_RADIX,
            self::Decimal => self::DECIMAL_RADIX,
            self::Hexadecimal => self::HEXADECIMAL_RADIX,
        };
    }

    /**
     * Whether a text is a whole number written with this base's digits only, with no sign or separator.
     *
     * @phpstan-assert-if-true non-empty-string $text
     */
    public function isWrittenIn(string $text): bool
    {
        return preg_match('/^['.self::DIGITS[$this->value].']+$/', $text) === 1;
    }
}
