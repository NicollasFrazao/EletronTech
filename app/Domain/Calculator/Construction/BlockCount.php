<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Construction;

use App\Domain\Calculator\Calculator;
use App\Domain\Calculator\FixedUnit;
use App\Domain\Calculator\InputField;
use App\Domain\Calculator\Inputs;
use App\Domain\Calculator\InvalidInput;
use App\Domain\Calculator\Result;
use App\Domain\Calculator\ResultValue;
use App\Domain\Quantity\BaseUnit;
use App\Domain\Quantity\DivisionByZero;
use App\Domain\Quantity\Length;
use App\Domain\Quantity\Prefix;

/**
 * Block count: how many blocks or bricks build a wall. Each block takes its own face plus one joint along its length
 * and one along its height, (l + j) × (h + j), so n = ⌈A_wall × (1 + waste) / ((l + j) × (h + j))⌉.
 */
final readonly class BlockCount implements Calculator
{
    private const string JOINT = 'joint';

    /**
     * The tool's identifier.
     */
    public function id(): string
    {
        return 'block-count';
    }

    /**
     * The wall (in metres), the block and the mortar joint (in centimetres), and the waste allowance in percent
     * (10% when empty).
     *
     * @return non-empty-list<InputField>
     */
    public function inputs(): array
    {
        $metre = FixedUnit::of(BaseUnit::Metre);
        $centimetre = FixedUnit::of(BaseUnit::Metre, Prefix::Centi);

        return [
            InputField::quantity('wall_length', $metre),
            InputField::quantity('wall_height', $metre),
            InputField::quantity('block_length', $centimetre),
            InputField::quantity('block_height', $centimetre),
            InputField::quantity(self::JOINT, $centimetre),
            InputField::number(MaterialCount::WASTE)->optional(),
        ];
    }

    /**
     * The wall's area and the blocks to buy; the area each block covers with its joints, the blocks per square
     * metre and the count before rounding are intermediates.
     *
     * @throws InvalidInput When a measure is missing or not greater than zero (the joint may be zero), or the
     *                      allowance is out of range.
     * @throws DivisionByZero
     */
    public function calculate(Inputs $inputs): Result
    {
        $wall = $inputs->positiveQuantity('wall_length', Length::class)
            ->timesLength($inputs->positiveQuantity('wall_height', Length::class));
        $joint = $inputs->nonNegativeQuantity(self::JOINT, Length::class);
        $laid = $inputs->positiveQuantity('block_length', Length::class)->plus($joint)
            ->timesLength($inputs->positiveQuantity('block_height', Length::class)->plus($joint));
        $count = MaterialCount::withWasteFrom($inputs);

        return new Result(
            [
                ResultValue::quantity('area', $wall, FixedUnit::of(BaseUnit::SquareMetre)),
                ResultValue::number('blocks', $count->piecesFor($wall, $laid)),
            ],
            [
                ResultValue::quantity('area_per_block', $laid, FixedUnit::of(BaseUnit::SquareCentimetre)),
                ResultValue::number('blocks_per_square_metre', $laid->toSquareMetres()->reciprocal()),
                ...$count->intermediates($wall, $laid),
            ],
        );
    }
}
