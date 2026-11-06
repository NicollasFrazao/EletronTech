<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Electrical;

use App\Domain\Calculator\Calculator;
use App\Domain\Calculator\FixedUnit;
use App\Domain\Calculator\InputField;
use App\Domain\Calculator\InputProblem;
use App\Domain\Calculator\Inputs;
use App\Domain\Calculator\InvalidInput;
use App\Domain\Calculator\Result;
use App\Domain\Calculator\ResultValue;
use App\Domain\Quantity\BaseUnit;
use App\Domain\Quantity\DivisionByZero;
use App\Domain\Quantity\Illuminance;
use App\Domain\Quantity\Length;
use App\Domain\Quantity\LuminousFlux;
use App\Domain\Quantity\Power;
use Brick\Math\BigRational;
use Brick\Math\RoundingMode;

/**
 * General lighting by the lumen method: how many luminaires a room needs to reach an illuminance on its work plane.
 *
 * The room index is K = c × l / (h × (c + l)) for direct, diffuse and semi-direct lighting, h being the height
 * from the work plane to the luminaires, and K = 3 × c × l / (2 × h' × (c + l)) for indirect and semi-indirect
 * lighting, h' being the height from the work plane to the ceiling. With the utilisation factor u (from K and
 * the reflectances) and the depreciation factor d, the total flux is Φ = E × A / (u × d), the number of
 * luminaires n = Φ / φ rounded up, and the installed power n × P.
 */
final readonly class GeneralLighting implements Calculator
{
    private const string CEILING_HEIGHT = 'ceiling_height';

    private const string WORK_PLANE_HEIGHT = 'work_plane_height';

    private const string SUSPENSION = 'luminaire_suspension';

    /**
     * For indirect lighting the room index is 3/2 of the direct formula, measured from the ceiling.
     */
    private const string INDIRECT_ROOM_INDEX_FACTOR = '3/2';

    /**
     * The tool's identifier.
     */
    public function id(): string
    {
        return 'general-lighting';
    }

    /**
     * The room, its heights, the illuminance wanted, the installation's conditions and the luminaire chosen.
     *
     * @return non-empty-list<InputField>
     */
    public function inputs(): array
    {
        $metre = FixedUnit::of(BaseUnit::Metre);

        return [
            ...RoomDimensions::fields(),
            InputField::quantity(self::CEILING_HEIGHT, $metre),
            InputField::quantity(self::WORK_PLANE_HEIGHT, $metre),
            InputField::choice('lighting_system', LightingSystem::cases()),
            InputField::quantity(self::SUSPENSION, $metre)->optional(),
            InputField::quantity('illuminance', FixedUnit::of(BaseUnit::Lux)),
            InputField::choice('room_cleanliness', RoomCleanliness::cases()),
            InputField::choice('maintenance_interval', MaintenanceInterval::cases()),
            InputField::choice('reflectances', SurfaceReflectances::cases()),
            InputField::quantity('luminaire_flux', FixedUnit::of(BaseUnit::Lumen)),
            InputField::quantity('luminaire_power', FixedUnit::of(BaseUnit::Watt)),
        ];
    }

    /**
     * The number of luminaires, the total flux and the installed power, with every step of the method.
     *
     * @throws InvalidInput
     * @throws DivisionByZero
     */
    public function calculate(Inputs $inputs): Result
    {
        $room = RoomDimensions::from($inputs);
        $system = $inputs->choice('lighting_system', LightingSystem::class);
        $height = $this->usefulHeight($inputs, $system);
        $roomIndex = $this->roomIndex($room, $height, $system);

        $utilisation = LuminaireTables::utilisationFactor($roomIndex, $inputs->choice('reflectances', SurfaceReflectances::class));
        $depreciation = LuminaireTables::depreciationFactor(
            $inputs->choice('room_cleanliness', RoomCleanliness::class),
            $inputs->choice('maintenance_interval', MaintenanceInterval::class),
        );

        $totalFlux = $inputs->positiveQuantity('illuminance', Illuminance::class)
            ->timesArea($room->area())
            ->dividedBy($utilisation->multipliedBy($depreciation));
        $luminaires = $totalFlux->ratioTo($inputs->positiveQuantity('luminaire_flux', LuminousFlux::class))
            ->toScale(0, RoundingMode::Ceiling);
        $power = $inputs->positiveQuantity('luminaire_power', Power::class)->multipliedBy($luminaires);

        $metre = FixedUnit::of(BaseUnit::Metre);

        return new Result(
            [
                ResultValue::number('luminaires', $luminaires),
                ResultValue::quantity('total_flux', $totalFlux, FixedUnit::of(BaseUnit::Lumen)),
                ResultValue::quantity('installed_power', $power, FixedUnit::of(BaseUnit::Watt)),
            ],
            [
                ResultValue::quantity('area', $room->area(), FixedUnit::of(BaseUnit::SquareMetre)),
                ResultValue::quantity('perimeter', $room->perimeter(), $metre),
                ResultValue::quantity('useful_height', $height, $metre),
                ResultValue::number('room_index', $roomIndex),
                ResultValue::number('utilisation_factor', $utilisation),
                ResultValue::number('depreciation_factor', $depreciation),
            ],
        );
    }

    /**
     * The height the room index is measured with: from the work plane to the luminaires (the ceiling minus their
     * suspension) for mostly direct lighting, from the work plane to the ceiling for mostly indirect lighting.
     *
     * @throws InvalidInput When the work plane and the suspension leave no height.
     */
    private function usefulHeight(Inputs $inputs, LightingSystem $system): Length
    {
        $ceiling = $inputs->positiveQuantity(self::CEILING_HEIGHT, Length::class);
        $height = $ceiling->minus($inputs->nonNegativeQuantity(self::WORK_PLANE_HEIGHT, Length::class));

        if (! $system->isMostlyIndirect() && $inputs->has(self::SUSPENSION)) {
            $height = $height->minus($inputs->nonNegativeQuantity(self::SUSPENSION, Length::class));
        }

        if ($height->isNegative() || $height->isZero()) {
            throw InvalidInput::of(self::CEILING_HEIGHT, InputProblem::OutOfRange);
        }

        return $height;
    }

    /**
     * The room index K.
     *
     * @throws DivisionByZero
     */
    private function roomIndex(RoomDimensions $room, Length $height, LightingSystem $system): BigRational
    {
        $index = $room->area()->dividedByLength($height)->ratioTo($room->semiPerimeter());

        return $system->isMostlyIndirect() ? $index->multipliedBy(self::INDIRECT_ROOM_INDEX_FACTOR) : $index;
    }
}
