<?php

declare(strict_types=1);

use App\Domain\Calculator\Electrical\OhmsLaw;
use App\Domain\Calculator\InputProblem;
use App\Domain\Calculator\Inputs;
use App\Domain\Calculator\Result;
use App\Domain\Quantity\Current;
use App\Domain\Quantity\Power;
use App\Domain\Quantity\Resistance;
use App\Domain\Quantity\Voltage;
use Tests\Support\Results;

// Ohm's law, V = R × I, and the power of a resistor, P = V × I = R × I² = V² / R. 12 V across 6 Ω drive 2 A and
// dissipate 24 W.

/**
 * The four values as the calculator answers them.
 *
 * @return array{string, string, string, string}
 */
function ohmsLaw(array $given): array
{
    $result = (new OhmsLaw)->calculate(new Inputs($given));

    return [
        Results::shown($result, 'voltage'),
        Results::shown($result, 'current'),
        Results::shown($result, 'resistance'),
        Results::shown($result, 'power'),
    ];
}

it('finds the other two values from any two', function (array $given): void {
    expect(ohmsLaw($given))->toBe(['12', '2', '6', '24']);
})->with([
    'voltage and current' => [['voltage' => Voltage::fromVolts(12), 'current' => Current::fromAmperes(2)]],
    'voltage and resistance' => [['voltage' => Voltage::fromVolts(12), 'resistance' => Resistance::fromOhms(6)]],
    'voltage and power' => [['voltage' => Voltage::fromVolts(12), 'power' => Power::fromWatts(24)]],
    'current and resistance' => [['current' => Current::fromAmperes(2), 'resistance' => Resistance::fromOhms(6)]],
    'current and power' => [['current' => Current::fromAmperes(2), 'power' => Power::fromWatts(24)]],
    'resistance and power' => [['resistance' => Resistance::fromOhms(6), 'power' => Power::fromWatts(24)]],
]);

it('takes the square root when only the resistance and the power are known', function (): void {
    expect(ohmsLaw(['resistance' => Resistance::fromOhms(10), 'power' => Power::fromWatts(5)]))
        ->toBe(['7.07106781187', '0.707106781187', '10', '5']);
});

it('keeps small values exact (a 4.7 kΩ resistor at 5 V)', function (): void {
    $result = (new OhmsLaw)->calculate(new Inputs(['voltage' => Voltage::fromVolts(5), 'resistance' => Resistance::fromOhms(4700)]));

    expect(Results::exact($result, 'current'))->toBe('1/940')
        ->and(Results::exact($result, 'power'))->toBe('1/188');
});

it('needs exactly two values (2015: with three it ignored one, so 10 V, 2 A and 100 Ω went unnoticed)', function (array $given): void {
    expectInvalid(fn (): Result => (new OhmsLaw)->calculate(new Inputs($given)), 'inputs', InputProblem::WrongNumberOfValues);
})->with([
    'three' => [[
        'voltage' => Voltage::fromVolts(10),
        'current' => Current::fromAmperes(2),
        'resistance' => Resistance::fromOhms(100),
    ]],
    'one' => [['voltage' => Voltage::fromVolts(10)]],
]);

it('refuses a value that is not greater than zero (2015: a zero current gave Infinity)', function (): void {
    expectInvalid(
        fn (): Result => (new OhmsLaw)->calculate(new Inputs(['voltage' => Voltage::fromVolts(10), 'current' => Current::zero()])),
        'current',
        InputProblem::NotPositive,
    );
});
