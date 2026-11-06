<?php

declare(strict_types=1);

namespace App\Application\UnitConversion;

/**
 * The answer of the unit converter, ready to show.
 */
final readonly class ConversionResult
{
    /**
     * @param  ValueInUnit  $from  The value converted, as read.
     * @param  ValueInUnit  $to  The converted value, rounded for display.
     * @param  bool  $isExact  False when the rounding for display changed the value (1 ft in yards is 0.333...).
     */
    public function __construct(
        public ValueInUnit $from,
        public ValueInUnit $to,
        public bool $isExact,
    ) {}
}
