<?php

declare(strict_types=1);

namespace App\Application\UnitConversion;

use App\Domain\Quantity\Unit;

/**
 * A unit as the converter shows it.
 */
final readonly class UnitOption
{
    /**
     * @param  string  $id  The identifier the converter takes back, such as "kilowatt".
     */
    public function __construct(
        public string $id,
        public string $name,
        public string $symbol,
    ) {}

    /**
     * The option for a domain unit.
     */
    public static function of(Unit $unit): self
    {
        return new self($unit->id(), $unit->name(), $unit->symbol());
    }
}
