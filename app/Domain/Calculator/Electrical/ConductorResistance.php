<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Electrical;

use App\Domain\Calculator\Calculator;
use App\Domain\Calculator\FixedUnit;
use App\Domain\Calculator\InputField;
use App\Domain\Calculator\Inputs;
use App\Domain\Calculator\InvalidInput;
use App\Domain\Calculator\Result;
use App\Domain\Calculator\ResultValue;
use App\Domain\Quantity\Area;
use App\Domain\Quantity\BaseUnit;
use App\Domain\Quantity\DivisionByZero;
use App\Domain\Quantity\Length;
use App\Domain\Quantity\Resistance;
use App\Domain\Quantity\Resistivity;

/**
 * The resistance of a conductor (Ohm's second law, R = ρ × L / A), solved for whichever of resistivity, length,
 * cross-section and resistance is left empty.
 *
 * R is proportional to ρ and to L and inversely proportional to A, so each unknown is the given resistance over
 * the resistance the formula gives with that unknown set to one of its unit.
 */
final readonly class ConductorResistance implements Calculator
{
    private const string RESISTIVITY = 'resistivity';

    private const string LENGTH = 'length';

    private const string CROSS_SECTION = 'cross_section';

    private const string RESISTANCE = 'resistance';

    /**
     * The tool's identifier.
     */
    public function id(): string
    {
        return 'conductor-resistance';
    }

    /**
     * Resistivity (in Ω·mm²/m, as electricians read it), length, cross-section and resistance; exactly one is
     * left empty.
     *
     * @return non-empty-list<InputField>
     */
    public function inputs(): array
    {
        return [
            InputField::quantity(self::RESISTIVITY, FixedUnit::of(BaseUnit::OhmSquareMillimetrePerMetre))->optional(),
            InputField::quantity(self::LENGTH, FixedUnit::of(BaseUnit::Metre))->optional(),
            InputField::quantity(self::CROSS_SECTION, FixedUnit::of(BaseUnit::SquareMillimetre))->optional(),
            InputField::quantity(self::RESISTANCE, FixedUnit::of(BaseUnit::Ohm))->optional(),
        ];
    }

    /**
     * The four values, the one left empty calculated from the other three.
     *
     * @throws InvalidInput When not exactly one value is empty, or one is not greater than zero.
     * @throws DivisionByZero
     */
    public function calculate(Inputs $inputs): Result
    {
        [$unknown] = $inputs->missing([self::RESISTIVITY, self::LENGTH, self::CROSS_SECTION, self::RESISTANCE], 1);

        [$resistivity, $length, $section] = match ($unknown) {
            self::RESISTIVITY => $this->solveForResistivity($inputs),
            self::LENGTH => $this->solveForLength($inputs),
            self::CROSS_SECTION => $this->solveForCrossSection($inputs),
            default => [
                $inputs->positiveQuantity(self::RESISTIVITY, Resistivity::class),
                $inputs->positiveQuantity(self::LENGTH, Length::class),
                $inputs->positiveQuantity(self::CROSS_SECTION, Area::class),
            ],
        };

        return new Result([
            ResultValue::quantity(self::RESISTIVITY, $resistivity, FixedUnit::of(BaseUnit::OhmSquareMillimetrePerMetre)),
            ResultValue::quantity(self::LENGTH, $length, FixedUnit::of(BaseUnit::Metre)),
            ResultValue::quantity(self::CROSS_SECTION, $section, FixedUnit::of(BaseUnit::SquareMillimetre)),
            ResultValue::quantity(self::RESISTANCE, $resistivity->resistanceOf($length, $section), FixedUnit::of(BaseUnit::Ohm)),
        ]);
    }

    /**
     * ρ = R × A / L.
     *
     * @return array{Resistivity, Length, Area}
     *
     * @throws InvalidInput
     * @throws DivisionByZero
     */
    private function solveForResistivity(Inputs $inputs): array
    {
        $length = $inputs->positiveQuantity(self::LENGTH, Length::class);
        $section = $inputs->positiveQuantity(self::CROSS_SECTION, Area::class);
        $resistance = $inputs->positiveQuantity(self::RESISTANCE, Resistance::class);
        $perUnit = Resistivity::fromOhmMetres(1)->resistanceOf($length, $section);

        return [Resistivity::fromOhmMetres($resistance->ratioTo($perUnit)), $length, $section];
    }

    /**
     * L = R × A / ρ.
     *
     * @return array{Resistivity, Length, Area}
     *
     * @throws InvalidInput
     * @throws DivisionByZero
     */
    private function solveForLength(Inputs $inputs): array
    {
        $resistivity = $inputs->positiveQuantity(self::RESISTIVITY, Resistivity::class);
        $section = $inputs->positiveQuantity(self::CROSS_SECTION, Area::class);
        $resistance = $inputs->positiveQuantity(self::RESISTANCE, Resistance::class);
        $perMetre = $resistivity->resistanceOf(Length::fromMetres(1), $section);

        return [$resistivity, Length::fromMetres($resistance->ratioTo($perMetre)), $section];
    }

    /**
     * A = ρ × L / R.
     *
     * @return array{Resistivity, Length, Area}
     *
     * @throws InvalidInput
     * @throws DivisionByZero
     */
    private function solveForCrossSection(Inputs $inputs): array
    {
        $resistivity = $inputs->positiveQuantity(self::RESISTIVITY, Resistivity::class);
        $length = $inputs->positiveQuantity(self::LENGTH, Length::class);
        $resistance = $inputs->positiveQuantity(self::RESISTANCE, Resistance::class);
        $ofOneSquareMetre = $resistivity->resistanceOf($length, Area::fromSquareMetres(1));

        return [$resistivity, $length, Area::fromSquareMetres($ofOneSquareMetre->ratioTo($resistance))];
    }
}
