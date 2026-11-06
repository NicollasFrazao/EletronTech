<?php

declare(strict_types=1);

namespace App\Application\Calculation;

use App\Application\UnitConversion\UnitOption;

/**
 * One value of a calculation's result, ready to show.
 */
final readonly class ResultLine
{
    /**
     * @param  string  $value  A number with a decimal point, rounded for display, or a text such as "yellow".
     * @param  UnitOption|null  $unit  The unit of a quantity; null for a pure number or a text.
     * @param  bool  $isExact  False when the rounding for display changed the value.
     */
    public function __construct(
        public string $name,
        public string $value,
        public ?UnitOption $unit,
        public bool $isExact,
    ) {}
}
