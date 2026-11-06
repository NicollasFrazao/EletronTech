<?php

declare(strict_types=1);

namespace App\Application\UnitConversion;

/**
 * The units of one dimension, smallest first, as the converter lists them.
 */
final readonly class UnitGroup
{
    /**
     * @param  string  $dimension  The dimension identifier, such as "voltage" or "apparent_power".
     * @param  list<UnitOption>  $units
     */
    public function __construct(
        public string $dimension,
        public array $units,
    ) {}
}
