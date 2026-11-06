<?php

declare(strict_types=1);

namespace App\Domain\Quantity;

use Throwable;

/**
 * A text meant to be a number is not one, or has more digits than a quantity accepts.
 */
final class InvalidNumber extends QuantityError
{
    /**
     * The error for one text, keeping the parser's reason as the previous exception.
     */
    public static function fromText(string $text, Throwable $reason): self
    {
        return new self("\"{$text}\" is not a valid number.", previous: $reason);
    }
}
