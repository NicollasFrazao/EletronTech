<?php

declare(strict_types=1);

use App\Domain\Calculator\Electrical\ElectricalImpedance;
use App\Domain\Calculator\Inputs;
use App\Domain\Calculator\InvalidInput;
use App\Domain\Quantity\Capacitance;
use App\Domain\Quantity\Frequency;
use App\Domain\Quantity\Resistance;
use Tests\Support\Results;

// Series RC circuit: X_C = 1 / (2πfC) and Z = √(R² + X_C²) (Boylestad, Introductory Circuit Analysis, chapters 14
// and 15). 100 Ω with 10 µF at 60 Hz: X_C = 265.258238486 Ω, Z = 283.481803799 Ω.

it('combines the resistance and the capacitive reactance', function (): void {
    $result = (new ElectricalImpedance)->calculate(new Inputs([
        'resistance' => Resistance::fromOhms(100),
        'frequency' => Frequency::fromHertz(60),
        'capacitance' => Capacitance::fromFarads('0.00001'),
    ]));

    expect(Results::shown($result, 'capacitive_reactance'))->toBe('265.258238486')
        ->and(Results::shown($result, 'impedance'))->toBe('283.481803799')
        ->and(Results::unit($result, 'impedance'))->toBe('Ω');
});

it('is the reactance alone without resistance, which the 2015 version computed as 2πfC', function (): void {
    $result = (new ElectricalImpedance)->calculate(new Inputs([
        'resistance' => Resistance::zero(),
        'frequency' => Frequency::fromHertz(50),
        'capacitance' => Capacitance::fromFarads('0.000001'),
    ]));

    expect(Results::shown($result, 'impedance'))->toBe('3183.09886184');
});

it('refuses a zero frequency', function (): void {
    (new ElectricalImpedance)->calculate(new Inputs([
        'resistance' => Resistance::fromOhms(1),
        'frequency' => Frequency::zero(),
        'capacitance' => Capacitance::fromFarads(1),
    ]));
})->throws(InvalidInput::class, 'Input "frequency"');

it('refuses a negative resistance', function (): void {
    (new ElectricalImpedance)->calculate(new Inputs([
        'resistance' => Resistance::fromOhms(-1),
        'frequency' => Frequency::fromHertz(60),
        'capacitance' => Capacitance::fromFarads(1),
    ]));
})->throws(InvalidInput::class, 'Input "resistance": the value cannot be negative.');
