<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Electrical;

use App\Domain\Calculator\Calculator;
use App\Domain\Calculator\Electrical\Nbr5410\LightingLoad;
use App\Domain\Calculator\FixedUnit;
use App\Domain\Calculator\InputField;
use App\Domain\Calculator\Inputs;
use App\Domain\Calculator\InvalidInput;
use App\Domain\Calculator\Result;
use App\Domain\Calculator\ResultValue;
use App\Domain\Quantity\BaseUnit;

/**
 * Lighting power: the minimum lighting load NBR 5410 sets for a room from its floor area.
 */
final readonly class LightingPower implements Calculator
{
    /**
     * The tool's identifier.
     */
    public function id(): string
    {
        return 'lighting-power';
    }

    /**
     * The room's length and width.
     *
     * @return non-empty-list<InputField>
     */
    public function inputs(): array
    {
        return RoomDimensions::fields();
    }

    /**
     * The lighting load, with the area and the number of 4 m² steps beyond the first 6 m².
     *
     * @throws InvalidInput
     */
    public function calculate(Inputs $inputs): Result
    {
        $area = RoomDimensions::from($inputs)->area();

        return new Result(
            [ResultValue::quantity('lighting_load', LightingLoad::forArea($area), FixedUnit::of(BaseUnit::VoltAmpere))],
            [
                ResultValue::quantity('area', $area, FixedUnit::of(BaseUnit::SquareMetre)),
                ResultValue::number('additional_steps', LightingLoad::additionalSteps($area)),
            ],
        );
    }
}
