<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Electrical;

use App\Domain\Calculator\FixedUnit;
use App\Domain\Quantity\BaseUnit;
use App\Domain\Quantity\Energy;
use App\Domain\Quantity\Prefix;
use Brick\Math\BigRational;

/**
 * The price of one kilowatt-hour on an electricity bill, in any currency; never negative.
 */
final readonly class EnergyTariff
{
    private function __construct(
        private BigRational $pricePerKilowattHour,
    ) {}

    /**
     * The tariff of a price per kilowatt-hour; null when the price is negative.
     */
    public static function tryOf(BigRational $pricePerKilowattHour): ?self
    {
        return $pricePerKilowattHour->isNegative() ? null : new self($pricePerKilowattHour);
    }

    /**
     * What an amount of energy costs at this tariff, exactly, in the tariff's currency.
     */
    public function costOf(Energy $energy): BigRational
    {
        $kilowattHours = $energy->toJoules()->dividedBy(FixedUnit::of(BaseUnit::WattHour, Prefix::Kilo)->size());

        return $kilowattHours->multipliedBy($this->pricePerKilowattHour);
    }
}
