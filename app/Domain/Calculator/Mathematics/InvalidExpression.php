<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Mathematics;

use App\Domain\Calculator\CalculatorError;
use App\Domain\Calculator\InputProblem;

/**
 * An arithmetic expression could not be evaluated, with the reason.
 */
final class InvalidExpression extends CalculatorError
{
    private function __construct(
        public readonly InputProblem $problem,
    ) {
        parent::__construct("The expression cannot be evaluated: {$problem->describe()}.");
    }

    /**
     * The error for one reason: not an expression, a division by zero or a text too long.
     */
    public static function because(InputProblem $problem): self
    {
        return new self($problem);
    }
}
