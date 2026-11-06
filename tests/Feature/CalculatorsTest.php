<?php

declare(strict_types=1);

use App\Domain\Calculator\Calculator;
use App\Domain\Calculator\CalculatorCatalog;

it('registers every calculator of the 2015 version, electrical and general', function (): void {
    $ids = array_map(static fn (Calculator $calculator): string => $calculator->id(), app(CalculatorCatalog::class)->all());

    expect($ids)->toBe([
        'electrical-capacitance',
        'electrical-conductance',
        'electrical-impedance',
        'electrical-inductance',
        'general-power',
        'lighting-power',
        'general-lighting',
        'outlet-count',
        'breaker-and-wiring',
        'motor-efficiency',
        'electrical-consumption',
        'resistor-colour-code',
        'ohms-law',
        'conductor-resistance',
        'series-parallel-resistance',
        'area-and-perimeter',
        'surface-area-and-volume',
        'basic-calculator',
        'binary-converter',
        'rule-of-three',
        'bernoulli-equation',
        'btu-sizing',
        'floor-and-wall-tiles',
        'block-count',
    ]);
});

it('lists the calculators with their input schemas', function (): void {
    $this->getJson('/tools/calculators')
        ->assertOk()
        ->assertJsonCount(24, 'calculators')
        ->assertJsonPath('calculators.7.id', 'outlet-count')
        ->assertJsonPath('calculators.7.inputs.0.name', 'room_type')
        ->assertJsonPath('calculators.7.inputs.0.accepts.options.0', 'service_area')
        ->assertJsonPath('calculators.7.inputs.1.accepts.defaultUnit.id', 'metre')
        ->assertJsonPath('calculators.17.id', 'basic-calculator')
        ->assertJsonPath('calculators.17.inputs.0.kind', 'text');
});

it('evaluates an expression typed with a decimal comma', function (): void {
    $this->postJson('/tools/calculators/basic-calculator', ['expression' => '{[1,5 + 2] × 3} ÷ 2'])
        ->assertOk()
        ->assertJsonPath('values.0', ['name' => 'result', 'value' => '5.25', 'unit' => null, 'isExact' => true]);
});

it('solves a rule of three from numbers typed with a decimal comma', function (): void {
    $this->postJson('/tools/calculators/rule-of-three', ['proportion' => 'direct', 'first' => '2', 'second' => '7,5', 'third' => 3])
        ->assertOk()
        ->assertJsonPath('values.3', ['name' => 'fourth', 'value' => '11.25', 'unit' => null, 'isExact' => true]);
});

it('converts a number between bases and a general calculator reads units', function (): void {
    $this->postJson('/tools/calculators/binary-converter', ['value' => 'FF', 'base' => 'hexadecimal'])
        ->assertOk()
        ->assertJsonPath('values.0.value', '11111111');

    $this->postJson('/tools/calculators/floor-and-wall-tiles', [
        'surface_length' => '400',
        'surface_width' => '3',
        'tile_length' => '0,6',
        'tile_width' => '60',
        'units' => ['surface_length' => 'centimetre', 'tile_length' => 'metre'],
    ])
        ->assertOk()
        ->assertJsonPath('values.1', ['name' => 'tiles', 'value' => '37', 'unit' => null, 'isExact' => true]);
});

it('runs a calculator and answers its values and intermediate steps', function (): void {
    $this->postJson('/tools/calculators/breaker-and-wiring', [
        'supply_system' => 'single_phase',
        'circuit_purpose' => 'power',
        'apparent_power' => '5,5',
        'voltage' => 220,
        'units' => ['apparent_power' => 'kilovolt_ampere'],
    ])
        ->assertOk()
        ->assertJsonPath('calculator', 'breaker-and-wiring')
        ->assertJsonPath('values.1', [
            'name' => 'breaker_rating',
            'value' => '25',
            'unit' => ['id' => 'ampere', 'name' => 'ampere', 'symbol' => 'A'],
            'isExact' => true,
        ])
        ->assertJsonPath('values.2.value', '4')
        ->assertJsonPath('values.2.unit.symbol', 'mm²')
        ->assertJsonPath('intermediates.0', ['name' => 'loaded_conductors', 'value' => '2', 'unit' => null, 'isExact' => true]);
});

it('reports each refused value on its field', function (string $calculator, array $input, string $field, string $message): void {
    $this->postJson("/tools/calculators/{$calculator}", $input)
        ->assertUnprocessable()
        ->assertJsonValidationErrors([$field => $message]);
})->with([
    'missing' => ['lighting-power', ['length' => '3'], 'width', 'Fill in this value.'],
    'not a number' => ['lighting-power', ['length' => '3', 'width' => 'wide'], 'width', 'Type a number'],
    'not positive' => ['lighting-power', ['length' => '3', 'width' => '-2'], 'width', 'greater than zero'],
    'unit of another quantity' => [
        'lighting-power', ['length' => '3', 'width' => '2', 'units' => ['width' => 'volt']], 'width', 'same quantity',
    ],
    'unknown option' => [
        'outlet-count', ['room_type' => 'ballroom', 'length' => '3', 'width' => '2'], 'room_type', 'Choose one of the options.',
    ],
    'wrong number of values' => ['electrical-conductance', ['voltage' => '10'], 'inputs', 'leave the ones to calculate empty'],
    'not an expression' => ['basic-calculator', ['expression' => '2 +'], 'expression', 'Type an expression'],
    'division by zero' => ['basic-calculator', ['expression' => '1/0'], 'expression', 'divides by zero'],
    'no solution' => [
        'series-parallel-resistance',
        ['connection' => 'series', 'first_resistance' => '100', 'equivalent_resistance' => '50'],
        'inputs',
        'No value satisfies the calculation',
    ],
    'too long' => ['basic-calculator', ['expression' => str_repeat('1+', 128).'1'], 'expression', 'must not be greater than 255'],
    'not a text' => ['basic-calculator', ['expression' => ['1']], 'expression', 'must be a string'],
]);

it('answers 404 for a calculator that does not exist', function (): void {
    $this->postJson('/tools/calculators/time-machine', [])->assertNotFound();
});
