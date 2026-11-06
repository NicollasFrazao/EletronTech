<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Electrical;

use App\Domain\Calculator\Calculator;
use App\Domain\Calculator\Electrical\Nbr5410\OutletRequirements;
use App\Domain\Calculator\FixedUnit;
use App\Domain\Calculator\InputField;
use App\Domain\Calculator\Inputs;
use App\Domain\Calculator\InvalidInput;
use App\Domain\Calculator\Result;
use App\Domain\Calculator\ResultValue;
use App\Domain\Quantity\BaseUnit;

/**
 * Outlet count: the minimum number of general-purpose outlets of a room and their load, by NBR 5410.
 */
final readonly class OutletCount implements Calculator
{
    /**
     * The tool's identifier.
     */
    public function id(): string
    {
        return 'outlet-count';
    }

    /**
     * The kind of room, its length and its width.
     *
     * @return non-empty-list<InputField>
     */
    public function inputs(): array
    {
        return [InputField::choice('room_type', RoomType::cases()), ...RoomDimensions::fields()];
    }

    /**
     * The outlet count and the total load, with the area, the perimeter and how many outlets take each load.
     *
     * @throws InvalidInput
     */
    public function calculate(Inputs $inputs): Result
    {
        $type = $inputs->choice('room_type', RoomType::class);
        $room = RoomDimensions::from($inputs);

        $outlets = OutletRequirements::count($type, $room);
        $highLoad = OutletRequirements::highLoadOutlets($type, $outlets);
        $otherOutlets = $outlets->minus($highLoad);

        return new Result(
            [
                ResultValue::number('outlets', $outlets),
                ResultValue::quantity(
                    'total_load',
                    OutletRequirements::load($highLoad, $otherOutlets),
                    FixedUnit::of(BaseUnit::VoltAmpere),
                ),
            ],
            [
                ResultValue::quantity('area', $room->area(), FixedUnit::of(BaseUnit::SquareMetre)),
                ResultValue::quantity('perimeter', $room->perimeter(), FixedUnit::of(BaseUnit::Metre)),
                ResultValue::number('outlets_at_600_va', $highLoad),
                ResultValue::number('outlets_at_100_va', $otherOutlets),
            ],
        );
    }
}
