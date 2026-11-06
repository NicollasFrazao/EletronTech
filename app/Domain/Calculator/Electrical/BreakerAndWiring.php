<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Electrical;

use App\Domain\Calculator\Calculator;
use App\Domain\Calculator\Electrical\Nbr5410\BreakerRatings;
use App\Domain\Calculator\Electrical\Nbr5410\ConductorTable;
use App\Domain\Calculator\FixedUnit;
use App\Domain\Calculator\InputField;
use App\Domain\Calculator\InputProblem;
use App\Domain\Calculator\Inputs;
use App\Domain\Calculator\InvalidInput;
use App\Domain\Calculator\Result;
use App\Domain\Calculator\ResultValue;
use App\Domain\Quantity\ApparentPower;
use App\Domain\Quantity\BaseUnit;
use App\Domain\Quantity\DivisionByZero;
use App\Domain\Quantity\Voltage;

/**
 * Breaker and wiring: the breaker and the conductor section of a circuit, from its load, voltage and supply.
 *
 * The design current is I_B = S / (k × V), k = 1 for one or two phases and √3 for three. The breaker is the
 * smallest rating with I_B ≤ I_n and the conductor the smallest section, no thinner than the circuit's minimum,
 * with I_n ≤ I_Z (NBR 5410 section 5.3.4.1). For breakers to IEC 60898-1 the conventional tripping current is
 * 1.45 × I_n, so the second condition of that section, I_2 ≤ 1.45 × I_Z, follows from the first.
 */
final readonly class BreakerAndWiring implements Calculator
{
    private const string APPARENT_POWER = 'apparent_power';

    /**
     * The tool's identifier.
     */
    public function id(): string
    {
        return 'breaker-and-wiring';
    }

    /**
     * The supply system, what the circuit feeds, its load and its voltage.
     *
     * @return non-empty-list<InputField>
     */
    public function inputs(): array
    {
        return [
            InputField::choice('supply_system', SupplySystem::cases()),
            InputField::choice('circuit_purpose', CircuitPurpose::cases()),
            InputField::quantity(self::APPARENT_POWER, FixedUnit::of(BaseUnit::VoltAmpere)),
            InputField::quantity('voltage', FixedUnit::of(BaseUnit::Volt)),
        ];
    }

    /**
     * The design current, the breaker rating and the conductor section with its capacity; the loaded conductors
     * and the minimum section are the intermediate values.
     *
     * @throws InvalidInput
     * @throws DivisionByZero
     */
    public function calculate(Inputs $inputs): Result
    {
        $system = $inputs->choice('supply_system', SupplySystem::class);
        $purpose = $inputs->choice('circuit_purpose', CircuitPurpose::class);
        $load = $inputs->positiveQuantity(self::APPARENT_POWER, ApparentPower::class);
        $voltage = $inputs->positiveQuantity('voltage', Voltage::class);

        $designCurrent = $load->dividedByVoltage($voltage)->dividedBy($system->lineFactor());
        $breaker = BreakerRatings::smallestAtLeast($designCurrent)
            ?? throw InvalidInput::of(self::APPARENT_POWER, InputProblem::TooLarge);
        [$section, $capacity] = ConductorTable::smallestCarrying($breaker, $system->loadedConductors(), $purpose)
            ?? throw InvalidInput::of(self::APPARENT_POWER, InputProblem::TooLarge);

        $ampere = FixedUnit::of(BaseUnit::Ampere);
        $squareMillimetre = FixedUnit::of(BaseUnit::SquareMillimetre);

        return new Result(
            [
                ResultValue::quantity('design_current', $designCurrent, $ampere),
                ResultValue::quantity('breaker_rating', $breaker, $ampere),
                ResultValue::quantity('conductor_section', $section, $squareMillimetre),
                ResultValue::quantity('conductor_capacity', $capacity, $ampere),
            ],
            [
                ResultValue::number('loaded_conductors', $system->loadedConductors()),
                ResultValue::quantity('minimum_section', ConductorTable::minimumSection($purpose), $squareMillimetre),
            ],
        );
    }
}
