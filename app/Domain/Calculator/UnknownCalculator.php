<?php

declare(strict_types=1);

namespace App\Domain\Calculator;

/**
 * No calculator has the identifier asked for.
 */
final class UnknownCalculator extends CalculatorError
{
    /**
     * The error for one identifier.
     */
    public static function withId(string $id): self
    {
        return new self("There is no calculator \"{$id}\".");
    }
}
