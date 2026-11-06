<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Electrical;

use App\Domain\Calculator\Calculator;
use App\Domain\Calculator\FixedUnit;
use App\Domain\Calculator\InputField;
use App\Domain\Calculator\InputProblem;
use App\Domain\Calculator\Inputs;
use App\Domain\Calculator\InvalidInput;
use App\Domain\Calculator\Result;
use App\Domain\Calculator\ResultValue;
use App\Domain\Quantity\BaseUnit;
use App\Domain\Quantity\Duration;
use App\Domain\Quantity\Power;
use App\Domain\Quantity\Prefix;

/**
 * Electrical consumption: the energy an appliance uses over a period and, with a tariff, what it costs.
 *
 * E = P × t × days, the way an electricity bill counts it, in kilowatt-hours; the cost is E × tariff.
 */
final readonly class ElectricalConsumption implements Calculator
{
    private const string DAILY_USE = 'daily_use';

    private const string TARIFF = 'tariff';

    /**
     * An appliance cannot run more hours in a day than the day has.
     */
    private const int HOURS_PER_DAY = 24;

    /**
     * The tool's identifier.
     */
    public function id(): string
    {
        return 'electrical-consumption';
    }

    /**
     * The appliance's power, how long it runs per day, for how many days, and optionally the price per kWh.
     *
     * @return non-empty-list<InputField>
     */
    public function inputs(): array
    {
        return [
            InputField::quantity('power', FixedUnit::of(BaseUnit::Watt)),
            InputField::quantity(self::DAILY_USE, FixedUnit::of(BaseUnit::Hour)),
            InputField::number('days'),
            InputField::number(self::TARIFF)->optional(),
        ];
    }

    /**
     * The energy over the period and, when a tariff is given, its cost; the energy per day is the intermediate.
     *
     * @throws InvalidInput
     */
    public function calculate(Inputs $inputs): Result
    {
        $power = $inputs->positiveQuantity('power', Power::class);
        $dailyUse = $inputs->positiveQuantity(self::DAILY_USE, Duration::class);
        $days = $inputs->positiveWholeNumber('days');

        if ($dailyUse->isGreaterThan($this->day())) {
            throw InvalidInput::of(self::DAILY_USE, InputProblem::OutOfRange);
        }

        $daily = $power->timesDuration($dailyUse);
        $energy = $daily->multipliedBy($days);
        $kilowattHour = FixedUnit::of(BaseUnit::WattHour, Prefix::Kilo);

        $values = [ResultValue::quantity('energy', $energy, $kilowattHour)];

        if ($inputs->has(self::TARIFF)) {
            $tariff = EnergyTariff::tryOf($inputs->number(self::TARIFF))
                ?? throw InvalidInput::of(self::TARIFF, InputProblem::Negative);
            $values[] = ResultValue::number('cost', $tariff->costOf($energy));
        }

        return new Result($values, [ResultValue::quantity('daily_energy', $daily, $kilowattHour)]);
    }

    /**
     * One day.
     */
    private function day(): Duration
    {
        return Duration::fromSeconds(FixedUnit::of(BaseUnit::Hour)->toCoherentUnit(self::HOURS_PER_DAY));
    }
}
