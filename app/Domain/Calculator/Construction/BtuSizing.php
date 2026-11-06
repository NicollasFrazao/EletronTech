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
use App\Domain\Quantity\Area;
use App\Domain\Quantity\BaseUnit;
use App\Domain\Quantity\Power;

/**
 * BTU sizing: the cooling capacity an air conditioner needs for a room, by the rule of thumb Brazilian retailers
 * publish: 600 BTU/h per square metre (which covers one person), 600 BTU/h for each further person and 600 BTU/h
 * for each appliance that gives off heat.
 *
 * It is an estimate for a home or an office, not a thermal load calculation (ABNT NBR 16401 is the engineering
 * method); a sunny room or a large window may need more.
 */
final readonly class BtuSizing implements Calculator
{
    private const string AREA = 'area';

    private const string PEOPLE = 'people';

    private const string APPLIANCES = 'appliances';

    /**
     * BTU/h for each square metre, each person after the first and each appliance.
     */
    private const int SHARE = 600;

    /**
     * The tool's identifier.
     */
    public function id(): string
    {
        return 'btu-sizing';
    }

    /**
     * The room's area, how many people use it and how many heat-giving appliances it has.
     *
     * @return non-empty-list<InputField>
     */
    public function inputs(): array
    {
        return [
            InputField::quantity(self::AREA, FixedUnit::of(BaseUnit::SquareMetre)),
            InputField::number(self::PEOPLE),
            InputField::number(self::APPLIANCES),
        ];
    }

    /**
     * The cooling capacity in BTU/h, with each of its three shares as an intermediate.
     *
     * @throws InvalidInput When the area is not greater than zero or a count is not a whole number of at least 0.
     */
    public function calculate(Inputs $inputs): Result
    {
        $area = $inputs->positiveQuantity(self::AREA, Area::class);
        $people = $inputs->wholeNumber(self::PEOPLE, 0);
        $appliances = $inputs->wholeNumber(self::APPLIANCES, 0);

        $share = Power::fromWatts(FixedUnit::of(BaseUnit::BtuPerHour)->toCoherentUnit(self::SHARE));
        $areaLoad = $share->multipliedBy($area->toSquareMetres());
        $peopleLoad = $share->multipliedBy(max($people - 1, 0));
        $applianceLoad = $share->multipliedBy($appliances);
        $btuPerHour = FixedUnit::of(BaseUnit::BtuPerHour);

        return new Result(
            [ResultValue::quantity('cooling_capacity', $areaLoad->plus($peopleLoad)->plus($applianceLoad), $btuPerHour)],
            [
                ResultValue::quantity('area_load', $areaLoad, $btuPerHour),
                ResultValue::quantity('people_load', $peopleLoad, $btuPerHour),
                ResultValue::quantity('appliance_load', $applianceLoad, $btuPerHour),
            ],
        );
    }
}
