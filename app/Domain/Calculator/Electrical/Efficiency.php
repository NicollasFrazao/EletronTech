<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Electrical;

use Brick\Math\BigRational;

/**
 * The efficiency of a machine, useful power over input power: greater than 0 and at most 1.
 */
final readonly class Efficiency
{
    private function __construct(
        private BigRational $ratio,
    ) {}

    /**
     * The efficiency of a ratio such as 0.85; null when it is not greater than 0 and at most 1.
     */
    public static function tryOf(BigRational $ratio): ?self
    {
        if ($ratio->isNegativeOrZero() || $ratio->isGreaterThan(1)) {
            return null;
        }

        return new self($ratio);
    }

    /**
     * The exact ratio.
     */
    public function ratio(): BigRational
    {
        return $this->ratio;
    }

    /**
     * Whether the machine loses nothing (the ratio is exactly 1).
     */
    public function isLossless(): bool
    {
        return $this->ratio->isEqualTo(1);
    }
}
