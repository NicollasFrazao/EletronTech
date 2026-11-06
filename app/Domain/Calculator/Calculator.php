<?php

declare(strict_types=1);

namespace App\Domain\Calculator;

use App\Domain\Quantity\QuantityError;

/**
 * A calculation tool: it declares the inputs it reads and turns them into a result with the intermediate values
 * a person would write down on the way.
 *
 * Every tool implements this contract, so any of them can be listed, described and run the same way (Strategy);
 * the CalculatorCatalog finds one by its identifier.
 */
interface Calculator
{
    /**
     * The tool's stable identifier, for URLs and forms: "electrical-capacitance", "outlet-count".
     */
    public function id(): string;

    /**
     * The inputs the tool reads, in the order a form shows them.
     *
     * @return non-empty-list<InputField>
     */
    public function inputs(): array;

    /**
     * Calculates the result from the inputs, each already read into its quantity, number or option.
     *
     * @throws InvalidInput When a value is missing, out of the tool's range, or not one of the options.
     * @throws QuantityError When the inputs lead to an impossible operation, such as a division by zero.
     */
    public function calculate(Inputs $inputs): Result;
}
