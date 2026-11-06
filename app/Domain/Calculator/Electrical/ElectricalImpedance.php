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
use App\Domain\Quantity\Capacitance;
use App\Domain\Quantity\Frequency;
use App\Domain\Quantity\Resistance;
use Brick\Math\BigRational;

/**
 * Electrical impedance of a resistance in series with a capacitance, at the frequency of the current.
 *
 * The capacitive reactance is X_C = 1 / (2πfC) and the impedance's magnitude Z = √(R² + X_C²).
 */
final readonly class ElectricalImpedance implements Calculator
{
    /**
     * A turn is 2π radians, so the angular frequency is ω = 2πf.
     */
    private const int PI_RADIANS_PER_TURN = 2;

    /**
     * The tool's identifier.
     */
    public function id(): string
    {
        return 'electrical-impedance';
    }

    /**
     * The resistance, the frequency of the current and the capacitance.
     *
     * @return non-empty-list<InputField>
     */
    public function inputs(): array
    {
        return [
            InputField::quantity('resistance', FixedUnit::of(BaseUnit::Ohm)),
            InputField::quantity('frequency', FixedUnit::of(BaseUnit::Hertz)),
            InputField::quantity('capacitance', FixedUnit::of(BaseUnit::Farad)),
        ];
    }

    /**
     * The impedance, with the capacitive reactance as the intermediate value.
     *
     * @throws InvalidInput
     */
    public function calculate(Inputs $inputs): Result
    {
        $resistance = $inputs->nonNegativeQuantity('resistance', Resistance::class)->toOhms();
        $frequency = $inputs->positiveQuantity('frequency', Frequency::class)->toHertz();
        $capacitance = $inputs->positiveQuantity('capacitance', Capacitance::class)->toFarads();

        $angularFrequency = RealNumbers::pi()->multipliedBy(self::PI_RADIANS_PER_TURN)->multipliedBy($frequency);
        $reactance = BigRational::one()->dividedBy($angularFrequency->multipliedBy($capacitance));
        $impedance = RealNumbers::squareRoot($resistance->multipliedBy($resistance)->plus($reactance->multipliedBy($reactance)));

        $ohm = FixedUnit::of(BaseUnit::Ohm);

        return new Result(
            [ResultValue::quantity('impedance', Resistance::fromOhms($impedance), $ohm)],
            [ResultValue::quantity('capacitive_reactance', Resistance::fromOhms($reactance), $ohm)],
        );
    }
}
