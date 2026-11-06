<?php

declare(strict_types=1);

namespace App\Domain\Quantity;

use Brick\Math\BigNumber;
use Brick\Math\BigRational;

/**
 * A frequency, stored in hertz.
 */
final readonly class Frequency extends Quantity
{
    /**
     * The dimension every value of this quantity has.
     */
    public static function dimension(): Dimension
    {
        return Dimension::Frequency;
    }

    /**
     * The frequency of a value in hertz.
     */
    public static function fromHertz(BigNumber|int|string $hertz): self
    {
        return new self(BigRational::of($hertz));
    }

    /**
     * The exact value in hertz.
     */
    public function toHertz(): BigRational
    {
        return $this->value;
    }
}
