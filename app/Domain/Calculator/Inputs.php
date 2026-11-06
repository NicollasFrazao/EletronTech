<?php

declare(strict_types=1);

namespace App\Domain\Calculator;

use App\Domain\Quantity\Quantity;
use BackedEnum;
use Brick\Math\BigRational;

/**
 * The values given to a calculator, each already read into a quantity, an exact number or an option identifier,
 * with typed access that refuses a missing value or one of the wrong kind.
 */
final readonly class Inputs
{
    /**
     * @param  array<string, Quantity|BigRational|string>  $values  Keyed by input name; an input left empty is absent.
     */
    public function __construct(
        private array $values,
    ) {}

    /**
     * Whether the input was given.
     */
    public function has(string $name): bool
    {
        return isset($this->values[$name]);
    }

    /**
     * The quantity given for an input, of the expected kind.
     *
     * @template T of Quantity
     *
     * @param  class-string<T>  $kind
     *
     * @return T
     *
     * @throws InvalidInput
     */
    public function quantity(string $name, string $kind): Quantity
    {
        $value = $this->values[$name] ?? throw InvalidInput::of($name, InputProblem::Missing);

        if (! $value instanceof $kind) {
            throw InvalidInput::of($name, InputProblem::WrongKind);
        }

        return $value;
    }

    /**
     * The quantity given for an input, refused unless it is greater than zero.
     *
     * @template T of Quantity
     *
     * @param  class-string<T>  $kind
     *
     * @return T
     *
     * @throws InvalidInput
     */
    public function positiveQuantity(string $name, string $kind): Quantity
    {
        $value = $this->quantity($name, $kind);

        if ($value->isNegative() || $value->isZero()) {
            throw InvalidInput::of($name, InputProblem::NotPositive);
        }

        return $value;
    }

    /**
     * The quantity given for an input, refused when it is below zero.
     *
     * @template T of Quantity
     *
     * @param  class-string<T>  $kind
     *
     * @return T
     *
     * @throws InvalidInput
     */
    public function nonNegativeQuantity(string $name, string $kind): Quantity
    {
        $value = $this->quantity($name, $kind);

        if ($value->isNegative()) {
            throw InvalidInput::of($name, InputProblem::Negative);
        }

        return $value;
    }

    /**
     * The pure number given for an input.
     *
     * @throws InvalidInput
     */
    public function number(string $name): BigRational
    {
        $value = $this->values[$name] ?? throw InvalidInput::of($name, InputProblem::Missing);

        if (! $value instanceof BigRational) {
            throw InvalidInput::of($name, InputProblem::WrongKind);
        }

        return $value;
    }

    /**
     * The whole number given for an input, refused when it is a fraction, too large for an integer, or below its
     * minimum: at least one for a count that cannot be none (turns, days), at least zero for one that can (people
     * in a room).
     *
     * @param  0|1  $atLeast
     *
     * @throws InvalidInput
     */
    public function wholeNumber(string $name, int $atLeast): int
    {
        $value = $this->number($name);

        if (! $value->getDenominator()->isEqualTo(1)) {
            throw InvalidInput::of($name, InputProblem::NotWhole);
        }

        if ($value->isLessThan($atLeast)) {
            throw InvalidInput::of($name, $atLeast === 1 ? InputProblem::NotPositive : InputProblem::Negative);
        }

        if (! $value->getNumerator()->isLessThanOrEqualTo(PHP_INT_MAX)) {
            throw InvalidInput::of($name, InputProblem::TooLarge);
        }

        return $value->getNumerator()->toInt();
    }

    /**
     * The text given for an input, as typed.
     *
     * @throws InvalidInput
     */
    public function text(string $name): string
    {
        $value = $this->values[$name] ?? throw InvalidInput::of($name, InputProblem::Missing);

        if (! is_string($value)) {
            throw InvalidInput::of($name, InputProblem::WrongKind);
        }

        return $value;
    }

    /**
     * The option chosen for an input, as a case of the enum that lists the options.
     *
     * @template E of BackedEnum
     *
     * @param  class-string<E>  $options
     *
     * @return E
     *
     * @throws InvalidInput
     */
    public function choice(string $name, string $options): BackedEnum
    {
        $value = $this->values[$name] ?? throw InvalidInput::of($name, InputProblem::Missing);

        if (! is_string($value)) {
            throw InvalidInput::of($name, InputProblem::WrongKind);
        }

        return $options::tryFrom($value) ?? throw InvalidInput::of($name, InputProblem::UnknownOption);
    }

    /**
     * The inputs among these names that were left empty, refused unless exactly that many were: a calculator
     * that solves for whichever value is missing asks for this.
     *
     * @param  non-empty-list<string>  $names
     * @param  positive-int  $count
     *
     * @return non-empty-list<string>
     *
     * @throws InvalidInput
     */
    public function missing(array $names, int $count): array
    {
        $missing = array_values(array_filter($names, fn (string $name): bool => ! $this->has($name)));

        if ($missing === [] || count($missing) !== $count) {
            throw InvalidInput::of(InvalidInput::ALL_INPUTS, InputProblem::WrongNumberOfValues);
        }

        return $missing;
    }

    /**
     * Refuses an input that should have been left empty because another one already says the same.
     *
     * @throws InvalidInput
     */
    public function assertAbsent(string $name, InputProblem $problem): void
    {
        if ($this->has($name)) {
            throw InvalidInput::of($name, $problem);
        }
    }
}
