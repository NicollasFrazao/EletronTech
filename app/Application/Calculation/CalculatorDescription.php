<?php

declare(strict_types=1);

namespace App\Application\Calculation;

/**
 * A calculator and its input schema, as a form or an API client needs them.
 */
final readonly class CalculatorDescription
{
    /**
     * @param  list<InputDescription>  $inputs
     */
    public function __construct(
        public string $id,
        public array $inputs,
    ) {}
}
