<?php

declare(strict_types=1);

use App\Domain\Calculator\Electrical\ElectricalConductance;
use App\Domain\Calculator\InputProblem;
use App\Domain\Calculator\Inputs;
use App\Domain\Calculator\InvalidInput;
use App\Domain\Calculator\Result;
use App\Domain\Quantity\Conductance;
use App\Domain\Quantity\Current;
use App\Domain\Quantity\Voltage;
use Tests\Support\Results;

// G = I / V: conductance is the reciprocal of resistance (Ohm's law). 2 A at 10 V is 0.2 S.

it('solves for whichever value is left empty', function (array $given, string $unknown, string $expected): void {
    $result = (new ElectricalConductance)->calculate(new Inputs($given));

    expect(Results::exact($result, $unknown))->toBe($expected)
        ->and(Results::names($result))->toBe(['conductance', 'voltage', 'current']);
})->with([
    'conductance' => [['voltage' => Voltage::fromVolts(10), 'current' => Current::fromAmperes(2)], 'conductance', '1/5'],
    'voltage' => [['conductance' => Conductance::fromSiemens('0.2'), 'current' => Current::fromAmperes(2)], 'voltage', '10'],
    'current' => [['conductance' => Conductance::fromSiemens('0.2'), 'voltage' => Voltage::fromVolts(10)], 'current', '2'],
]);

it('needs exactly one value left empty', function (array $given): void {
    expectInvalid(fn (): Result => (new ElectricalConductance)->calculate(new Inputs($given)), 'inputs', InputProblem::WrongNumberOfValues);
})->with([
    'all three' => [[
        'conductance' => Conductance::fromSiemens(1),
        'voltage' => Voltage::fromVolts(1),
        'current' => Current::fromAmperes(1),
    ]],
    'only one' => [['voltage' => Voltage::fromVolts(1)]],
]);

it('refuses a zero voltage', function (): void {
    (new ElectricalConductance)->calculate(new Inputs(['voltage' => Voltage::zero(), 'current' => Current::fromAmperes(1)]));
})->throws(InvalidInput::class, 'Input "voltage": the value must be greater than zero.');
