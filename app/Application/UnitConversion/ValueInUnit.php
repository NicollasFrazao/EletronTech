<?php

declare(strict_types=1);

namespace App\Application\UnitConversion;

/**
 * A number and the unit it is in, as the converter shows them.
 */
final readonly class ValueInUnit
{
    /**
     * @param  string  $value  The number with a decimal point, such as "1.5" or "0.333333333333".
     */
    public function __construct(
        public string $value,
        public UnitOption $unit,
    ) {}
}
