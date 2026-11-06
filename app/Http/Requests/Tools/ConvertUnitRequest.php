<?php

declare(strict_types=1);

namespace App\Http\Requests\Tools;

use App\Application\UnitConversion\ConversionInput;
use Illuminate\Foundation\Http\FormRequest;

/**
 * The unit converter form: a value and the units to convert from and to.
 */
final class ConvertUnitRequest extends FormRequest
{
    private const int MAX_VALUE_LENGTH = 64;

    /**
     * The shape of the input; whether the value is a number and the units exist is the use case's answer.
     *
     * @return array<string, list<string>>
     */
    public function rules(): array
    {
        return [
            'value' => ['required', 'string', 'max:'.self::MAX_VALUE_LENGTH],
            'from' => ['required', 'string'],
            'to' => ['required', 'string'],
        ];
    }

    /**
     * The input for the use case.
     */
    public function toInput(): ConversionInput
    {
        return new ConversionInput(
            $this->string('value')->toString(),
            $this->string('from')->toString(),
            $this->string('to')->toString(),
        );
    }

    /**
     * Accepts a decimal comma, as people type numbers in Brazil: "1,5" is read as 1.5.
     */
    protected function prepareForValidation(): void
    {
        $value = $this->input('value');

        if (is_string($value)) {
            $this->merge(['value' => str_replace(',', '.', $value)]);
        }
    }
}
