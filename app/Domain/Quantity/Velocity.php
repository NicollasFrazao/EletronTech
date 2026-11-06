<?php

declare(strict_types=1);

namespace App\Domain\Quantity;

use Brick\Math\BigNumber;
use Brick\Math\BigRational;

/**
 * The speed of a flow or a body, stored in metres per second.
 */
final readonly class Velocity extends Quantity
{
    /**
     * The dimension every value of this quantity has.
     */
    public static function dimension(): Dimension
    {
        return Dimension::Velocity;
    }

    /**
     * The velocity of a value in metres per second.
     */
    public static function fromMetresPerSecond(BigNumber|int|string $metresPerSecond): self
    {
        return new self(BigRational::of($metresPerSecond));
    }

    /**
     * The exact value in metres per second.
     */
    public function toMetresPerSecond(): BigRational
    {
        return $this->value;
    }
}
