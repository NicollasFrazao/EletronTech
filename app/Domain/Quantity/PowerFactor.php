<?php

declare(strict_types=1);

namespace App\Domain\Quantity;

use Brick\Math\BigNumber;
use Brick\Math\BigRational;

/**
 * The ratio of active to apparent power of a load: greater than 0 and at most 1 (1 for a resistive load).
 *
 * @api
 */
final readonly class PowerFactor
{
    private function __construct(
        private BigRational $value,
    ) {}

    /**
     * The power factor of a value such as 0.92.
     *
     * @throws PowerFactorOutOfRange
     */
    public static function of(BigNumber|int|string $value): self
    {
        $exact = BigRational::of($value);

        if ($exact->isNegativeOrZero() || $exact->isGreaterThan(1)) {
            throw new PowerFactorOutOfRange($exact->toString());
        }

        return new self($exact);
    }

    /**
     * The exact ratio.
     */
    public function value(): BigRational
    {
        return $this->value;
    }
}
