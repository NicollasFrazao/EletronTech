<?php

declare(strict_types=1);

use App\Domain\Calculator\Electrical\GeneralPower;
use App\Domain\Calculator\Inputs;
use App\Domain\Calculator\InvalidInput;
use App\Domain\Quantity\Current;
use App\Domain\Quantity\Voltage;
use Brick\Math\BigRational;
use Tests\Support\Results;

// The power triangle: S = V × I (single and two phase, V across the load), S = √3 × V × I (three phase, V between
// phases), P = S × cos φ, Q = S × sin φ (Cotrim, Instalações Elétricas, chapter 1).

it('splits a single-phase load into active, reactive and apparent power', function (): void {
    $result = (new GeneralPower)->calculate(new Inputs([
        'supply_system' => 'single_phase',
        'voltage' => Voltage::fromVolts(127),
        'current' => Current::fromAmperes(10),
        'power_factor' => BigRational::of('0.8'),
    ]));

    expect(Results::exact($result, 'apparent_power'))->toBe('1270')
        ->and(Results::exact($result, 'active_power'))->toBe('1016')
        ->and(Results::exact($result, 'reactive_power'))->toBe('762')
        ->and(Results::exact($result, 'line_factor'))->toBe('1')
        ->and(Results::unit($result, 'reactive_power'))->toBe('var');
});

it('uses the voltage between the phases of a two-phase load as a single-phase one', function (): void {
    $result = (new GeneralPower)->calculate(new Inputs([
        'supply_system' => 'two_phase',
        'voltage' => Voltage::fromVolts(220),
        'current' => Current::fromAmperes(20),
        'power_factor' => BigRational::of('0.92'),
    ]));

    expect(Results::exact($result, 'apparent_power'))->toBe('4400')
        ->and(Results::exact($result, 'active_power'))->toBe('4048')
        ->and(Results::shown($result, 'reactive_power'))->toBe('1724.44077892');
});

it('multiplies a three-phase load by the square root of three', function (): void {
    $result = (new GeneralPower)->calculate(new Inputs([
        'supply_system' => 'three_phase',
        'voltage' => Voltage::fromVolts(380),
        'current' => Current::fromAmperes(10),
        'power_factor' => BigRational::of('0.8'),
    ]));

    expect(Results::shown($result, 'line_factor'))->toBe('1.73205080757')
        ->and(Results::shown($result, 'apparent_power'))->toBe('6581.79306876')
        ->and(Results::shown($result, 'active_power'))->toBe('5265.43445501')
        ->and(Results::shown($result, 'reactive_power'))->toBe('3949.07584126');
});

it('has no reactive power at a power factor of one', function (): void {
    $result = (new GeneralPower)->calculate(new Inputs([
        'supply_system' => 'single_phase',
        'voltage' => Voltage::fromVolts(220),
        'current' => Current::fromAmperes(5),
        'power_factor' => BigRational::one(),
    ]));

    expect(Results::exact($result, 'reactive_power'))->toBe('0')
        ->and(Results::exact($result, 'active_power'))->toBe('1100');
});

it('refuses a power factor outside (0, 1]', function (string $powerFactor): void {
    (new GeneralPower)->calculate(new Inputs([
        'supply_system' => 'single_phase',
        'voltage' => Voltage::fromVolts(220),
        'current' => Current::fromAmperes(5),
        'power_factor' => BigRational::of($powerFactor),
    ]));
})->with(['0', '1.01', '80'])->throws(InvalidInput::class, 'Input "power_factor": the value is outside the range');

it('refuses a supply system that is not one of the options', function (): void {
    (new GeneralPower)->calculate(new Inputs([
        'supply_system' => 'four_phase',
        'voltage' => Voltage::fromVolts(220),
        'current' => Current::fromAmperes(5),
        'power_factor' => BigRational::one(),
    ]));
})->throws(InvalidInput::class, 'Input "supply_system": the value is not one of the options.');
