<?php

declare(strict_types=1);

namespace App\Application\Calculation;

use App\Application\UnitConversion\UnitOption;
use App\Domain\Calculator\CalculatorCatalog;
use App\Domain\Calculator\InputField;
use App\Domain\Calculator\InputKind;
use App\Domain\Calculator\InputProblem;
use App\Domain\Calculator\Inputs;
use App\Domain\Calculator\InvalidInput;
use App\Domain\Calculator\ResultValue;
use App\Domain\Calculator\UnknownCalculator;
use App\Domain\Quantity\InvalidNumber;
use App\Domain\Quantity\NumberParser;
use App\Domain\Quantity\Precision;
use App\Domain\Quantity\Quantities;
use App\Domain\Quantity\Quantity;
use App\Domain\Quantity\QuantityError;
use App\Domain\Quantity\Unit;
use App\Domain\Quantity\UnitCatalogue;
use App\Domain\Quantity\UnknownUnit;
use Brick\Math\BigRational;

/**
 * Runs any calculator: reads the typed values into quantities, numbers and options by the calculator's schema,
 * calculates, and rounds the result for display.
 */
final readonly class Calculate
{
    /**
     * The same rounding as the unit converter: enough for any reading, few enough to stay readable.
     */
    private const int SIGNIFICANT_DIGITS = 12;

    public function __construct(
        private CalculatorCatalog $calculators,
        private UnitCatalogue $units,
    ) {}

    /**
     * Calculates and returns the result ready to show.
     *
     * @throws UnknownCalculator
     * @throws InvalidInput When a value cannot be read or the calculator refuses it.
     * @throws QuantityError When the values lead to an impossible operation, such as a division by zero.
     */
    public function handle(CalculationInput $input): CalculationResult
    {
        $calculator = $this->calculators->find($input->calculator);
        $values = [];

        foreach ($calculator->inputs() as $field) {
            $typed = trim($input->values[$field->name] ?? '');

            if ($typed !== '') {
                $values[$field->name] = $this->read($field, $typed, $input->units[$field->name] ?? null);
            }
        }

        $result = $calculator->calculate(new Inputs($values));

        return new CalculationResult(
            $calculator->id(),
            array_map($this->line(...), $result->values),
            array_map($this->line(...), $result->intermediates),
        );
    }

    /**
     * The value of one input, read as its kind says.
     *
     * @throws InvalidInput
     */
    private function read(InputField $field, string $typed, ?string $unitId): Quantity|BigRational|string
    {
        if ($field->kind() === InputKind::Choice || $field->kind() === InputKind::Text) {
            return $typed;
        }

        try {
            $number = NumberParser::parse($typed);
        } catch (InvalidNumber) {
            throw InvalidInput::of($field->name, InputProblem::NotANumber);
        }

        if ($field->kind() === InputKind::Number || ! $field->defaultUnit instanceof Unit) {
            return $number;
        }

        return Quantities::of($number, $this->unit($field, $field->defaultUnit, $unitId));
    }

    /**
     * The unit a quantity was typed in: the one named, of the input's dimension, or the input's default.
     *
     * @throws InvalidInput
     */
    private function unit(InputField $field, Unit $default, ?string $unitId): Unit
    {
        if ($unitId === null || $unitId === '') {
            return $default;
        }

        try {
            $unit = $this->units->find($unitId);
        } catch (UnknownUnit) {
            throw InvalidInput::of($field->name, InputProblem::UnknownUnit);
        }

        if ($unit->dimension() !== $default->dimension()) {
            throw InvalidInput::of($field->name, InputProblem::WrongUnit);
        }

        return $unit;
    }

    /**
     * One value of the result, rounded for display.
     */
    private function line(ResultValue $value): ResultLine
    {
        if (is_string($value->value)) {
            return new ResultLine($value->name, $value->value, null, true);
        }

        $shown = Precision::significantDigits(self::SIGNIFICANT_DIGITS)->apply($value->value);

        return new ResultLine(
            $value->name,
            $shown->toString(),
            $value->unit instanceof Unit ? UnitOption::of($value->unit) : null,
            $shown->isEqualTo($value->value),
        );
    }
}
