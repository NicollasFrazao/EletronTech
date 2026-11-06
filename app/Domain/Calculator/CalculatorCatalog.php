<?php

declare(strict_types=1);

namespace App\Domain\Calculator;

use InvalidArgumentException;

/**
 * Every calculator the application offers, found by its identifier.
 */
final readonly class CalculatorCatalog
{
    /**
     * @var array<string, Calculator> Keyed by calculator identifier, in the order they were registered.
     */
    private array $calculators;

    public function __construct(Calculator ...$calculators)
    {
        $byId = [];

        foreach ($calculators as $calculator) {
            if (isset($byId[$calculator->id()])) {
                throw new InvalidArgumentException("Two calculators share the identifier \"{$calculator->id()}\".");
            }

            $byId[$calculator->id()] = $calculator;
        }

        $this->calculators = $byId;
    }

    /**
     * The calculator with this identifier.
     *
     * @throws UnknownCalculator
     */
    public function find(string $id): Calculator
    {
        return $this->calculators[$id] ?? throw UnknownCalculator::withId($id);
    }

    /**
     * Every calculator, in the order they were registered.
     *
     * @return list<Calculator>
     */
    public function all(): array
    {
        return array_values($this->calculators);
    }
}
