<?php

declare(strict_types=1);

namespace App\Application\Calculation;

/**
 * What a person asks a calculator: the tool, the values as typed and, for quantities, the units they are in.
 */
final readonly class CalculationInput
{
    /**
     * @param  string  $calculator  The calculator's identifier, such as "outlet-count".
     * @param  array<string, string>  $values  Keyed by input name: a number as typed ("2.5", "4.7e-6") or an option.
     * @param  array<string, string>  $units  Keyed by input name: the unit identifier of a quantity typed in a unit
     *                                        other than the input's default, such as "kilowatt".
     */
    public function __construct(
        public string $calculator,
        public array $values,
        public array $units = [],
    ) {}
}
