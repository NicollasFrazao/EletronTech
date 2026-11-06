<?php

declare(strict_types=1);

use App\Domain\Calculator\Electrical\LightingPower;
use App\Domain\Calculator\Inputs;
use App\Domain\Calculator\InvalidInput;
use App\Domain\Quantity\Length;
use Tests\Support\Results;

// NBR 5410:2004, 9.5.2.1.2: 100 VA for the first 6 m², plus 60 VA for each whole 4 m² beyond them.

it('sets the minimum lighting load from the floor area', function (
    string $length,
    string $width,
    string $area,
    string $steps,
    string $load,
): void {
    $result = (new LightingPower)->calculate(new Inputs([
        'length' => Length::fromMetres($length),
        'width' => Length::fromMetres($width),
    ]));

    expect(Results::exact($result, 'area'))->toBe($area)
        ->and(Results::exact($result, 'additional_steps'))->toBe($steps)
        ->and(Results::exact($result, 'lighting_load'))->toBe($load)
        ->and(Results::unit($result, 'lighting_load'))->toBe('VA');
})->with([
    'small room' => ['2', '1.5', '3', '0', '100'],
    'exactly 6 m²' => ['3', '2', '6', '0', '100'],
    'less than one step beyond' => ['3', '3', '9', '0', '100'],
    'exactly one step beyond' => ['5', '2', '10', '1', '160'],
    '16 m², which the 2015 version made 250 W' => ['4', '4', '16', '2', '220'],
    'fractional area' => ['3.5', '4.2', '147/10', '2', '220'],
]);

it('refuses a room without a width', function (): void {
    (new LightingPower)->calculate(new Inputs(['length' => Length::fromMetres(3)]));
})->throws(InvalidInput::class, 'Input "width": a value is required.');
