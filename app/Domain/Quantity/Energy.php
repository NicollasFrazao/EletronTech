<?php

declare(strict_types=1);

namespace App\Domain\Quantity;

use Brick\Math\BigNumber;
use Brick\Math\BigRational;

/**
 * An amount of energy, stored in joules.
 */
final readonly class Energy extends Quantity
{
    /**
     * The dimension every value of this quantity has.
     */
    public static function dimension(): Dimension
    {
        return Dimension::Energy;
    }

    /**
     * The energy of a value in joules.
     */
    public static function fromJoules(BigNumber|int|string $joules): self
    {
        return new self(BigRational::of($joules));
    }

    /**
     * The exact value in joules.
     */
    public function toJoules(): BigRational
    {
        return $this->value;
    }
}
