<?php

declare(strict_types=1);

namespace App\Http\Requests\Tools;

use App\Application\Calculation\CalculationInput;
use Illuminate\Foundation\Http\FormRequest;

/**
 * A calculation: one field per calculator input, plus "units" naming the unit of a quantity typed in another
 * unit than the input's default. Which fields a calculator reads is its schema's business, not this request's.
 */
final class CalculateRequest extends FormRequest
{
    private const int MAX_VALUE_LENGTH = 64;

    /**
     * The shape of the input: short scalar values and a map of unit identifiers.
     *
     * @return array<string, list<string>>
     */
    public function rules(): array
    {
        return [
            'units' => ['sometimes', 'array'],
            'units.*' => ['string', 'max:'.self::MAX_VALUE_LENGTH],
        ];
    }

    /**
     * The input for the use case, for the calculator named in the route.
     */
    public function toInput(string $calculator): CalculationInput
    {
        $values = [];
        $units = [];

        foreach ($this->except('units') as $name => $value) {
            if (is_string($value) && mb_strlen($value) <= self::MAX_VALUE_LENGTH) {
                $values[(string) $name] = $value;
            }
        }

        foreach ((array) $this->input('units', []) as $name => $unit) {
            if (is_string($unit)) {
                $units[(string) $name] = $unit;
            }
        }

        return new CalculationInput($calculator, $values, $units);
    }

    /**
     * Accepts numbers sent as JSON numbers and a decimal comma, as people type numbers in Brazil: "1,5" is 1.5.
     */
    protected function prepareForValidation(): void
    {
        $normalised = [];

        foreach ($this->except('units') as $name => $value) {
            if (is_int($value) || is_float($value)) {
                $value = (string) $value;
            }

            if (is_string($value)) {
                $normalised[$name] = str_replace(',', '.', $value);
            }
        }

        $this->merge($normalised);
    }
}
