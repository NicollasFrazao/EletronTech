<?php

declare(strict_types=1);

use App\Domain\Calculator\Electrical\ResistorColourCode;
use App\Domain\Calculator\InputProblem;
use App\Domain\Calculator\Inputs;
use App\Domain\Calculator\InvalidInput;
use App\Domain\Calculator\Result;
use App\Domain\Quantity\Resistance;
use Tests\Support\Results;

// IEC 60062:2016, four-band code: (10 × first digit + second digit) × 10^multiplier, tolerance on the fourth band,
// ±20% without one. Yellow, violet, red, gold is 4.7 kΩ ±5%.

/**
 * The inputs of a resistor's bands, the tolerance band only when given.
 *
 * @return array<string, string>
 */
function bands(string $first, string $second, string $multiplier, ?string $tolerance = null): array
{
    $bands = ['first_band' => $first, 'second_band' => $second, 'multiplier_band' => $multiplier];

    return $tolerance === null ? $bands : [...$bands, 'tolerance_band' => $tolerance];
}

it('reads the resistance and the tolerance range from the bands', function (
    array $bands,
    string $ohms,
    string $tolerance,
    string $minimum,
    string $maximum,
): void {
    $result = (new ResistorColourCode)->calculate(new Inputs($bands));

    expect(Results::exact($result, 'resistance'))->toBe($ohms)
        ->and(Results::exact($result, 'tolerance_percent'))->toBe($tolerance)
        ->and(Results::exact($result, 'minimum_resistance'))->toBe($minimum)
        ->and(Results::exact($result, 'maximum_resistance'))->toBe($maximum);
})->with([
    '4.7 kΩ ±5%' => [bands('yellow', 'violet', 'red', 'gold'), '4700', '5', '4465', '4935'],
    '0.47 Ω, which the 2015 version showed as 0.47000000000000003' => [
        bands('yellow', 'violet', 'silver', 'brown'), '47/100', '1', '4653/10000', '4747/10000',
    ],
    '1 Ω' => [bands('brown', 'black', 'gold', 'red'), '1', '2', '49/50', '51/50'],
    '1 MΩ without a tolerance band' => [bands('brown', 'black', 'green'), '1000000', '20', '800000', '1200000'],
    '99 GΩ' => [bands('white', 'white', 'white', 'violet'), '99000000000', '1/10', '98901000000', '99099000000'],
]);

it('writes the bands of a resistance', function (string $ohms, array $bands): void {
    $result = (new ResistorColourCode)->calculate(new Inputs(['resistance' => Resistance::fromOhms($ohms)]));

    expect([
        Results::exact($result, 'first_band'),
        Results::exact($result, 'second_band'),
        Results::exact($result, 'multiplier_band'),
    ])->toBe($bands);
})->with([
    ['4700', ['yellow', 'violet', 'red']],
    ['4.7', ['yellow', 'violet', 'gold']],
    ['0.1', ['brown', 'black', 'silver']],
    ['100', ['brown', 'black', 'brown']],
    ['10', ['brown', 'black', 'black']],
    ['220000', ['red', 'red', 'yellow']],
]);

it('refuses a resistance with no four-band code', function (string $ohms): void {
    (new ResistorColourCode)->calculate(new Inputs(['resistance' => Resistance::fromOhms($ohms)]));
})->with(['4750', '0.05', '100000000000', '1/3'])->throws(InvalidInput::class, 'Input "resistance": the value cannot be written this way.');

it('refuses bands that cannot be where they are', function (array $bands, string $field): void {
    expectInvalid(fn (): Result => (new ResistorColourCode)->calculate(new Inputs($bands)), $field, InputProblem::UnknownOption);
})->with([
    'black first' => [bands('black', 'red', 'red'), 'first_band'],
    'gold second' => [bands('red', 'gold', 'red'), 'second_band'],
    'black tolerance' => [bands('red', 'red', 'red', 'black'), 'tolerance_band'],
    'pink' => [bands('pink', 'red', 'red'), 'first_band'],
]);

it('refuses both a resistance and its bands', function (): void {
    (new ResistorColourCode)->calculate(new Inputs(['resistance' => Resistance::fromOhms(100), 'first_band' => 'brown']));
})->throws(InvalidInput::class, 'Input "first_band"');
