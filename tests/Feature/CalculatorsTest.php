<?php

declare(strict_types=1);

use App\Domain\Calculator\Calculator;
use App\Domain\Calculator\CalculatorCatalog;

it('registers every electrical calculator of the 2015 version', function (): void {
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
    ]);
});

it('lists the calculators with their input schemas', function (): void {
    $this->getJson('/tools/calculators')
        ->assertOk()
        ->assertJsonCount(12, 'calculators')
        ->assertJsonPath('calculators.7.id', 'outlet-count')
        ->assertJsonPath('calculators.7.inputs.0.name', 'room_type')
        ->assertJsonPath('calculators.7.inputs.0.accepts.options.0', 'service_area')
        ->assertJsonPath('calculators.7.inputs.1.accepts.defaultUnit.id', 'metre');
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
]);

it('answers 404 for a calculator that does not exist', function (): void {
    $this->postJson('/tools/calculators/time-machine', [])->assertNotFound();
});
