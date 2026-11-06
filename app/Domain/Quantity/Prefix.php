<?php

declare(strict_types=1);

namespace App\Domain\Quantity;

/**
 * An SI prefix, backed by the power of ten it multiplies a unit by.
 *
 * Only the prefixes the calculators and the unit converter use are here; add one when a unit needs it.
 */
enum Prefix: int
{
    case Pico = -12;
    case Nano = -9;
    case Micro = -6;
    case Milli = -3;
    case Centi = -2;
    case None = 0;
    case Kilo = 3;
    case Mega = 6;
    case Giga = 9;

    /**
     * The prefix as written before a unit name: "kilo" in "kilowatt"; empty for no prefix.
     */
    public function word(): string
    {
        return match ($this) {
            self::Pico => 'pico',
            self::Nano => 'nano',
            self::Micro => 'micro',
            self::Milli => 'milli',
            self::Centi => 'centi',
            self::None => '',
            self::Kilo => 'kilo',
            self::Mega => 'mega',
            self::Giga => 'giga',
        };
    }

    /**
     * The prefix as written before a unit symbol: "k" in "kW"; empty for no prefix.
     */
    public function symbol(): string
    {
        return match ($this) {
            self::Pico => 'p',
            self::Nano => 'n',
            self::Micro => 'µ',
            self::Milli => 'm',
            self::Centi => 'c',
            self::None => '',
            self::Kilo => 'k',
            self::Mega => 'M',
            self::Giga => 'G',
        };
    }
}
