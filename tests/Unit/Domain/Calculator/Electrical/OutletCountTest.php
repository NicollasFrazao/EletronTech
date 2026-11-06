<?php

declare(strict_types=1);

use App\Domain\Calculator\Electrical\OutletCount;
use App\Domain\Calculator\Inputs;
use App\Domain\Calculator\InvalidInput;
use App\Domain\Quantity\Length;
use Tests\Support\Results;

// NBR 5410:2004, 9.5.2.2.1 (count) and 9.5.2.2.2 (load): bathrooms and verandas at least one outlet; kitchens,
// pantries, service areas and laundries one per 3.5 m or fraction of perimeter; living rooms and bedrooms one per
// 5 m or fraction; other rooms one up to 6 m², then one per 5 m or fraction. Wet rooms: 600 VA for each of the
// first three outlets, 100 VA beyond; other rooms 100 VA per outlet.

/**
 * The result for a room.
 *
 * @return array{string, string, string, string}
 */
function outletsFor(string $type, string $length, string $width): array
{
    $result = (new OutletCount)->calculate(new Inputs([
        'room_type' => $type,
        'length' => Length::fromMetres($length),
        'width' => Length::fromMetres($width),
    ]));

    return [
        Results::exact($result, 'outlets'),
        Results::exact($result, 'outlets_at_600_va'),
        Results::exact($result, 'outlets_at_100_va'),
        Results::exact($result, 'total_load'),
    ];
}

it('counts outlets and their load by room type', function (string $type, string $length, string $width, array $expected): void {
    expect(outletsFor($type, $length, $width))->toBe($expected);
})->with([
    'bathroom, any size' => ['bathroom', '3', '2.5', ['1', '1', '0', '600']],
    'veranda, any size' => ['veranda', '6', '2', ['1', '0', '1', '100']],
    'kitchen 3 × 3.5 m, perimeter 13 m' => ['kitchen', '3', '3.5', ['4', '3', '1', '1900']],
    'pantry, perimeter exactly 7 m' => ['pantry', '2', '1.5', ['2', '2', '0', '1200']],
    'service area 2 × 2 m' => ['service_area', '2', '2', ['3', '3', '0', '1800']],
    'laundry 3 × 4 m' => ['laundry', '3', '4', ['4', '3', '1', '1900']],
    'bedroom 3 × 4 m, perimeter 14 m' => ['bedroom', '3', '4', ['3', '0', '3', '300']],
    'living room, perimeter exactly 20 m' => ['living_room', '5', '5', ['4', '0', '4', '400']],
    'small bedroom still per perimeter' => ['bedroom', '2', '2', ['2', '0', '2', '200']],
    'garage up to 6 m²' => ['garage', '3', '2', ['1', '0', '1', '100']],
    'garage above 6 m², perimeter 16 m' => ['garage', '3', '5', ['4', '0', '4', '400']],
    'attic above 6 m²' => ['attic', '4', '2', ['3', '0', '3', '300']],
    'basement up to 6 m²' => ['basement', '2', '1', ['1', '0', '1', '100']],
]);

it('reports the area and the perimeter it counted with', function (): void {
    $result = (new OutletCount)->calculate(new Inputs([
        'room_type' => 'kitchen',
        'length' => Length::fromMetres('3'),
        'width' => Length::fromMetres('3.5'),
    ]));

    expect(Results::exact($result, 'area'))->toBe('21/2')
        ->and(Results::exact($result, 'perimeter'))->toBe('13');
});

it('refuses an unknown room type', function (): void {
    outletsFor('ballroom', '10', '10');
})->throws(InvalidInput::class, 'Input "room_type"');
