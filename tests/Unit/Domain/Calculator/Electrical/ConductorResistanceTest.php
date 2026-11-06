<?php

declare(strict_types=1);

use App\Domain\Calculator\Electrical\ConductorResistance;
use App\Domain\Calculator\InputProblem;
use App\Domain\Calculator\Inputs;
use App\Domain\Calculator\Result;
use App\Domain\Quantity\Area;
use App\Domain\Quantity\Length;
use App\Domain\Quantity\Resistance;
use App\Domain\Quantity\Resistivity;
use Tests\Support\Results;

// Ohm's second law, R = ρ × L / A. Annealed copper at 20 °C has ρ ≈ 0.0172 Ω·mm²/m (IEC 60028 gives
// 1/58 Ω·mm²/m), so 100 m of 2.5 mm² wire have 0.0172 × 100 / 2.5 = 0.688 Ω.

it('solves for whichever value is left empty', function (string $unknown, string $expected): void {
    $given = [
        'resistivity' => Resistivity::fromOhmMetres('0.0000000172'),
        'length' => Length::fromMetres(100),
        'cross_section' => Area::fromSquareMetres('0.0000025'),
        'resistance' => Resistance::fromOhms('0.688'),
    ];
    unset($given[$unknown]);

    $result = (new ConductorResistance)->calculate(new Inputs($given));

    expect(Results::exact($result, $unknown))->toBe($expected)
        ->and(Results::names($result))->toBe(['resistivity', 'length', 'cross_section', 'resistance']);
})->with([
    'resistance, in Ω' => ['resistance', '86/125'],
    'resistivity, in Ω·mm²/m' => ['resistivity', '43/2500'],
    'length, in m' => ['length', '100'],
    'cross-section, in mm²' => ['cross_section', '5/2'],
]);

it('shows the resistivity in Ω·mm²/m and the cross-section in mm²', function (): void {
    $result = (new ConductorResistance)->calculate(new Inputs([
        'resistivity' => Resistivity::fromOhmMetres('0.0000000172'),
        'length' => Length::fromMetres(100),
        'cross_section' => Area::fromSquareMetres('0.0000025'),
    ]));

    expect([Results::unit($result, 'resistivity'), Results::unit($result, 'cross_section')])->toBe(['Ω·mm²/m', 'mm²']);
});

it('calculates at all (2015: the form had no length or cross-section field, so the script failed)', function (): void {
    $result = (new ConductorResistance)->calculate(new Inputs([
        'resistivity' => Resistivity::fromOhmMetres('0.0000000282'),
        'length' => Length::fromMetres(50),
        'cross_section' => Area::fromSquareMetres('0.00001'),
    ]));

    expect(Results::shown($result, 'resistance'))->toBe('0.141');
});

it('needs exactly one value left empty', function (): void {
    expectInvalid(
        fn (): Result => (new ConductorResistance)->calculate(new Inputs(['length' => Length::fromMetres(1)])),
        'inputs',
        InputProblem::WrongNumberOfValues,
    );
});

it('refuses a value that is not greater than zero', function (): void {
    expectInvalid(
        fn (): Result => (new ConductorResistance)->calculate(new Inputs([
            'resistivity' => Resistivity::fromOhmMetres('0.0000000172'),
            'length' => Length::zero(),
            'resistance' => Resistance::fromOhms(1),
        ])),
        'length',
        InputProblem::NotPositive,
    );
});
