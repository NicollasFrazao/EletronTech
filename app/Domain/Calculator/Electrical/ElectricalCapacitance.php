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
use App\Domain\Quantity\Charge;
use App\Domain\Quantity\Current;
use App\Domain\Quantity\DivisionByZero;
use App\Domain\Quantity\Power;

/**
 * Electrical capacitance: the capacitance that holds a charge at the voltage of a load of known power and current.
 *
 * The voltage is V = P / I and the capacitance C = Q / V, the definition of capacitance.
 */
final readonly class ElectricalCapacitance implements Calculator
{
    /**
     * The tool's identifier.
     */
    public function id(): string
    {
        return 'electrical-capacitance';
    }

    /**
     * The charge, and the power and current the voltage is found from.
     *
     * @return non-empty-list<InputField>
     */
    public function inputs(): array
    {
        return [
            InputField::quantity('charge', FixedUnit::of(BaseUnit::Coulomb)),
            InputField::quantity('power', FixedUnit::of(BaseUnit::Watt)),
            InputField::quantity('current', FixedUnit::of(BaseUnit::Ampere)),
        ];
    }

    /**
     * The capacitance, with the voltage as the intermediate value.
     *
     * @throws InvalidInput
     * @throws DivisionByZero
     */
    public function calculate(Inputs $inputs): Result
    {
        $charge = $inputs->positiveQuantity('charge', Charge::class);
        $power = $inputs->positiveQuantity('power', Power::class);
        $current = $inputs->positiveQuantity('current', Current::class);

        $voltage = $power->dividedByCurrent($current);

        return new Result(
            [ResultValue::quantity('capacitance', $charge->dividedByVoltage($voltage), FixedUnit::of(BaseUnit::Farad))],
            [ResultValue::quantity('voltage', $voltage, FixedUnit::of(BaseUnit::Volt))],
        );
    }
}
