<?php

declare(strict_types=1);

namespace App\Application\UnitConversion;

use App\Domain\Quantity\Dimension;
use App\Domain\Quantity\UnitCatalogue;

/**
 * Lists the units the converter offers, grouped by dimension.
 */
final readonly class ListConvertibleUnits
{
    public function __construct(
        private UnitCatalogue $catalogue,
    ) {}

    /**
     * One group per dimension, in the order of Dimension, each with its units smallest first.
     *
     * @return list<UnitGroup>
     */
    public function handle(): array
    {
        return array_map(
            fn (Dimension $dimension): UnitGroup => new UnitGroup(
                $dimension->value,
                array_map(UnitOption::of(...), $this->catalogue->ofDimension($dimension)),
            ),
            Dimension::cases(),
        );
    }
}
