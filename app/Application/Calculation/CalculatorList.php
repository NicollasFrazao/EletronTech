<?php

declare(strict_types=1);

namespace App\Application\Calculation;

/**
 * The calculators the application offers, each with its input schema.
 */
final readonly class CalculatorList
{
    /**
     * @param  list<CalculatorDescription>  $calculators  In catalogue order.
     */
    public function __construct(
        public array $calculators,
    ) {}
}
