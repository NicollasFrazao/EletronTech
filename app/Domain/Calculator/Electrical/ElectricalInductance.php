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
use App\Domain\Quantity\Current;
use App\Domain\Quantity\DivisionByZero;
use App\Domain\Quantity\Inductance;
use App\Domain\Quantity\MagneticFlux;
use Brick\Math\BigNumber;
use Brick\Math\RoundingMode;

/**
 * Electrical inductance of a coil: L = N × Φ / I, solved for whichever of the four values is left empty.
 *
 * N is the number of turns, Φ the magnetic flux through each turn and I the current; N × Φ is the flux linkage.
 * Solved for the turns, the result is rounded up to a whole turn, the fewest that reach the inductance.
 */
final readonly class ElectricalInductance implements Calculator
{
    private const string INDUCTANCE = 'inductance';

    private const string TURNS = 'turns';

    private const string MAGNETIC_FLUX = 'magnetic_flux';

    private const string CURRENT = 'current';

    /**
     * The tool's identifier.
     */
    public function id(): string
    {
        return 'electrical-inductance';
    }

    /**
     * Inductance, turns, magnetic flux per turn and current; exactly one of them is left empty.
     *
     * @return non-empty-list<InputField>
     */
    public function inputs(): array
    {
        return [
            InputField::quantity(self::INDUCTANCE, FixedUnit::of(BaseUnit::Henry))->optional(),
            InputField::number(self::TURNS)->optional(),
            InputField::quantity(self::MAGNETIC_FLUX, FixedUnit::of(BaseUnit::Weber))->optional(),
            InputField::quantity(self::CURRENT, FixedUnit::of(BaseUnit::Ampere))->optional(),
        ];
    }

    /**
     * The four values, the one left empty calculated from the other three.
     *
     * @throws InvalidInput
     * @throws DivisionByZero
     */
    public function calculate(Inputs $inputs): Result
    {
        [$unknown] = $inputs->missing([self::INDUCTANCE, self::TURNS, self::MAGNETIC_FLUX, self::CURRENT], 1);

        if ($unknown === self::TURNS) {
            return $this->solveForTurns($inputs);
        }

        $turns = $this->turns($inputs);

        [$inductance, $flux, $current] = match ($unknown) {
            self::INDUCTANCE => $this->solveForInductance($inputs, $turns),
            self::MAGNETIC_FLUX => $this->solveForFlux($inputs, $turns),
            default => $this->solveForCurrent($inputs, $turns),
        };

        return $this->result($inductance, $turns->value(), $flux, $current);
    }

    /**
     * L = N × Φ / I.
     *
     * @return array{Inductance, MagneticFlux, Current}
     *
     * @throws InvalidInput
     * @throws DivisionByZero
     */
    private function solveForInductance(Inputs $inputs, TurnCount $turns): array
    {
        $flux = $inputs->positiveQuantity(self::MAGNETIC_FLUX, MagneticFlux::class);
        $current = $inputs->positiveQuantity(self::CURRENT, Current::class);

        return [$flux->multipliedBy($turns->value())->dividedByCurrent($current), $flux, $current];
    }

    /**
     * Φ = L × I / N.
     *
     * @return array{Inductance, MagneticFlux, Current}
     *
     * @throws InvalidInput
     * @throws DivisionByZero
     */
    private function solveForFlux(Inputs $inputs, TurnCount $turns): array
    {
        $inductance = $inputs->positiveQuantity(self::INDUCTANCE, Inductance::class);
        $current = $inputs->positiveQuantity(self::CURRENT, Current::class);

        return [$inductance, $inductance->timesCurrent($current)->dividedBy($turns->value()), $current];
    }

    /**
     * I = N × Φ / L.
     *
     * @return array{Inductance, MagneticFlux, Current}
     *
     * @throws InvalidInput
     * @throws DivisionByZero
     */
    private function solveForCurrent(Inputs $inputs, TurnCount $turns): array
    {
        $inductance = $inputs->positiveQuantity(self::INDUCTANCE, Inductance::class);
        $flux = $inputs->positiveQuantity(self::MAGNETIC_FLUX, MagneticFlux::class);

        return [$inductance, $flux, $flux->multipliedBy($turns->value())->dividedByInductance($inductance)];
    }

    /**
     * N = L × I / Φ, rounded up to a whole turn; the exact quotient is the intermediate value.
     *
     * @throws InvalidInput
     * @throws DivisionByZero
     */
    private function solveForTurns(Inputs $inputs): Result
    {
        $inductance = $inputs->positiveQuantity(self::INDUCTANCE, Inductance::class);
        $flux = $inputs->positiveQuantity(self::MAGNETIC_FLUX, MagneticFlux::class);
        $current = $inputs->positiveQuantity(self::CURRENT, Current::class);

        $exactTurns = $inductance->timesCurrent($current)->ratioTo($flux);
        $wholeTurns = $exactTurns->toScale(0, RoundingMode::Ceiling);

        $result = $this->result($inductance, $wholeTurns, $flux, $current);

        return new Result($result->values, [ResultValue::number('exact_turns', $exactTurns)]);
    }

    /**
     * The number of turns given.
     *
     * @throws InvalidInput
     */
    private function turns(Inputs $inputs): TurnCount
    {
        return TurnCount::tryOf($inputs->wholeNumber(self::TURNS, 1))
            ?? throw InvalidInput::of(self::TURNS, InputProblem::NotPositive);
    }

    /**
     * The four values, in the order of the inputs.
     */
    private function result(Inductance $inductance, BigNumber|int $turns, MagneticFlux $flux, Current $current): Result
    {
        return new Result([
            ResultValue::quantity(self::INDUCTANCE, $inductance, FixedUnit::of(BaseUnit::Henry)),
            ResultValue::number(self::TURNS, $turns),
            ResultValue::quantity(self::MAGNETIC_FLUX, $flux, FixedUnit::of(BaseUnit::Weber)),
            ResultValue::quantity(self::CURRENT, $current, FixedUnit::of(BaseUnit::Ampere)),
        ]);
    }
}
