<?php

declare(strict_types=1);

namespace App\Domain\Quantity;

use Brick\Math\BigNumber;
use Brick\Math\BigRational;

/**
 * An inductance, stored in henries.
 *
 * @api
 */
final readonly class Inductance extends Quantity
{
    /**
     * The dimension every value of this quantity has.
     */
    public static function dimension(): Dimension
    {
        return Dimension::Inductance;
    }

    /**
     * The inductance of a value in henries.
     */
    public static function fromHenries(BigNumber|int|string $henries): self
    {
        return new self(BigRational::of($henries));
    }

    /**
     * The exact value in henries.
     */
    public function toHenries(): BigRational
    {
        return $this->value;
    }
}
