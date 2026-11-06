<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Electrical;

use App\Domain\Calculator\Calculator;
use App\Domain\Calculator\FixedUnit;
use App\Domain\Calculator\InputField;
use App\Domain\Calculator\InputProblem;
use App\Domain\Calculator\Inputs;
use App\Domain\Calculator\InvalidInput;
use App\Domain\Calculator\RealNumbers;
use App\Domain\Calculator\Result;
use App\Domain\Calculator\ResultValue;
use App\Domain\Quantity\ApparentPower;
use App\Domain\Quantity\BaseUnit;
use App\Domain\Quantity\Current;
use App\Domain\Quantity\PowerFactor;
use App\Domain\Quantity\PowerFactorOutOfRange;
use App\Domain\Quantity\ReactivePower;
use App\Domain\Quantity\Voltage;
use Brick\Math\BigRational;

/**
 * General power: the active, reactive and apparent power of a single-phase, two-phase or three-phase load.
 *
 * S = k × V × I, with k = 1 for one or two phases and √3 for three phases; P = S × cos φ and
 * Q = S × sin φ = S × √(1 − cos² φ), so that S² = P² + Q² (the power triangle).
 */
final readonly class GeneralPower implements Calculator
{
    private const string POWER_FACTOR = 'power_factor';

    /**
     * The tool's identifier.
     */
    public function id(): string
    {
        return 'general-power';
    }

    /**
     * The supply system, the voltage across the load, its current and its power factor.
     *
     * @return non-empty-list<InputField>
     */
    public function inputs(): array
    {
        return [
            InputField::choice('supply_system', SupplySystem::cases()),
            InputField::quantity('voltage', FixedUnit::of(BaseUnit::Volt)),
            InputField::quantity('current', FixedUnit::of(BaseUnit::Ampere)),
            InputField::number(self::POWER_FACTOR),
        ];
    }

    /**
     * Active, reactive and apparent power, with the factor of the supply system as the intermediate value.
     *
     * @throws InvalidInput
     */
    public function calculate(Inputs $inputs): Result
    {
        $system = $inputs->choice('supply_system', SupplySystem::class);
        $voltage = $inputs->positiveQuantity('voltage', Voltage::class);
        $current = $inputs->positiveQuantity('current', Current::class);
        $powerFactor = $this->powerFactor($inputs);

        $apparent = ApparentPower::fromVoltageAndCurrent($voltage, $current)->multipliedBy($system->lineFactor());
        $cosine = $powerFactor->value();
        $sine = RealNumbers::squareRoot(BigRational::one()->minus($cosine->multipliedBy($cosine)));
        $reactive = ReactivePower::fromVoltAmperesReactive($apparent->toVoltAmperes()->multipliedBy($sine));

        return new Result(
            [
                ResultValue::quantity('active_power', $apparent->timesPowerFactor($powerFactor), FixedUnit::of(BaseUnit::Watt)),
                ResultValue::quantity('reactive_power', $reactive, FixedUnit::of(BaseUnit::VoltAmpereReactive)),
                ResultValue::quantity('apparent_power', $apparent, FixedUnit::of(BaseUnit::VoltAmpere)),
            ],
            [ResultValue::number('line_factor', $system->lineFactor())],
        );
    }

    /**
     * The power factor given, greater than 0 and at most 1.
     *
     * @throws InvalidInput
     */
    private function powerFactor(Inputs $inputs): PowerFactor
    {
        try {
            return PowerFactor::of($inputs->number(self::POWER_FACTOR));
        } catch (PowerFactorOutOfRange) {
            throw InvalidInput::of(self::POWER_FACTOR, InputProblem::OutOfRange);
        }
    }
}
