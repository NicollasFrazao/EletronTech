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
 * Floor and wall tiles: how many tiles cover a rectangular floor or wall, n = ⌈A_surface × (1 + waste) / A_tile⌉.
 */
final readonly class FloorAndWallTiles implements Calculator
{
    /**
     * The tool's identifier.
     */
    public function id(): string
    {
        return 'floor-and-wall-tiles';
    }

    /**
     * The surface (in metres) and the tile (in centimetres), and the waste allowance in percent (10% when empty).
     *
     * @return non-empty-list<InputField>
     */
    public function inputs(): array
    {
        $metre = FixedUnit::of(BaseUnit::Metre);
        $centimetre = FixedUnit::of(BaseUnit::Metre, Prefix::Centi);

        return [
            InputField::quantity('surface_length', $metre),
            InputField::quantity('surface_width', $metre),
            InputField::quantity('tile_length', $centimetre),
            InputField::quantity('tile_width', $centimetre),
            InputField::number(MaterialCount::WASTE)->optional(),
        ];
    }

    /**
     * The surface's area and the tiles to buy; the tile's area and the count before rounding are intermediates.
     *
     * @throws InvalidInput When a measure is missing or not greater than zero, or the allowance is out of range.
     * @throws DivisionByZero
     */
    public function calculate(Inputs $inputs): Result
    {
        $surface = $inputs->positiveQuantity('surface_length', Length::class)
            ->timesLength($inputs->positiveQuantity('surface_width', Length::class));
        $tile = $inputs->positiveQuantity('tile_length', Length::class)
            ->timesLength($inputs->positiveQuantity('tile_width', Length::class));
        $count = MaterialCount::withWasteFrom($inputs);

        return new Result(
            [
                ResultValue::quantity('area', $surface, FixedUnit::of(BaseUnit::SquareMetre)),
                ResultValue::number('tiles', $count->piecesFor($surface, $tile)),
            ],
            [
                ResultValue::quantity('tile_area', $tile, FixedUnit::of(BaseUnit::SquareCentimetre)),
                ...$count->intermediates($surface, $tile),
            ],
        );
    }
}
