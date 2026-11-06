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
use App\Domain\Quantity\DivisionByZero;
use App\Domain\Quantity\Power;
use Brick\Math\BigRational;

/**
 * Motor efficiency: η = P_u / P_t with P_t = P_u + P_d, from any two of the four values.
 *
 * P_u is the useful (output) power, P_d the power lost in the motor and P_t the input power it takes from the
 * supply.
 */
final readonly class MotorEfficiency implements Calculator
{
    private const string USEFUL = 'useful_power';

    private const string LOSSES = 'lost_power';

    private const string INPUT = 'input_power';

    private const string EFFICIENCY = 'efficiency';

    private const array FIELDS = [self::USEFUL, self::LOSSES, self::INPUT, self::EFFICIENCY];

    /**
     * How many of the four values are left empty.
     */
    private const int UNKNOWNS = 2;

    /**
     * The tool's identifier.
     */
    public function id(): string
    {
        return 'motor-efficiency';
    }

    /**
     * Useful, lost and input power and the efficiency; exactly two of them are left empty.
     *
     * @return non-empty-list<InputField>
     */
    public function inputs(): array
    {
        $watt = FixedUnit::of(BaseUnit::Watt);

        return [
            InputField::quantity(self::USEFUL, $watt)->optional(),
            InputField::quantity(self::LOSSES, $watt)->optional(),
            InputField::quantity(self::INPUT, $watt)->optional(),
            InputField::number(self::EFFICIENCY)->optional(),
        ];
    }

    /**
     * The four values, the two left empty calculated from the other two.
     *
     * @throws InvalidInput
     * @throws DivisionByZero
     */
    public function calculate(Inputs $inputs): Result
    {
        $inputs->missing(self::FIELDS, self::UNKNOWNS);

        [$useful, $input] = $this->usefulAndInputPower($inputs);

        if ($useful->isNegative() || $useful->isZero()) {
            throw InvalidInput::of(self::LOSSES, InputProblem::OutOfRange);
        }

        if ($input->isLessThan($useful)) {
            throw InvalidInput::of(self::INPUT, InputProblem::OutOfRange);
        }

        $watt = FixedUnit::of(BaseUnit::Watt);

        return new Result([
            ResultValue::quantity(self::USEFUL, $useful, $watt),
            ResultValue::quantity(self::LOSSES, $input->minus($useful), $watt),
            ResultValue::quantity(self::INPUT, $input, $watt),
            ResultValue::number(self::EFFICIENCY, $useful->ratioTo($input)),
        ]);
    }

    /**
     * The useful and the input power, from the two values given.
     *
     * @return array{Power, Power}
     *
     * @throws InvalidInput
     * @throws DivisionByZero
     */
    private function usefulAndInputPower(Inputs $inputs): array
    {
        if ($inputs->has(self::USEFUL)) {
            $useful = $inputs->positiveQuantity(self::USEFUL, Power::class);

            return [$useful, $this->inputPowerFromUseful($inputs, $useful)];
        }

        if ($inputs->has(self::INPUT)) {
            $input = $inputs->positiveQuantity(self::INPUT, Power::class);
            $useful = $inputs->has(self::LOSSES)
                ? $input->minus($inputs->nonNegativeQuantity(self::LOSSES, Power::class))
                : $input->multipliedBy($this->efficiency($inputs)->ratio());

            return [$useful, $input];
        }

        return $this->fromLossesAndEfficiency($inputs);
    }

    /**
     * The input power when the useful power is known: P_t given, P_u + P_d, or P_u / η.
     *
     * @throws InvalidInput
     * @throws DivisionByZero
     */
    private function inputPowerFromUseful(Inputs $inputs, Power $useful): Power
    {
        if ($inputs->has(self::INPUT)) {
            return $inputs->positiveQuantity(self::INPUT, Power::class);
        }

        if ($inputs->has(self::LOSSES)) {
            return $useful->plus($inputs->nonNegativeQuantity(self::LOSSES, Power::class));
        }

        return $useful->dividedBy($this->efficiency($inputs)->ratio());
    }

    /**
     * Both powers from the losses and the efficiency: P_t = P_d / (1 − η), P_u = P_t − P_d.
     *
     * @return array{Power, Power}
     *
     * @throws InvalidInput
     * @throws DivisionByZero
     */
    private function fromLossesAndEfficiency(Inputs $inputs): array
    {
        $losses = $inputs->positiveQuantity(self::LOSSES, Power::class);
        $efficiency = $this->efficiency($inputs);

        if ($efficiency->isLossless()) {
            throw InvalidInput::of(self::EFFICIENCY, InputProblem::OutOfRange);
        }

        $input = $losses->dividedBy(BigRational::one()->minus($efficiency->ratio()));

        return [$input->minus($losses), $input];
    }

    /**
     * The efficiency given, greater than 0 and at most 1.
     *
     * @throws InvalidInput
     */
    private function efficiency(Inputs $inputs): Efficiency
    {
        return Efficiency::tryOf($inputs->number(self::EFFICIENCY))
            ?? throw InvalidInput::of(self::EFFICIENCY, InputProblem::OutOfRange);
    }
}
