<?php

declare(strict_types=1);

use App\Domain\Calculator\Construction\FloorAndWallTiles;
use App\Domain\Calculator\InputProblem;
use App\Domain\Calculator\Inputs;
use App\Domain\Calculator\Result;
use App\Domain\Quantity\Length;
use Brick\Math\BigRational;
use Tests\Support\Results;

// Tiles for a surface: n = ⌈A_surface × (1 + waste) / A_tile⌉, with the usual 10% waste for cuts and breakage.
// A 4 m × 3 m floor in 60 cm × 60 cm tiles: 12 × 1.1 / 0.36 = 36.67, so 37 tiles.

/**
 * The tiles for a surface in metres and a tile in centimetres, with an optional waste percentage.
 */
function tiles(string $length, string $width, string $tileLength, string $tileWidth, ?string $waste = null): Result
{
    $centimetre = BigRational::of('0.01');
    $inputs = [
        'surface_length' => Length::fromMetres($length),
        'surface_width' => Length::fromMetres($width),
        'tile_length' => Length::fromMetres(BigRational::of($tileLength)->multipliedBy($centimetre)),
        'tile_width' => Length::fromMetres(BigRational::of($tileWidth)->multipliedBy($centimetre)),
    ];

    if ($waste !== null) {
        $inputs['waste'] = BigRational::of($waste);
    }

    return (new FloorAndWallTiles)->calculate(new Inputs($inputs));
}

it('counts the tiles with the usual 10% waste', function (): void {
    $result = tiles('4', '3', '60', '60');

    expect(Results::shown($result, 'area'))->toBe('12')
        ->and(Results::shown($result, 'tiles'))->toBe('37')
        ->and(Results::shown($result, 'tile_area'))->toBe('3600')
        ->and(Results::unit($result, 'tile_area'))->toBe('cm²')
        ->and(Results::exact($result, 'pieces_without_rounding'))->toBe('110/3')
        ->and(Results::shown($result, 'waste_percent'))->toBe('10');
});

it('rounds up so the last tile is never short (2015: Math.round bought 54 tiles where 54.3 were needed)', function (): void {
    expect(Results::shown(tiles('4', '2.5', '45', '45'), 'tiles'))->toBe('55');
});

it('does not round up an exact count', function (): void {
    expect(Results::shown(tiles('3', '3', '30', '30', '0'), 'tiles'))->toBe('100');
});

it('takes another waste allowance, from 0% to 100%', function (string $waste, string $expected): void {
    expect(Results::shown(tiles('3', '3', '30', '30', $waste), 'tiles'))->toBe($expected);
})->with([
    'fifteen percent' => ['15', '115'],
    'a hundred percent' => ['100', '200'],
]);

it('refuses a waste allowance outside 0% to 100%', function (string $waste): void {
    expectInvalid(fn (): Result => tiles('3', '3', '30', '30', $waste), 'waste', InputProblem::OutOfRange);
})->with(['-1', '100.5']);

it('refuses a measure that is not greater than zero', function (): void {
    expectInvalid(fn (): Result => tiles('3', '3', '0', '30'), 'tile_length', InputProblem::NotPositive);
});
