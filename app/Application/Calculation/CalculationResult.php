<?php

declare(strict_types=1);

namespace App\Application\Calculation;

/**
 * The answer of a calculator, ready to show: the values asked for and the intermediate steps.
 */
final readonly class CalculationResult
{
    /**
     * @param  list<ResultLine>  $values
     * @param  list<ResultLine>  $intermediates
     */
    public function __construct(
        public string $calculator,
        public array $values,
        public array $intermediates,
    ) {}
}
