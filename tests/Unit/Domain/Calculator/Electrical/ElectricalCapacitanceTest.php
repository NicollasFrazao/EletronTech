<?php

declare(strict_types=1);

use App\Domain\Calculator\Electrical\ElectricalCapacitance;
use App\Domain\Calculator\InputProblem;
use App\Domain\Calculator\Inputs;
use App\Domain\Calculator\Result;
use App\Domain\Quantity\Charge;
use App\Domain\Quantity\Current;
use App\Domain\Quantity\Power;
use Tests\Support\Results;

// C = Q / V, the definition of capacitance, with V = P / I (Halliday, Resnick and Walker, Fundamentals of Physics,
// chapter 25).

it('divides the charge by the voltage of the load', function (): void {
    $result = (new ElectricalCapacitance)->calculate(new Inputs([
        'charge' => Charge::fromCoulombs('0.01'),
        'power' => Power::fromWatts(120),
        'current' => Current::fromAmperes(10),
    ]));

    expect(Results::exact($result, 'voltage'))->toBe('12')
        ->and(Results::exact($result, 'capacitance'))->toBe('1/1200')
        ->and(Results::shown($result, 'capacitance'))->toBe('0.000833333333333')
        ->and(Results::unit($result, 'capacitance'))->toBe('F');
});

it('keeps the digits of a microfarad capacitance that the 2015 version rounded to 0.00 F', function (): void {
    $result = (new ElectricalCapacitance)->calculate(new Inputs([
        'charge' => Charge::fromCoulombs('0.0000564'),
        'power' => Power::fromWatts(24),
        'current' => Current::fromAmperes(2),
    ]));

    expect(Results::shown($result, 'capacitance'))->toBe('0.0000047');
});

it('refuses a value that is not greater than zero', function (string $field): void {
    $values = [
        'charge' => Charge::fromCoulombs(1),
        'power' => Power::fromWatts(1),
        'current' => Current::fromAmperes(1),
    ];
    $values[$field] = $values[$field]->multipliedBy(0);

    expectInvalid(fn (): Result => (new ElectricalCapacitance)->calculate(new Inputs($values)), $field, InputProblem::NotPositive);
})->with(['charge', 'power', 'current']);
