<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Construction;

use Brick\Math\BigNumber;
use Brick\Math\BigRational;

/**
 * The extra share of material bought for cuts and breakage, in percent of what the surface needs: from 0% to 100%,
 * 10% unless the person says otherwise.
 */
final readonly class WasteAllowance
{
    private const int PERCENT = 100;

    /**
     * The allowance builders usually add for tiles and blocks laid in a straight pattern.
     */
    private const int USUAL_PERCENT = 10;

    private function __construct(
        private BigRational $percent,
    ) {}

    /**
     * The allowance of a percentage; null when it is below 0% or above 100%.
     */
    public static function tryOf(BigRational $percent): ?self
    {
        if ($percent->isNegative() || $percent->isGreaterThan(self::PERCENT)) {
            return null;
        }

        return new self($percent);
    }

    /**
     * The usual 10%.
     */
    public static function usual(): self
    {
        return new self(BigRational::of(self::USUAL_PERCENT));
    }

    /**
     * The percentage.
     */
    public function percent(): BigRational
    {
        return $this->percent;
    }

    /**
     * A quantity of material with the allowance added: n × (1 + p / 100).
     */
    public function addedTo(BigNumber $quantity): BigRational
    {
        return $quantity->toBigRational()->multipliedBy(BigRational::one()->plus($this->percent->dividedBy(self::PERCENT)));
    }
}
