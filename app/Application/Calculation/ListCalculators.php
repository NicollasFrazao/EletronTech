<?php

declare(strict_types=1);

namespace App\Application\Calculation;

use App\Application\UnitConversion\UnitOption;
use App\Domain\Calculator\Calculator;
use App\Domain\Calculator\CalculatorCatalog;
use App\Domain\Calculator\InputField;
use App\Domain\Quantity\Unit;
use App\Domain\Quantity\UnitCatalogue;

/**
 * Lists the calculators with the schema of their inputs.
 */
final readonly class ListCalculators
{
    public function __construct(
        private CalculatorCatalog $calculators,
        private UnitCatalogue $units,
    ) {}

    /**
     * Every calculator, in catalogue order, with its inputs in the order a form shows them.
     */
    public function handle(): CalculatorList
    {
        return new CalculatorList(array_map(
            fn (Calculator $calculator): CalculatorDescription => new CalculatorDescription(
                $calculator->id(),
                array_map($this->describe(...), $calculator->inputs()),
            ),
            $this->calculators->all(),
        ));
    }

    /**
     * The description of one input.
     */
    private function describe(InputField $field): InputDescription
    {
        $default = $field->defaultUnit;
        $units = $default instanceof Unit ? $this->units->ofDimension($default->dimension()) : [];

        return new InputDescription(
            $field->name,
            $field->kind()->value,
            $field->isRequired,
            new AcceptedValues(
                $default instanceof Unit ? UnitOption::of($default) : null,
                array_map(UnitOption::of(...), $units),
                $field->options,
            ),
        );
    }
}
