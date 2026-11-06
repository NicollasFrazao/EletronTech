<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Electrical;

/**
 * The colours of the bands of a four-band resistor and what each means, IEC 60062:2016 table 1: a digit on the
 * first two bands, a power of ten on the third (the multiplier) and a tolerance on the fourth.
 */
enum ResistorColour: string
{
    case Black = 'black';
    case Brown = 'brown';
    case Red = 'red';
    case Orange = 'orange';
    case Yellow = 'yellow';
    case Green = 'green';
    case Blue = 'blue';
    case Violet = 'violet';
    case Grey = 'grey';
    case White = 'white';
    case Gold = 'gold';
    case Silver = 'silver';

    /**
     * The digit of each colour that can be a digit band.
     */
    private const array DIGITS = [
        'black' => '0', 'brown' => '1', 'red' => '2', 'orange' => '3', 'yellow' => '4',
        'green' => '5', 'blue' => '6', 'violet' => '7', 'grey' => '8', 'white' => '9',
    ];

    /**
     * The power of ten of each colour as a multiplier band; every colour can be one.
     */
    private const array MULTIPLIER_EXPONENTS = [
        'silver' => '-2', 'gold' => '-1', 'black' => '0', 'brown' => '1', 'red' => '2', 'orange' => '3',
        'yellow' => '4', 'green' => '5', 'blue' => '6', 'violet' => '7', 'grey' => '8', 'white' => '9',
    ];

    /**
     * The tolerance, in percent, of each colour that can be a tolerance band.
     */
    private const array TOLERANCES = [
        'brown' => '1', 'red' => '2', 'green' => '0.5', 'blue' => '0.25', 'violet' => '0.1', 'gold' => '5', 'silver' => '10',
    ];

    /**
     * The colours that can be the first band: a digit other than zero.
     *
     * @return non-empty-list<self>
     */
    public static function firstDigitColours(): array
    {
        return array_map(self::from(...), array_keys(array_filter(self::DIGITS, static fn (string $digit): bool => $digit !== '0')));
    }

    /**
     * The colours that can be the second band: any digit.
     *
     * @return non-empty-list<self>
     */
    public static function digitColours(): array
    {
        return array_map(self::from(...), array_keys(self::DIGITS));
    }

    /**
     * The colours that can be the tolerance band.
     *
     * @return non-empty-list<self>
     */
    public static function toleranceColours(): array
    {
        return array_map(self::from(...), array_keys(self::TOLERANCES));
    }

    /**
     * The colour of a digit, 0 to 9.
     */
    public static function ofDigit(int $digit): self
    {
        return self::from((string) array_search((string) $digit, self::DIGITS, true));
    }

    /**
     * The colour of a multiplier, one of multiplierExponents().
     */
    public static function ofMultiplierExponent(int $exponent): self
    {
        return self::from((string) array_search((string) $exponent, self::MULTIPLIER_EXPONENTS, true));
    }

    /**
     * The powers of ten a multiplier band can stand for, smallest first.
     *
     * @return non-empty-list<int>
     */
    public static function multiplierExponents(): array
    {
        return array_map(intval(...), array_values(self::MULTIPLIER_EXPONENTS));
    }

    /**
     * The digit this colour stands for on a digit band; null for gold and silver.
     */
    public function digit(): ?int
    {
        $digit = self::DIGITS[$this->value] ?? null;

        return $digit === null ? null : (int) $digit;
    }

    /**
     * The power of ten this colour stands for on the multiplier band.
     */
    public function multiplierExponent(): int
    {
        return (int) self::MULTIPLIER_EXPONENTS[$this->value];
    }

    /**
     * The tolerance this colour stands for on the tolerance band, in percent; null when it is not a tolerance colour.
     */
    public function tolerancePercent(): ?string
    {
        return self::TOLERANCES[$this->value] ?? null;
    }
}
