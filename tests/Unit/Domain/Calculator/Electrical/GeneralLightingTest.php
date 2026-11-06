<?php

declare(strict_types=1);

use App\Domain\Calculator\Electrical\GeneralLighting;
use App\Domain\Calculator\Inputs;
use App\Domain\Calculator\InvalidInput;
use App\Domain\Quantity\Illuminance;
use App\Domain\Quantity\Length;
use App\Domain\Quantity\LuminousFlux;
use App\Domain\Quantity\Power;
use Tests\Support\Results;

// Lumen method (Creder, Instalações Elétricas, chapter 4; Moreira, Iluminação Elétrica): K = c·l / (h·(c + l)) for
// direct lighting, K = 3·c·l / (2·h'·(c + l)) for indirect; Φ = E·A / (u·d); n = Φ / φ rounded up. The factors u and
// d come from the 2015 tables (LuminaireTables).

/**
 * The inputs of a 6 × 4 m room, 2.75 m high, work plane at 0.75 m, luminaires hanging 0.8 m: h = 1.2 m and K = 2.
 *
 * @param  array<string, mixed>  $overrides
 */
function lightingInputs(array $overrides = []): Inputs
{
    return new Inputs([
        'length' => Length::fromMetres(6),
        'width' => Length::fromMetres(4),
        'ceiling_height' => Length::fromMetres('2.75'),
        'work_plane_height' => Length::fromMetres('0.75'),
        'lighting_system' => 'direct',
        'luminaire_suspension' => Length::fromMetres('0.8'),
        'illuminance' => Illuminance::fromLux(300),
        'room_cleanliness' => 'clean',
        'maintenance_interval' => '2500_hours',
        'reflectances' => '80_50_30',
        'luminaire_flux' => LuminousFlux::fromLumens(2700),
        'luminaire_power' => Power::fromWatts(18),
        ...$overrides,
    ]);
}

it('finds the luminaires a room needs, with every step of the method', function (): void {
    $result = (new GeneralLighting)->calculate(lightingInputs());

    expect(Results::exact($result, 'area'))->toBe('24')
        ->and(Results::exact($result, 'perimeter'))->toBe('20')
        ->and(Results::exact($result, 'useful_height'))->toBe('6/5')
        ->and(Results::exact($result, 'room_index'))->toBe('2')
        ->and(Results::exact($result, 'utilisation_factor'))->toBe('16/25')
        ->and(Results::exact($result, 'depreciation_factor'))->toBe('19/20')
        ->and(Results::shown($result, 'total_flux'))->toBe('11842.1052632')
        ->and(Results::exact($result, 'luminaires'))->toBe('5')
        ->and(Results::exact($result, 'installed_power'))->toBe('90');
});

it('interpolates the utilisation factor between two room indexes', function (): void {
    $result = (new GeneralLighting)->calculate(lightingInputs([
        'length' => Length::fromMetres(10),
        'width' => Length::fromMetres(8),
        'ceiling_height' => Length::fromMetres(3),
        'work_plane_height' => Length::fromMetres('0.8'),
        'luminaire_suspension' => Length::zero(),
        'illuminance' => Illuminance::fromLux(500),
        'luminaire_flux' => LuminousFlux::fromLumens(3250),
        'luminaire_power' => Power::fromWatts(32),
    ]));

    expect(Results::shown($result, 'room_index'))->toBe('2.0202020202')
        ->and(Results::shown($result, 'utilisation_factor'))->toBe('0.641212121212')
        ->and(Results::shown($result, 'total_flux'))->toBe('65665.1079495')
        ->and(Results::exact($result, 'luminaires'))->toBe('21')
        ->and(Results::exact($result, 'installed_power'))->toBe('672');
});

it('measures indirect lighting from the ceiling, ignoring the suspension', function (): void {
    $result = (new GeneralLighting)->calculate(lightingInputs([
        'length' => Length::fromMetres(10),
        'width' => Length::fromMetres(8),
        'ceiling_height' => Length::fromMetres(3),
        'work_plane_height' => Length::fromMetres('0.8'),
        'lighting_system' => 'indirect',
    ]));

    expect(Results::exact($result, 'useful_height'))->toBe('11/5')
        ->and(Results::shown($result, 'room_index'))->toBe('3.0303030303')
        ->and(Results::shown($result, 'utilisation_factor'))->toBe('0.690606060606');
});

it('uses the first and the last row of the table outside its range', function (string $length, string $factor): void {
    $result = (new GeneralLighting)->calculate(lightingInputs([
        'length' => Length::fromMetres($length),
        'width' => Length::fromMetres($length),
        'luminaire_suspension' => Length::zero(),
        'ceiling_height' => Length::fromMetres(3),
        'work_plane_height' => Length::zero(),
    ]));

    expect(Results::exact($result, 'utilisation_factor'))->toBe($factor);
})->with([
    'K = 0.5' => ['3', '19/50'],
    'K = 10' => ['60', '73/100'],
]);

it('reads the depreciation factor by cleanliness and maintenance', function (string $cleanliness, string $interval, string $factor): void {
    $result = (new GeneralLighting)->calculate(lightingInputs([
        'room_cleanliness' => $cleanliness,
        'maintenance_interval' => $interval,
    ]));

    expect(Results::exact($result, 'depreciation_factor'))->toBe($factor);
})->with([
    ['clean', '7500_hours', '22/25'],
    ['normal', '5000_hours', '17/20'],
    ['dirty', '7500_hours', '57/100'],
]);

it('refuses heights that leave no room between the work plane and the luminaires', function (): void {
    (new GeneralLighting)->calculate(lightingInputs(['luminaire_suspension' => Length::fromMetres(2)]));
})->throws(InvalidInput::class, 'Input "ceiling_height": the value is outside the range');

it('refuses a reflectance combination the table does not have', function (): void {
    (new GeneralLighting)->calculate(lightingInputs(['reflectances' => '10_10_10']));
})->throws(InvalidInput::class, 'Input "reflectances": the value is not one of the options.');
