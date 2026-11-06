<?php

declare(strict_types=1);

namespace App\Domain\Quantity;

/**
 * No unit has the identifier asked for.
 */
final class UnknownUnit extends QuantityError
{
    /**
     * @param  string  $id  The identifier no unit has.
     */
    private function __construct(
        public readonly string $id,
    ) {
        parent::__construct("There is no unit \"{$id}\".");
    }

    /**
     * The error for one identifier.
     */
    public static function withId(string $id): self
    {
        return new self($id);
    }
}
