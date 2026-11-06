<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Electrical;

use App\Domain\Calculator\Calculator;
use App\Domain\Calculator\FixedUnit;
use App\Domain\Calculator\InputField;
use App\Domain\Calculator\Inputs;
use App\Domain\Calculator\InvalidInput;
use App\Domain\Calculator\RealNumbers;
use App\Domain\Calculator\Result;
use App\Domain\Calculator\ResultValue;
use App\Domain\Quantity\BaseUnit;
use App\Domain\Quantity\Current;
use App\Domain\Quantity\DivisionByZero;
use App\Domain\Quantity\Power;
use App\Domain\Quantity\Resistance;
use App\Domain\Quantity\Voltage;

/**
 * Ohm's law with the power of a resistor: V = R × I and P = V × I, the other two of voltage, current, resistance
 * and power found from any two of them.
 *
 * Whatever two are given, the voltage and the current are found first, then R = V / I and P = V × I; from the
 * resistance and the power, I = √(P / R).
 */
final readonly class OhmsLaw implements Calculator
{
    private const string VOLTAGE = 'voltage';

    private const string CURRENT = 'current';

    private const string RESISTANCE = 'resistance';

    private const string POWER = 'power';

    private const array VALUES = [self::VOLTAGE, self::CURRENT, self::RESISTANCE, self::POWER];

    /**
     * Two values are given and two are left to calculate.
     */
    private const int GIVEN = 2;

    /**
     * The tool's identifier.
     */
    public function id(): string
    {
        return 'ohms-law';
    }

    /**
     * Voltage, current, resistance and power; exactly two of them are left empty.
     *
     * @return non-empty-list<InputField>
     */
    public function inputs(): array
    {
        return [
            InputField::quantity(self::VOLTAGE, FixedUnit::of(BaseUnit::Volt))->optional(),
            InputField::quantity(self::CURRENT, FixedUnit::of(BaseUnit::Ampere))->optional(),
            InputField::quantity(self::RESISTANCE, FixedUnit::of(BaseUnit::Ohm))->optional(),
            InputField::quantity(self::POWER, FixedUnit::of(BaseUnit::Watt))->optional(),
        ];
    }

    /**
     * The four values, the two left empty calculated from the other two.
     *
     * @throws InvalidInput When not exactly two values are given, or one is not greater than zero.
     * @throws DivisionByZero
     */
    public function calculate(Inputs $inputs): Result
    {
        $inputs->missing(self::VALUES, self::GIVEN);

        [$voltage, $current] = $this->voltageAndCurrent($inputs);

        return new Result([
            ResultValue::quantity(self::VOLTAGE, $voltage, FixedUnit::of(BaseUnit::Volt)),
            ResultValue::quantity(self::CURRENT, $current, FixedUnit::of(BaseUnit::Ampere)),
            ResultValue::quantity(self::RESISTANCE, $voltage->dividedByCurrent($current), FixedUnit::of(BaseUnit::Ohm)),
            ResultValue::quantity(self::POWER, $current->timesVoltage($voltage), FixedUnit::of(BaseUnit::Watt)),
        ]);
    }

    /**
     * The voltage and the current, from whichever two values were given.
     *
     * @return array{Voltage, Current}
     *
     * @throws InvalidInput
     * @throws DivisionByZero
     */
    private function voltageAndCurrent(Inputs $inputs): array
    {
        if ($inputs->has(self::VOLTAGE)) {
            $voltage = $inputs->positiveQuantity(self::VOLTAGE, Voltage::class);

            return [$voltage, $this->currentAt($voltage, $inputs)];
        }

        if ($inputs->has(self::CURRENT)) {
            $current = $inputs->positiveQuantity(self::CURRENT, Current::class);

            return [$this->voltageFor($current, $inputs), $current];
        }

        $resistance = $inputs->positiveQuantity(self::RESISTANCE, Resistance::class);
        $power = $inputs->positiveQuantity(self::POWER, Power::class);
        $current = Current::fromAmperes(RealNumbers::squareRoot($power->toWatts()->dividedBy($resistance->toOhms())));

        return [$resistance->timesCurrent($current), $current];
    }

    /**
     * The current at a known voltage, from the current itself, the resistance (I = V / R) or the power (I = P / V).
     *
     * @throws InvalidInput
     * @throws DivisionByZero
     */
    private function currentAt(Voltage $voltage, Inputs $inputs): Current
    {
        return match (true) {
            $inputs->has(self::CURRENT) => $inputs->positiveQuantity(self::CURRENT, Current::class),
            $inputs->has(self::RESISTANCE) => $voltage->dividedByResistance(
                $inputs->positiveQuantity(self::RESISTANCE, Resistance::class),
            ),
            default => $inputs->positiveQuantity(self::POWER, Power::class)->dividedByVoltage($voltage),
        };
    }

    /**
     * The voltage that drives a known current, from the resistance (V = R × I) or the power (V = P / I).
     *
     * @throws InvalidInput
     * @throws DivisionByZero
     */
    private function voltageFor(Current $current, Inputs $inputs): Voltage
    {
        if ($inputs->has(self::RESISTANCE)) {
            return $inputs->positiveQuantity(self::RESISTANCE, Resistance::class)->timesCurrent($current);
        }

        return $inputs->positiveQuantity(self::POWER, Power::class)->dividedByCurrent($current);
    }
}
