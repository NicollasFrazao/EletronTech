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
use Brick\Math\BigInteger;

/**
 * The binary converter: a whole number written in binary, octal, decimal or hexadecimal, written in all four.
 *
 * The number may have any length the form accepts; it is converted exactly, digit by digit, never through a float.
 */
final readonly class BinaryConverter implements Calculator
{
    private const string VALUE = 'value';

    private const string BASE = 'base';

    /**
     * The tool's identifier.
     */
    public function id(): string
    {
        return 'binary-converter';
    }

    /**
     * The number as typed and the base it is written in.
     *
     * @return non-empty-list<InputField>
     */
    public function inputs(): array
    {
        return [
            InputField::text(self::VALUE),
            InputField::choice(self::BASE, NumberBase::cases()),
        ];
    }

    /**
     * The number in binary, octal, decimal and hexadecimal (upper case), without leading zeros.
     *
     * @throws InvalidInput When the number has a sign or a digit its base does not have.
     */
    public function calculate(Inputs $inputs): Result
    {
        $text = $inputs->text(self::VALUE);
        $base = $inputs->choice(self::BASE, NumberBase::class);

        if (str_starts_with($text, '-')) {
            throw InvalidInput::of(self::VALUE, InputProblem::Negative);
        }

        if (! $base->isWrittenIn($text)) {
            throw InvalidInput::of(self::VALUE, InputProblem::NotANumber);
        }

        $number = BigInteger::fromBase(strtolower($text), $base->radix());

        return new Result(array_map(
            static fn (NumberBase $target): ResultValue => ResultValue::text(
                $target->value,
                strtoupper($number->toBase($target->radix())),
            ),
            NumberBase::cases(),
        ));
    }
}
