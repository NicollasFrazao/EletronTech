<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Mathematics;

use App\Domain\Calculator\Calculator;
use App\Domain\Calculator\InputField;
use App\Domain\Calculator\Inputs;
use App\Domain\Calculator\InvalidInput;
use App\Domain\Calculator\Result;
use App\Domain\Calculator\ResultValue;

/**
 * The basic calculator: the value of an arithmetic expression typed as text, such as "(2 + 3) × 4" or
 * "{[1,5 + 2] / 7}", computed exactly by Expression (never eval).
 */
final readonly class BasicCalculator implements Calculator
{
    private const string EXPRESSION = 'expression';

    /**
     * The tool's identifier.
     */
    public function id(): string
    {
        return 'basic-calculator';
    }

    /**
     * The expression.
     *
     * @return non-empty-list<InputField>
     */
    public function inputs(): array
    {
        return [InputField::text(self::EXPRESSION)];
    }

    /**
     * The value of the expression, exact until it is shown.
     *
     * @throws InvalidInput When the expression is missing, is not arithmetic, divides by zero or is too long.
     */
    public function calculate(Inputs $inputs): Result
    {
        try {
            $value = Expression::evaluate($inputs->text(self::EXPRESSION));
        } catch (InvalidExpression $exception) {
            throw InvalidInput::of(self::EXPRESSION, $exception->problem);
        }

        return new Result([ResultValue::number('result', $value)]);
    }
}
