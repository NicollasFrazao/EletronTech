<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Mathematics;

use App\Domain\Calculator\Calculator;
use App\Domain\Calculator\InputField;
use App\Domain\Calculator\InputProblem;
use App\Domain\Calculator\Inputs;
use App\Domain\Calculator\InvalidInput;
use App\Domain\Calculator\Result;
use App\Domain\Calculator\ResultValue;
use Brick\Math\BigRational;

/**
 * The rule of three: four values of two proportional quantities, as written by hand
 *
 *     first  ——  second
 *     third  ——  fourth
 *
 * (first and third of one quantity, second and fourth of the other), with the one left empty found from the
 * other three: directly proportional, fourth = second × third / first; inversely, fourth = first × second / third.
 */
final readonly class RuleOfThree implements Calculator
{
    private const string PROPORTION = 'proportion';

    private const array VALUES = ['first', 'second', 'third', 'fourth'];

    /**
     * The tool's identifier.
     */
    public function id(): string
    {
        return 'rule-of-three';
    }

    /**
     * The kind of proportion and the four values; exactly one value is left empty.
     *
     * @return non-empty-list<InputField>
     */
    public function inputs(): array
    {
        return [
            InputField::choice(self::PROPORTION, Proportion::cases()),
            ...array_map(static fn (string $name): InputField => InputField::number($name)->optional(), self::VALUES),
        ];
    }

    /**
     * The four values, the one left empty calculated from the other three.
     *
     * @throws InvalidInput When the proportion is missing, not exactly one value is empty, or a value is not
     *                      greater than zero.
     */
    public function calculate(Inputs $inputs): Result
    {
        $proportion = $inputs->choice(self::PROPORTION, Proportion::class);
        [$unknown] = $inputs->missing(self::VALUES, 1);

        $known = [];

        foreach (array_diff(self::VALUES, [$unknown]) as $name) {
            $known[$name] = $inputs->number($name);

            if ($known[$name]->isNegativeOrZero()) {
                throw InvalidInput::of($name, InputProblem::NotPositive);
            }
        }

        $values = [...$known, $unknown => $this->solve($proportion, $unknown, $known)];

        return new Result(array_map(
            static fn (string $name): ResultValue => ResultValue::number($name, $values[$name]),
            self::VALUES,
        ));
    }

    /**
     * The unknown value: the product of the other pair divided by the unknown's partner in its own pair.
     *
     * @param  array<string, BigRational>  $known  The three known values, by input name; all greater than zero.
     */
    private function solve(Proportion $proportion, string $unknown, array $known): BigRational
    {
        [$pair, $otherPair] = $proportion->equalProducts();

        if (! in_array($unknown, $pair, true)) {
            [$pair, $otherPair] = [$otherPair, $pair];
        }

        $partner = $pair[0] === $unknown ? $pair[1] : $pair[0];

        return $known[$otherPair[0]]->multipliedBy($known[$otherPair[1]])->dividedBy($known[$partner]);
    }
}
