<?php

declare(strict_types=1);

namespace App\Domain\Quantity;

use Brick\Math\BigNumber;
use Brick\Math\BigRational;

/**
 * A length or distance, stored in metres.
 */
final readonly class Length extends Quantity
{
    /**
     * The dimension every value of this quantity has.
     */
    public static function dimension(): Dimension
    {
        return Dimension::Length;
    }

    /**
     * The length of a value in metres.
     */
    public static function fromMetres(BigNumber|int|string $metres): self
    {
        return new self(BigRational::of($metres));
    }

    /**
     * The exact value in metres.
     */
    public function toMetres(): BigRational
    {
        return $this->value;
    }

    /**
     * The area of a rectangle with this length and a width.
     */
    public function timesLength(Length $width): Area
    {
        return Area::fromSquareMetres($this->value->multipliedBy($width->toMetres()));
    }
}
