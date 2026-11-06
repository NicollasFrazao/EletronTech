<?php

declare(strict_types=1);

use App\Application\Calculation\Calculate;
use App\Application\Calculation\CalculationInput;
use App\Application\Calculation\ListCalculators;
use App\Application\Calculation\ResultLine;
use App\Application\UnitConversion\UnitOption;
use App\Domain\Calculator\CalculatorCatalog;
use App\Domain\Calculator\Electrical\ElectricalCapacitance;
use App\Domain\Calculator\Electrical\ElectricalConductance;
use App\Domain\Calculator\Electrical\OutletCount;
use App\Domain\Calculator\Electrical\ResistorColourCode;
use App\Domain\Calculator\InputProblem;
use App\Domain\Calculator\Mathematics\BasicCalculator;
use App\Domain\Calculator\UnknownCalculator;
use App\Domain\Quantity\UnitCatalogue;

/**
 * The use case over a small catalogue.
 */
function calculate(CalculationInput $input): array
{
    $catalog = new CalculatorCatalog(
        new ElectricalCapacitance,
        new ElectricalConductance,
        new OutletCount,
        new ResistorColourCode,
        new BasicCalculator,
    );
    $result = new Calculate($catalog, new UnitCatalogue)->handle($input);

    $lines = [];

    foreach ([...$result->values, ...$result->intermediates] as $line) {
        /** @var ResultLine $line */
        $lines[$line->name] = [$line->value, $line->unit?->symbol, $line->isExact];
    }

    return $lines;
}

it('reads the typed values in the units given and rounds the result for display', function (): void {
    $lines = calculate(new CalculationInput(
        'electrical-capacitance',
        ['charge' => '10', 'power' => '0.12', 'current' => '10'],
        ['charge' => 'millicoulomb', 'power' => 'kilowatt'],
    ));

    expect($lines)->toBe([
        'capacitance' => ['0.000833333333333', 'F', false],
        'voltage' => ['12', 'V', true],
    ]);
});

it('passes numbers, options and texts through', function (): void {
    expect(calculate(new CalculationInput('outlet-count', ['room_type' => 'kitchen', 'length' => '3', 'width' => '3.5'])))
        ->toMatchArray(['outlets' => ['4', null, true], 'total_load' => ['1900', 'VA', true]])
        ->and(calculate(new CalculationInput(
            'resistor-colour-code',
            ['resistance' => '4.7', 'tolerance_band' => 'gold'],
            ['resistance' => 'kiloohm'],
        )))
        ->toMatchArray(['first_band' => ['yellow', null, true], 'multiplier_band' => ['red', null, true]]);
});

it('treats an empty value as left empty', function (): void {
    expect(calculate(new CalculationInput('electrical-conductance', ['conductance' => ' ', 'voltage' => '10', 'current' => '2'])))
        ->toMatchArray(['conductance' => ['0.2', 'S', true]]);
});

it('reports a value it cannot read on its field', function (array $values, array $units, string $field, InputProblem $problem): void {
    expectInvalid(fn (): array => calculate(new CalculationInput('electrical-capacitance', $values, $units)), $field, $problem);
})->with([
    'not a number' => [['charge' => 'ten', 'power' => '1', 'current' => '1'], [], 'charge', InputProblem::NotANumber],
    'unknown unit' => [['charge' => '1', 'power' => '1', 'current' => '1'], ['power' => 'parsec'], 'power', InputProblem::UnknownUnit],
    'unit of another quantity' => [
        ['charge' => '1', 'power' => '1', 'current' => '1'], ['current' => 'volt'], 'current', InputProblem::WrongUnit,
    ],
    'missing' => [['charge' => '1', 'power' => '1'], [], 'current', InputProblem::Missing],
]);

it('refuses an unknown calculator', function (): void {
    calculate(new CalculationInput('warp-drive', []));
})->throws(UnknownCalculator::class);

it('lists every calculator with what each input accepts', function (): void {
    $list = new ListCalculators(new CalculatorCatalog(new OutletCount), new UnitCatalogue)->handle();
    [$roomType, $length] = $list->calculators[0]->inputs;

    expect($list->calculators[0]->id)->toBe('outlet-count')
        ->and([$roomType->name, $roomType->kind, $roomType->isRequired, $roomType->accepts->defaultUnit])
        ->toBe(['room_type', 'choice', true, null])
        ->and($roomType->accepts->options)->toContain('kitchen', 'living_room')
        ->and([$length->kind, $length->accepts->defaultUnit?->id])->toBe(['quantity', 'metre'])
        ->and(array_map(static fn (UnitOption $unit): string => $unit->id, $length->accepts->units))->toContain('foot', 'kilometre');
});

it('hands a text to the calculator as typed and rounds the number it answers', function (): void {
    expect(calculate(new CalculationInput('basic-calculator', ['expression' => ' 2 / 3 '])))
        ->toBe(['result' => ['0.666666666667', null, false]]);
});

it('describes a text input without units or options', function (): void {
    $list = new ListCalculators(new CalculatorCatalog(new BasicCalculator), new UnitCatalogue)->handle();
    [$expression] = $list->calculators[0]->inputs;

    expect([$expression->name, $expression->kind, $expression->accepts->defaultUnit, $expression->accepts->units])
        ->toBe(['expression', 'text', null, []]);
});
