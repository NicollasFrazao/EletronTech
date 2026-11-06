<?php

declare(strict_types=1);

namespace App\Application\Calculation;

use App\Application\UnitConversion\UnitOption;

/**
 * What an input accepts: for a quantity, its units; for a choice, its options; nothing more for a pure number.
 */
final readonly class AcceptedValues
{
    /**
     * @param  UnitOption|null  $defaultUnit  The unit a quantity is read in when none is named.
     * @param  list<UnitOption>  $units  Every unit a quantity may be typed in, smallest first.
     * @param  list<string>  $options  The option identifiers of a choice.
     */
    public function __construct(
        public ?UnitOption $defaultUnit,
        public array $units,
        public array $options,
    ) {}
}
