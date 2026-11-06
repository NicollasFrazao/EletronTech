<?php

declare(strict_types=1);

use App\Domain\Calculator\Electrical\BreakerAndWiring;
use App\Domain\Calculator\Inputs;
use App\Domain\Calculator\InvalidInput;
use App\Domain\Quantity\ApparentPower;
use App\Domain\Quantity\Voltage;
use Tests\Support\Results;

// I_B = S / V (S / √3V for three phases); breaker: smallest IEC 60898-1 rating with I_B ≤ I_n; conductor: smallest
// section with I_n ≤ I_Z in NBR 5410:2004 table 36 (method B1, copper, PVC), never below table 47's minimum
// (1.5 mm² lighting, 2.5 mm² power).

/**
 * The circuit's design current, breaker, section and capacity.
 *
 * @return list<string>
 */
function circuitFor(string $system, string $purpose, string $voltAmperes, string $volts): array
{
    $result = (new BreakerAndWiring)->calculate(new Inputs([
        'supply_system' => $system,
        'circuit_purpose' => $purpose,
        'apparent_power' => ApparentPower::fromVoltAmperes($voltAmperes),
        'voltage' => Voltage::fromVolts($volts),
    ]));

    return [
        Results::shown($result, 'design_current'),
        Results::exact($result, 'breaker_rating'),
        Results::exact($result, 'conductor_section'),
        Results::exact($result, 'conductor_capacity'),
    ];
}

it('sizes the breaker and the conductor of a circuit', function (array $circuit, array $expected): void {
    expect(circuitFor(...$circuit))->toBe($expected);
})->with([
    '5500 VA shower at 220 V' => [['single_phase', 'power', '5500', '220'], ['25', '25', '4', '32']],
    'lighting, 1000 VA at 127 V' => [['single_phase', 'lighting', '1000', '127'], ['7.87401574803', '8', '3/2', '35/2']],
    'outlets, 1000 VA at 127 V: power minimum' => [['single_phase', 'power', '1000', '127'], ['7.87401574803', '8', '5/2', '24']],
    'two-phase 4400 VA at 220 V' => [['two_phase', 'power', '4400', '220'], ['20', '20', '5/2', '24']],
    'three-phase 10 kVA at 380 V, three loaded conductors' => [
        ['three_phase', 'power', '10000', '380'], ['15.1934281366', '16', '5/2', '21'],
    ],
    'breaker of 25 A where 2.5 mm² carries only 24 A' => [['single_phase', 'power', '5280', '220'], ['24', '25', '4', '32']],
    'largest breaker' => [['single_phase', 'power', '27500', '220'], ['125', '125', '35', '125']],
]);

it('reports the loaded conductors and the minimum section it used', function (): void {
    $result = (new BreakerAndWiring)->calculate(new Inputs([
        'supply_system' => 'three_phase',
        'circuit_purpose' => 'lighting',
        'apparent_power' => ApparentPower::fromVoltAmperes(3000),
        'voltage' => Voltage::fromVolts(220),
    ]));

    expect(Results::exact($result, 'loaded_conductors'))->toBe('3')
        ->and(Results::exact($result, 'minimum_section'))->toBe('3/2')
        ->and(Results::unit($result, 'conductor_section'))->toBe('mm²');
});

it('refuses a load beyond the largest breaker', function (): void {
    circuitFor('single_phase', 'power', '27501', '220');
})->throws(InvalidInput::class, 'Input "apparent_power": the value is beyond the largest the tables cover.');
