<?php

declare(strict_types=1);

use App\Domain\Calculator\Geometry\SurfaceAreaAndVolume;
use App\Domain\Calculator\InputProblem;
use App\Domain\Calculator\Inputs;
use App\Domain\Calculator\Result;
use App\Domain\Quantity\Length;
use Tests\Support\Results;

// Solid geometry: cube S = 6a², V = a³; square pyramid g = √(h² + (a/2)²), S = a² + 2ag, V = a²h/3; regular
// tetrahedron S = √3 a², V = √2 a³ / 12; cone g = √(r² + h²), S = πr(r + g), V = πr²h/3; cylinder
// S = 2πr(r + h), V = πr²h.

/**
 * The result for a solid, its dimensions given in metres.
 *
 * @param  array<string, int|string>  $metres
 */
function solidFigure(string $shape, array $metres): Result
{
    $lengths = array_map(Length::fromMetres(...), $metres);

    return (new SurfaceAreaAndVolume)->calculate(new Inputs(['shape' => $shape, ...$lengths]));
}

it('calculates the surface area and the volume of each solid', function (string $shape, array $metres, string $area, string $volume): void {
    $result = solidFigure($shape, $metres);

    expect([Results::shown($result, 'surface_area'), Results::shown($result, 'volume')])->toBe([$area, $volume])
        ->and([Results::unit($result, 'surface_area'), Results::unit($result, 'volume')])->toBe(['m²', 'm³']);
})->with([
    'cube' => ['cube', ['edge' => 2], '24', '8'],
    'square pyramid' => ['square_pyramid', ['edge' => 6, 'height' => 4], '96', '48'],
    'regular tetrahedron of edge 1' => ['regular_tetrahedron', ['edge' => 1], '1.73205080757', '0.117851130198'],
    'regular tetrahedron of edge 2' => ['regular_tetrahedron', ['edge' => 2], '6.92820323028', '0.942809041582'],
    'cone' => ['cone', ['radius' => 3, 'height' => 4], '75.3982236862', '37.6991118431'],
    'cylinder' => ['cylinder', ['radius' => 1, 'height' => 2], '18.8495559215', '6.28318530718'],
]);

it('shows the measures found on the way', function (string $shape, array $metres, string $name, string $expected): void {
    expect(Results::shown(solidFigure($shape, $metres), $name))->toBe($expected);
})->with([
    'pyramid slant height' => ['square_pyramid', ['edge' => 6, 'height' => 4], 'slant_height', '5'],
    'cone slant height' => ['cone', ['radius' => 3, 'height' => 4], 'slant_height', '5'],
    'cone lateral area' => ['cone', ['radius' => 3, 'height' => 4], 'lateral_area', '47.1238898038'],
    'cylinder lateral area' => ['cylinder', ['radius' => 1, 'height' => 2], 'lateral_area', '12.5663706144'],
]);

it('keeps a cube exact', function (): void {
    expect(Results::exact(solidFigure('cube', ['edge' => '0.1']), 'volume'))->toBe('1/1000');
});

it('calculates at all (2015: the page loaded a script that did not exist)', function (): void {
    expect(Results::shown(solidFigure('cylinder', ['radius' => '0.5', 'height' => 1]), 'volume'))->toBe('0.785398163397');
});

it('refuses a missing or non-positive dimension of the chosen solid', function (): void {
    expectInvalid(fn (): Result => solidFigure('cone', ['radius' => 1]), 'height', InputProblem::Missing);
    expectInvalid(fn (): Result => solidFigure('cube', ['edge' => -1]), 'edge', InputProblem::NotPositive);
    expectInvalid(fn (): Result => solidFigure('sphere', ['radius' => 1]), 'shape', InputProblem::UnknownOption);
});
