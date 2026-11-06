<?php

declare(strict_types=1);

namespace App\Domain\Quantity;

use Brick\Math\BigNumber;
use Brick\Math\BigRational;

/**
 * An area, stored in square metres.
 */
final readonly class Area extends Quantity
{
    /**
     * The dimension every value of this quantity has.
     */
    public static function dimension(): Dimension
    {
        return Dimension::Area;
    }

    /**
     * The area of a value in square metres.
     */
    public static function fromSquareMetres(BigNumber|int|string $squareMetres): self
    {
        return new self(BigRational::of($squareMetres));
    }

    /**
     * The exact value in square metres.
     */
    public function toSquareMetres(): BigRational
    {
        return $this->value;
    }

    /**
     * The other side of a rectangle of this area with one side known.
     *
     * @throws DivisionByZero
     */
    public function dividedByLength(Length $side): Length
    {
        return Length::fromMetres(self::quotient($this->value, $side->toMetres()));
    }

    /**
     * The volume of a prism or cylinder with this base and a height (V = A × h).
     */
    public function timesLength(Length $height): Volume
    {
        return Volume::fromCubicMetres($this->value->multipliedBy($height->toMetres()));
    }
}
