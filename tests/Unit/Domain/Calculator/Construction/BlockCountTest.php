<?php

declare(strict_types=1);

use App\Domain\Calculator\Construction\BlockCount;
use App\Domain\Calculator\InputProblem;
use App\Domain\Calculator\Inputs;
use App\Domain\Calculator\Result;
use App\Domain\Quantity\Length;
use Brick\Math\BigRational;
use Tests\Support\Results;

// Masonry blocks per square metre: 1 / ((l + j) × (h + j)), each block with one joint along its length and one
// along its height. The common 14 × 19 × 39 cm block with 1 cm joints covers 40 × 20 cm: 12.5 blocks per m².
// n = ⌈A_wall × blocks per m² × (1 + waste)⌉, 10% waste unless said otherwise.

/**
 * The blocks for a wall in metres and a block and joint in centimetres, with an optional waste percentage.
 */
function blocks(string $length, string $height, string $blockLength, string $blockHeight, string $joint, ?string $waste = null): Result
{
    $centimetres = static fn (string $value): Length => Length::fromMetres(BigRational::of($value)->dividedBy(100));
    $inputs = [
        'wall_length' => Length::fromMetres($length),
        'wall_height' => Length::fromMetres($height),
        'block_length' => $centimetres($blockLength),
        'block_height' => $centimetres($blockHeight),
        'joint' => $centimetres($joint),
    ];

    if ($waste !== null) {
        $inputs['waste'] = BigRational::of($waste);
    }

    return (new BlockCount)->calculate(new Inputs($inputs));
}

it('counts the blocks of a wall with its joints and 10% waste', function (): void {
    $result = blocks('5', '2.8', '39', '19', '1');

    expect(Results::shown($result, 'area'))->toBe('14')
        ->and(Results::shown($result, 'blocks'))->toBe('193')
        ->and(Results::shown($result, 'blocks_per_square_metre'))->toBe('12.5')
        ->and(Results::shown($result, 'area_per_block'))->toBe('800')
        ->and(Results::exact($result, 'pieces_without_rounding'))->toBe('385/2');
});

it('rounds up so the last block is never short (2015: Math.round bought 103 blocks where 103.1 were needed)', function (): void {
    expect(Results::shown(blocks('3', '2.5', '39', '19', '1'), 'blocks'))->toBe('104');
});

it('accepts blocks laid without joints and no waste', function (): void {
    expect(Results::shown(blocks('1', '1', '20', '10', '0', '0'), 'blocks'))->toBe('50');
});

it('refuses a negative joint and a block that is not greater than zero', function (): void {
    expectInvalid(fn (): Result => blocks('1', '1', '20', '10', '-1'), 'joint', InputProblem::Negative);
    expectInvalid(fn (): Result => blocks('1', '1', '20', '0', '1'), 'block_height', InputProblem::NotPositive);
    expectInvalid(fn (): Result => blocks('1', '1', '20', '10', '1', '120'), 'waste', InputProblem::OutOfRange);
});
