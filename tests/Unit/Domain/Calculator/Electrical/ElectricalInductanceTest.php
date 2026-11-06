<?php

declare(strict_types=1);

use App\Domain\Calculator\Electrical\ElectricalInductance;
use App\Domain\Calculator\InputProblem;
use App\Domain\Calculator\Inputs;
use App\Domain\Calculator\InvalidInput;
use App\Domain\Calculator\Result;
use App\Domain\Quantity\Current;
use App\Domain\Quantity\Inductance;
use App\Domain\Quantity\MagneticFlux;
use Brick\Math\BigRational;
use Tests\Support\Results;

// L = N × Φ / I, the inductance as flux linkage per ampere (Halliday, Resnick and Walker, Fundamentals of Physics,
// chapter 30). A coil of 500 turns linking 2 mWb each at 4 A has 0.25 H.

/**
 * The coil of 500 turns, 2 mWb per turn, 4 A and 0.25 H, without the values named.
 *
 * @param  list<string>  $unknowns
 *
 * @return array<string, mixed>
 */
function coil(array $unknowns): array
{
    $values = [
        'inductance' => Inductance::fromHenries('0.25'),
        'turns' => BigRational::of(500),
        'magnetic_flux' => MagneticFlux::fromWebers('0.002'),
        'current' => Current::fromAmperes(4),
    ];

    return array_diff_key($values, array_flip($unknowns));
}

it('solves for whichever value is left empty', function (array $given, string $unknown, string $expected): void {
    $result = (new ElectricalInductance)->calculate(new Inputs($given));

    expect(Results::exact($result, $unknown))->toBe($expected)
        ->and(Results::names($result))->toBe(['inductance', 'turns', 'magnetic_flux', 'current']);
})->with([
    'inductance' => [coil(['inductance']), 'inductance', '1/4'],
    'magnetic flux' => [coil(['magnetic_flux']), 'magnetic_flux', '1/500'],
    'current' => [coil(['current']), 'current', '4'],
    'turns' => [coil(['turns']), 'turns', '500'],
]);

it('rounds the turns up to a whole turn and keeps the exact quotient', function (): void {
    $result = (new ElectricalInductance)->calculate(new Inputs([
        'inductance' => Inductance::fromHenries('0.1'),
        'magnetic_flux' => MagneticFlux::fromWebers('0.003'),
        'current' => Current::fromAmperes(1),
    ]));

    expect(Results::exact($result, 'turns'))->toBe('34')
        ->and(Results::exact($result, 'exact_turns'))->toBe('100/3');
});

it('refuses a number of turns that is not a whole number', function (): void {
    (new ElectricalInductance)->calculate(new Inputs([
        'turns' => BigRational::of('2.5'),
        'magnetic_flux' => MagneticFlux::fromWebers(1),
        'current' => Current::fromAmperes(1),
    ]));
})->throws(InvalidInput::class, 'Input "turns": the value must be a whole number.');

it('refuses zero turns', function (): void {
    expectInvalid(fn (): Result => (new ElectricalInductance)->calculate(new Inputs([
        'turns' => BigRational::zero(),
        'magnetic_flux' => MagneticFlux::fromWebers(1),
        'current' => Current::fromAmperes(1),
    ])), 'turns', InputProblem::NotPositive);
});

it('needs exactly one value left empty', function (): void {
    (new ElectricalInductance)->calculate(new Inputs(['turns' => BigRational::of(10), 'current' => Current::fromAmperes(1)]));
})->throws(InvalidInput::class, 'Input "inputs"');
