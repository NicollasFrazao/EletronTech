<?php

declare(strict_types=1);

namespace App\Domain\Quantity;

use Brick\Math\BigNumber;
use Brick\Math\BigRational;

/**
 * A span of time, stored in seconds.
 */
final readonly class Duration extends Quantity
{
    /**
     * The dimension every value of this quantity has.
     */
    public static function dimension(): Dimension
    {
        return Dimension::Duration;
    }

    /**
     * The duration of a value in seconds.
     */
    public static function fromSeconds(BigNumber|int|string $seconds): self
    {
        return new self(BigRational::of($seconds));
    }

    /**
     * The exact value in seconds.
     */
    public function toSeconds(): BigRational
    {
        return $this->value;
    }
}
