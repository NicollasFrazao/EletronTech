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
use App\Domain\Quantity\Resistance;

/**
 * The equivalent resistance of two resistors in series (R = R₁ + R₂) or in parallel (1/R = 1/R₁ + 1/R₂), or the
 * resistor that, with a known one, makes up a wanted equivalent resistance.
 *
 * A resistor in series only adds resistance and one in parallel only takes it away, so the wanted resistance must
 * be above the known resistor in series and below it in parallel; otherwise no resistor makes it up.
 */
final readonly class SeriesParallelResistance implements Calculator
{
    private const string CONNECTION = 'connection';

    private const string FIRST = 'first_resistance';

    private const string SECOND = 'second_resistance';

    private const string EQUIVALENT = 'equivalent_resistance';

    /**
     * The tool's identifier.
     */
    public function id(): string
    {
        return 'series-parallel-resistance';
    }

    /**
     * The connection and the three resistances; exactly one resistance is left empty.
     *
     * @return non-empty-list<InputField>
     */
    public function inputs(): array
    {
        $ohm = FixedUnit::of(BaseUnit::Ohm);

        return [
            InputField::choice(self::CONNECTION, ResistorConnection::cases()),
            InputField::quantity(self::FIRST, $ohm)->optional(),
            InputField::quantity(self::SECOND, $ohm)->optional(),
            InputField::quantity(self::EQUIVALENT, $ohm)->optional(),
        ];
    }

    /**
     * The three resistances, the one left empty calculated from the other two.
     *
     * @throws InvalidInput When not exactly one resistance is empty, one is not greater than zero, or no resistor
     *                      makes up the equivalent resistance.
     * @throws DivisionByZero
     */
    public function calculate(Inputs $inputs): Result
    {
        $connection = $inputs->choice(self::CONNECTION, ResistorConnection::class);
        [$unknown] = $inputs->missing([self::FIRST, self::SECOND, self::EQUIVALENT], 1);

        if ($unknown === self::EQUIVALENT) {
            $first = $inputs->positiveQuantity(self::FIRST, Resistance::class);
            $second = $inputs->positiveQuantity(self::SECOND, Resistance::class);
            $equivalent = $this->combined($connection, $first, $second);
        } else {
            $known = $unknown === self::FIRST ? self::SECOND : self::FIRST;
            $other = $inputs->positiveQuantity($known, Resistance::class);
            $equivalent = $inputs->positiveQuantity(self::EQUIVALENT, Resistance::class);
            $missing = $this->complement($connection, $equivalent, $other);
            [$first, $second] = $unknown === self::FIRST ? [$missing, $other] : [$other, $missing];
        }

        $ohm = FixedUnit::of(BaseUnit::Ohm);

        return new Result([
            ResultValue::quantity(self::FIRST, $first, $ohm),
            ResultValue::quantity(self::SECOND, $second, $ohm),
            ResultValue::quantity(self::EQUIVALENT, $equivalent, $ohm),
        ]);
    }

    /**
     * The equivalent resistance of two resistors.
     *
     * @throws DivisionByZero
     */
    private function combined(ResistorConnection $connection, Resistance $first, Resistance $second): Resistance
    {
        if ($connection === ResistorConnection::Series) {
            return $first->plus($second);
        }

        return $first->reciprocal()->plus($second->reciprocal())->reciprocal();
    }

    /**
     * The resistor that, connected with a known one, makes up the equivalent resistance: R₁ = R − R₂ in series,
     * 1/R₁ = 1/R − 1/R₂ in parallel.
     *
     * @throws InvalidInput When the equivalent resistance is not above the known one in series, or below it in
     *                      parallel.
     * @throws DivisionByZero
     */
    private function complement(ResistorConnection $connection, Resistance $equivalent, Resistance $known): Resistance
    {
        $isReachable = $connection === ResistorConnection::Series
            ? $equivalent->isGreaterThan($known)
            : $equivalent->isLessThan($known);

        if (! $isReachable) {
            throw InvalidInput::of(InvalidInput::ALL_INPUTS, InputProblem::NoSolution);
        }

        if ($connection === ResistorConnection::Series) {
            return $equivalent->minus($known);
        }

        return $equivalent->reciprocal()->minus($known->reciprocal())->reciprocal();
    }
}
