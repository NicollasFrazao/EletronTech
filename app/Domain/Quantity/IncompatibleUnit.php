<?php

declare(strict_types=1);

namespace App\Domain\Quantity;

/**
 * A unit was used with a quantity of another dimension, such as a voltage expressed in amperes.
 */
final class IncompatibleUnit extends QuantityError
{
    /**
     * The error for a unit that does not measure the expected dimension.
     */
    public static function forDimension(Unit $unit, Dimension $expected): self
    {
        return new self(
            "{$unit->name()} measures {$unit->dimension()->value}, not {$expected->value}.",
        );
    }
}
