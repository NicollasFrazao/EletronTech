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
use App\Domain\Quantity\Resistance;
use Brick\Math\BigRational;

/**
 * Resistor colour code, IEC 60062: the resistance and tolerance of a four-band resistor from its colours, or the
 * colours of a resistance.
 *
 * The resistance is (10 × first digit + second digit) × 10^multiplier; the tolerance band gives the range around
 * it, ±20% when there is none. Going the other way, a resistance has colours only when it is two significant
 * digits times a power of ten from 10⁻² to 10⁹.
 */
final readonly class ResistorColourCode implements Calculator
{
    private const string RESISTANCE = 'resistance';

    private const string FIRST_BAND = 'first_band';

    private const string SECOND_BAND = 'second_band';

    private const string MULTIPLIER_BAND = 'multiplier_band';

    private const string TOLERANCE_BAND = 'tolerance_band';

    /**
     * The tolerance of a resistor without a tolerance band, in percent.
     */
    private const string TOLERANCE_WITHOUT_BAND = '20';

    private const int PERCENT = 100;

    /**
     * The tool's identifier.
     */
    public function id(): string
    {
        return 'resistor-colour-code';
    }

    /**
     * Either the resistance or the first three bands, and optionally the tolerance band.
     *
     * @return non-empty-list<InputField>
     */
    public function inputs(): array
    {
        return [
            InputField::quantity(self::RESISTANCE, FixedUnit::of(BaseUnit::Ohm))->optional(),
            InputField::choice(self::FIRST_BAND, ResistorColour::firstDigitColours())->optional(),
            InputField::choice(self::SECOND_BAND, ResistorColour::digitColours())->optional(),
            InputField::choice(self::MULTIPLIER_BAND, ResistorColour::cases())->optional(),
            InputField::choice(self::TOLERANCE_BAND, ResistorColour::toleranceColours())->optional(),
        ];
    }

    /**
     * The resistance, its three bands and the tolerance, with the lowest and highest resistance the tolerance allows.
     *
     * @throws InvalidInput
     */
    public function calculate(Inputs $inputs): Result
    {
        $bands = $inputs->has(self::RESISTANCE) ? $this->encode($inputs) : $this->decode($inputs);
        $resistance = $bands->resistance();
        $tolerancePercent = $this->tolerancePercent($inputs);
        $deviation = $resistance->multipliedBy(BigRational::of($tolerancePercent)->dividedBy(self::PERCENT));
        $ohm = FixedUnit::of(BaseUnit::Ohm);

        return new Result(
            [
                ResultValue::quantity(self::RESISTANCE, $resistance, $ohm),
                ResultValue::text(self::FIRST_BAND, $bands->first->value),
                ResultValue::text(self::SECOND_BAND, $bands->second->value),
                ResultValue::text(self::MULTIPLIER_BAND, $bands->multiplier->value),
                ResultValue::number('tolerance_percent', BigRational::of($tolerancePercent)),
            ],
            [
                ResultValue::quantity('minimum_resistance', $resistance->minus($deviation), $ohm),
                ResultValue::quantity('maximum_resistance', $resistance->plus($deviation), $ohm),
            ],
        );
    }

    /**
     * The bands given.
     *
     * @throws InvalidInput
     */
    private function decode(Inputs $inputs): ResistorBands
    {
        $first = $inputs->choice(self::FIRST_BAND, ResistorColour::class);
        $second = $inputs->choice(self::SECOND_BAND, ResistorColour::class);
        $multiplier = $inputs->choice(self::MULTIPLIER_BAND, ResistorColour::class);

        if (($first->digit() ?? 0) === 0) {
            throw InvalidInput::of(self::FIRST_BAND, InputProblem::UnknownOption);
        }

        return ResistorBands::tryOf($first, $second, $multiplier)
            ?? throw InvalidInput::of(self::SECOND_BAND, InputProblem::UnknownOption);
    }

    /**
     * The bands of the resistance given; the bands themselves must be left empty.
     *
     * @throws InvalidInput
     */
    private function encode(Inputs $inputs): ResistorBands
    {
        foreach ([self::FIRST_BAND, self::SECOND_BAND, self::MULTIPLIER_BAND] as $band) {
            $inputs->assertAbsent($band, InputProblem::WrongNumberOfValues);
        }

        return ResistorBands::tryOfResistance($inputs->positiveQuantity(self::RESISTANCE, Resistance::class))
            ?? throw InvalidInput::of(self::RESISTANCE, InputProblem::NotRepresentable);
    }

    /**
     * The tolerance band's tolerance in percent, or that of a resistor without one.
     *
     * @throws InvalidInput
     */
    private function tolerancePercent(Inputs $inputs): string
    {
        if (! $inputs->has(self::TOLERANCE_BAND)) {
            return self::TOLERANCE_WITHOUT_BAND;
        }

        return $inputs->choice(self::TOLERANCE_BAND, ResistorColour::class)->tolerancePercent()
            ?? throw InvalidInput::of(self::TOLERANCE_BAND, InputProblem::UnknownOption);
    }
}
