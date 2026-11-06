<?php

declare(strict_types=1);

namespace App\Domain\Calculator;

/**
 * One input of a calculation was refused, with the reason.
 */
final class InvalidInput extends CalculatorError
{
    /**
     * Names the whole set of inputs rather than one of them, when the problem is the combination.
     */
    public const string ALL_INPUTS = 'inputs';

    /**
     * @param  string  $field  The input's name, or ALL_INPUTS.
     */
    private function __construct(
        public readonly string $field,
        public readonly InputProblem $problem,
    ) {
        parent::__construct("Input \"{$field}\": {$problem->describe()}.");
    }

    /**
     * The error for one input and one reason.
     */
    public static function of(string $field, InputProblem $problem): self
    {
        return new self($field, $problem);
    }
}
