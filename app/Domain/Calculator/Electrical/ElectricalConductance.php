<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Electrical;

use App\Domain\Calculator\Calculator;
use App\Domain\Calculator\FixedUnit;
use App\Domain\Calculator\InputField;
use App\Domain\Calculator\Inputs;
use App\Domain\Calculator\InvalidInput;
use App\Domain\Calculator\Result;
use App\Domain\Calculator\ResultValue;
use App\Domain\Quantity\BaseUnit;
use App\Domain\Quantity\Conductance;
use App\Domain\Quantity\Current;
use App\Domain\Quantity\DivisionByZero;
use App\Domain\Quantity\Voltage;

/**
 * Electrical conductance: G = I / V, solved for whichever of the three values is left empty.
 */
final readonly class ElectricalConductance implements Calculator
{
    private const string CONDUCTANCE = 'conductance';

    private const string VOLTAGE = 'voltage';

    private const string CURRENT = 'current';

    /**
     * The tool's identifier.
     */
    public function id(): string
    {
        return 'electrical-conductance';
    }

    /**
     * Conductance, voltage and current; exactly one of them is left empty.
     *
     * @return non-empty-list<InputField>
     */
    public function inputs(): array
    {
        return [
            InputField::quantity(self::CONDUCTANCE, FixedUnit::of(BaseUnit::Siemens))->optional(),
            InputField::quantity(self::VOLTAGE, FixedUnit::of(BaseUnit::Volt))->optional(),
            InputField::quantity(self::CURRENT, FixedUnit::of(BaseUnit::Ampere))->optional(),
        ];
    }

    /**
     * The three values, the one left empty calculated from the other two.
     *
     * @throws InvalidInput
     * @throws DivisionByZero
     */
    public function calculate(Inputs $inputs): Result
    {
        [$unknown] = $inputs->missing([self::CONDUCTANCE, self::VOLTAGE, self::CURRENT], 1);

        [$conductance, $voltage, $current] = match ($unknown) {
            self::CONDUCTANCE => $this->solveForConductance($inputs),
            self::VOLTAGE => $this->solveForVoltage($inputs),
            default => $this->solveForCurrent($inputs),
        };

        return new Result([
            ResultValue::quantity(self::CONDUCTANCE, $conductance, FixedUnit::of(BaseUnit::Siemens)),
            ResultValue::quantity(self::VOLTAGE, $voltage, FixedUnit::of(BaseUnit::Volt)),
            ResultValue::quantity(self::CURRENT, $current, FixedUnit::of(BaseUnit::Ampere)),
        ]);
    }

    /**
     * G = I / V.
     *
     * @return array{Conductance, Voltage, Current}
     *
     * @throws InvalidInput
     * @throws DivisionByZero
     */
    private function solveForConductance(Inputs $inputs): array
    {
        $voltage = $inputs->positiveQuantity(self::VOLTAGE, Voltage::class);
        $current = $inputs->positiveQuantity(self::CURRENT, Current::class);

        return [$current->dividedByVoltage($voltage), $voltage, $current];
    }

    /**
     * V = I / G.
     *
     * @return array{Conductance, Voltage, Current}
     *
     * @throws InvalidInput
     * @throws DivisionByZero
     */
    private function solveForVoltage(Inputs $inputs): array
    {
        $conductance = $inputs->positiveQuantity(self::CONDUCTANCE, Conductance::class);
        $current = $inputs->positiveQuantity(self::CURRENT, Current::class);

        return [$conductance, $current->dividedByConductance($conductance), $current];
    }

    /**
     * I = G × V.
     *
     * @return array{Conductance, Voltage, Current}
     *
     * @throws InvalidInput
     */
    private function solveForCurrent(Inputs $inputs): array
    {
        $conductance = $inputs->positiveQuantity(self::CONDUCTANCE, Conductance::class);
        $voltage = $inputs->positiveQuantity(self::VOLTAGE, Voltage::class);

        return [$conductance, $voltage, $conductance->timesVoltage($voltage)];
    }
}
