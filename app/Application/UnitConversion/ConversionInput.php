<?php

declare(strict_types=1);

namespace App\Application\UnitConversion;

/**
 * What a person asks the unit converter: a value as typed, the unit it is in and the unit wanted.
 */
final readonly class ConversionInput
{
    /**
     * @param  string  $value  The number as typed, with a decimal point: "1.5", "4.7e-6".
     * @param  string  $fromUnit  Identifier of the unit the value is in, such as "kilowatt".
     * @param  string  $toUnit  Identifier of the unit to convert to, of the same dimension.
     */
    public function __construct(
        public string $value,
        public string $fromUnit,
        public string $toUnit,
    ) {}
}
