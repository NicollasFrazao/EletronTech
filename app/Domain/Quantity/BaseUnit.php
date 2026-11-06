<?php

declare(strict_types=1);

namespace App\Domain\Quantity;

/**
 * A unit without its prefix: the coherent SI units, and the other units the 2015 converter offered or the
 * calculators need (CGS units, ampere-hour, horsepower, inch, watt-hour, foot-candle...).
 *
 * Each one knows its exact size in the coherent SI unit of its dimension, written as a decimal or a fraction
 * so no conversion goes through a float. Since the 2019 SI the speed of light, the elementary charge and the
 * Avogadro constant are exact, so the electrostatic CGS units and the faraday are exact too. The BTU per hour
 * is the International Table BTU (1055.05585262 J) per 3600 s; the foot-candle is one lumen per square foot,
 * 1 / 0.09290304 lux. The metre of water is the pressure of one metre of water under standard gravity
 * (9806.65 Pa, the "metro de coluna d'água" of Brazilian plumbing); the pound-force per square inch is
 * 0.45359237 kg × 9.80665 m/s² over one square inch.
 */
enum BaseUnit: string
{
    case Volt = 'volt';
    case Abvolt = 'abvolt';
    case Statvolt = 'statvolt';
    case WattPerAmpere = 'watt_per_ampere';
    case Ampere = 'ampere';
    case Abampere = 'abampere';
    case Statampere = 'statampere';
    case CoulombPerSecond = 'coulomb_per_second';
    case Watt = 'watt';
    case Horsepower = 'horsepower';
    case MetricHorsepower = 'metric_horsepower';
    case BtuPerHour = 'btu_per_hour';
    case VoltAmpere = 'volt_ampere';
    case Ohm = 'ohm';
    case Abohm = 'abohm';
    case Statohm = 'statohm';
    case VoltPerAmpere = 'volt_per_ampere';
    case Siemens = 'siemens';
    case Mho = 'mho';
    case AmperePerVolt = 'ampere_per_volt';
    case Farad = 'farad';
    case Abfarad = 'abfarad';
    case Statfarad = 'statfarad';
    case Henry = 'henry';
    case Abhenry = 'abhenry';
    case Stathenry = 'stathenry';
    case WeberPerAmpere = 'weber_per_ampere';
    case Coulomb = 'coulomb';
    case Abcoulomb = 'abcoulomb';
    case Statcoulomb = 'statcoulomb';
    case AmpereHour = 'ampere_hour';
    case ElementaryCharge = 'elementary_charge';
    case Faraday = 'faraday';
    case Hertz = 'hertz';
    case Metre = 'metre';
    case Inch = 'inch';
    case Foot = 'foot';
    case Yard = 'yard';
    case Mile = 'mile';
    case SquareMillimetre = 'square_millimetre';
    case SquareCentimetre = 'square_centimetre';
    case SquareMetre = 'square_metre';
    case Hectare = 'hectare';
    case SquareKilometre = 'square_kilometre';
    case SquareInch = 'square_inch';
    case SquareFoot = 'square_foot';
    case VoltAmpereReactive = 'volt_ampere_reactive';
    case Weber = 'weber';
    case Maxwell = 'maxwell';
    case Joule = 'joule';
    case WattHour = 'watt_hour';
    case Second = 'second';
    case Minute = 'minute';
    case Hour = 'hour';
    case Day = 'day';
    case Lumen = 'lumen';
    case Lux = 'lux';
    case FootCandle = 'foot_candle';
    case CubicCentimetre = 'cubic_centimetre';
    case Litre = 'litre';
    case CubicMetre = 'cubic_metre';
    case Pascal = 'pascal';
    case Bar = 'bar';
    case Atmosphere = 'atmosphere';
    case MetreOfWater = 'metre_of_water';
    case PoundForcePerSquareInch = 'pound_force_per_square_inch';
    case MetrePerSecond = 'metre_per_second';
    case KilometrePerHour = 'kilometre_per_hour';
    case KilogramPerCubicMetre = 'kilogram_per_cubic_metre';
    case GramPerCubicCentimetre = 'gram_per_cubic_centimetre';
    case OhmMetre = 'ohm_metre';
    case OhmSquareMillimetrePerMetre = 'ohm_square_millimetre_per_metre';

    /**
     * Prefixes from nano to giga, as the 2015 converter offered for volt, ampere, ohm, siemens and henry.
     */
    private const array NANO_TO_GIGA = [
        Prefix::Nano, Prefix::Micro, Prefix::Milli, Prefix::None, Prefix::Kilo, Prefix::Mega, Prefix::Giga,
    ];

    /**
     * The quantity this unit measures.
     */
    public function dimension(): Dimension
    {
        return match ($this) {
            self::Volt, self::Abvolt, self::Statvolt, self::WattPerAmpere => Dimension::Voltage,
            self::Ampere, self::Abampere, self::Statampere, self::CoulombPerSecond => Dimension::Current,
            self::Watt, self::Horsepower, self::MetricHorsepower, self::BtuPerHour => Dimension::Power,
            self::VoltAmpere => Dimension::ApparentPower,
            self::Ohm, self::Abohm, self::Statohm, self::VoltPerAmpere => Dimension::Resistance,
            self::Siemens, self::Mho, self::AmperePerVolt => Dimension::Conductance,
            self::Farad, self::Abfarad, self::Statfarad => Dimension::Capacitance,
            self::Henry, self::Abhenry, self::Stathenry, self::WeberPerAmpere => Dimension::Inductance,
            self::Coulomb, self::Abcoulomb, self::Statcoulomb, self::AmpereHour,
            self::ElementaryCharge, self::Faraday => Dimension::Charge,
            self::Hertz => Dimension::Frequency,
            self::Metre, self::Inch, self::Foot, self::Yard, self::Mile => Dimension::Length,
            self::SquareMillimetre, self::SquareCentimetre, self::SquareMetre, self::Hectare,
            self::SquareKilometre, self::SquareInch, self::SquareFoot => Dimension::Area,
            self::VoltAmpereReactive => Dimension::ReactivePower,
            self::Weber, self::Maxwell => Dimension::MagneticFlux,
            self::Joule, self::WattHour => Dimension::Energy,
            self::Second, self::Minute, self::Hour, self::Day => Dimension::Duration,
            self::Lumen => Dimension::LuminousFlux,
            self::Lux, self::FootCandle => Dimension::Illuminance,
            self::CubicCentimetre, self::Litre, self::CubicMetre => Dimension::Volume,
            self::Pascal, self::Bar, self::Atmosphere, self::MetreOfWater,
            self::PoundForcePerSquareInch => Dimension::Pressure,
            self::MetrePerSecond, self::KilometrePerHour => Dimension::Velocity,
            self::KilogramPerCubicMetre, self::GramPerCubicCentimetre => Dimension::Density,
            self::OhmMetre, self::OhmSquareMillimetrePerMetre => Dimension::Resistivity,
        };
    }

    /**
     * How many coherent SI units of its dimension one of this unit is, as an exact decimal or fraction.
     */
    public function sizeInCoherentUnit(): string
    {
        return match ($this) {
            self::Volt, self::WattPerAmpere, self::Ampere, self::CoulombPerSecond, self::Watt, self::VoltAmpere,
            self::Ohm, self::VoltPerAmpere, self::Siemens, self::Mho, self::AmperePerVolt, self::Farad,
            self::Henry, self::WeberPerAmpere, self::Coulomb, self::Hertz, self::Metre, self::SquareMetre,
            self::VoltAmpereReactive, self::Weber, self::Joule, self::Second, self::Lumen, self::Lux,
            self::CubicMetre, self::Pascal, self::MetrePerSecond, self::KilogramPerCubicMetre, self::OhmMetre => '1',
            self::Abvolt => '0.00000001',
            self::Statvolt => '299.792458',
            self::Abampere, self::Abcoulomb => '10',
            self::Statampere, self::Statcoulomb => '1/2997924580',
            self::Horsepower => '745.69987158227022',
            self::MetricHorsepower => '735.49875',
            self::BtuPerHour => '52752792631/180000000000',
            self::Abohm, self::Abhenry => '0.000000001',
            self::Statohm, self::Stathenry => '898755178736.81764',
            self::Abfarad => '1000000000',
            self::Statfarad => '100000/89875517873681764',
            self::AmpereHour => '3600',
            self::ElementaryCharge => '1.602176634e-19',
            self::Faraday => '96485.3321233100184',
            self::Inch => '0.0254',
            self::Foot => '0.3048',
            self::Yard => '0.9144',
            self::Mile => '1609.344',
            self::SquareMillimetre => '0.000001',
            self::SquareCentimetre => '0.0001',
            self::Hectare => '10000',
            self::SquareKilometre => '1000000',
            self::SquareInch => '0.00064516',
            self::SquareFoot => '0.09290304',
            self::Maxwell => '0.00000001',
            self::WattHour, self::Hour => '3600',
            self::Minute => '60',
            self::Day => '86400',
            self::FootCandle => '1562500/145161',
            self::CubicCentimetre, self::OhmSquareMillimetrePerMetre => '0.000001',
            self::Litre => '0.001',
            self::Bar => '100000',
            self::Atmosphere => '101325',
            self::MetreOfWater => '9806.65',
            self::PoundForcePerSquareInch => '44482216152605/6451600000',
            self::KilometrePerHour => '5/18',
            self::GramPerCubicCentimetre => '1000',
        };
    }

    /**
     * The unit's symbol, without a prefix: "V", "Ω", "statC".
     */
    public function symbol(): string
    {
        return match ($this) {
            self::Volt => 'V',
            self::Abvolt => 'abV',
            self::Statvolt => 'statV',
            self::WattPerAmpere => 'W/A',
            self::Ampere => 'A',
            self::Abampere => 'abA',
            self::Statampere => 'statA',
            self::CoulombPerSecond => 'C/s',
            self::Watt => 'W',
            self::Horsepower => 'hp',
            self::MetricHorsepower => 'cv',
            self::BtuPerHour => 'BTU/h',
            self::VoltAmpere => 'VA',
            self::Ohm => 'Ω',
            self::Abohm => 'abΩ',
            self::Statohm => 'statΩ',
            self::VoltPerAmpere => 'V/A',
            self::Siemens => 'S',
            self::Mho => '℧',
            self::AmperePerVolt => 'A/V',
            self::Farad => 'F',
            self::Abfarad => 'abF',
            self::Statfarad => 'statF',
            self::Henry => 'H',
            self::Abhenry => 'abH',
            self::Stathenry => 'statH',
            self::WeberPerAmpere => 'Wb/A',
            self::Coulomb => 'C',
            self::Abcoulomb => 'abC',
            self::Statcoulomb => 'statC',
            self::AmpereHour => 'Ah',
            self::ElementaryCharge => 'e',
            self::Faraday => 'Fd',
            self::Hertz => 'Hz',
            self::Metre => 'm',
            self::Inch => 'in',
            self::Foot => 'ft',
            self::Yard => 'yd',
            self::Mile => 'mi',
            self::SquareMillimetre => 'mm²',
            self::SquareCentimetre => 'cm²',
            self::SquareMetre => 'm²',
            self::Hectare => 'ha',
            self::SquareKilometre => 'km²',
            self::SquareInch => 'in²',
            self::SquareFoot => 'ft²',
            self::VoltAmpereReactive => 'var',
            self::Weber => 'Wb',
            self::Maxwell => 'Mx',
            self::Joule => 'J',
            self::WattHour => 'Wh',
            self::Second => 's',
            self::Minute => 'min',
            self::Hour => 'h',
            self::Day => 'd',
            self::Lumen => 'lm',
            self::Lux => 'lx',
            self::FootCandle => 'fc',
            self::CubicCentimetre => 'cm³',
            self::Litre => 'L',
            self::CubicMetre => 'm³',
            self::Pascal => 'Pa',
            self::Bar => 'bar',
            self::Atmosphere => 'atm',
            self::MetreOfWater => 'mH₂O',
            self::PoundForcePerSquareInch => 'psi',
            self::MetrePerSecond => 'm/s',
            self::KilometrePerHour => 'km/h',
            self::KilogramPerCubicMetre => 'kg/m³',
            self::GramPerCubicCentimetre => 'g/cm³',
            self::OhmMetre => 'Ω·m',
            self::OhmSquareMillimetrePerMetre => 'Ω·mm²/m',
        };
    }

    /**
     * The unit's English name, without a prefix: "volt", "ampere-hour", "metric horsepower".
     */
    public function word(): string
    {
        return match ($this) {
            self::WattPerAmpere => 'watt per ampere',
            self::CoulombPerSecond => 'coulomb per second',
            self::MetricHorsepower => 'metric horsepower',
            self::BtuPerHour => 'BTU per hour',
            self::VoltAmpere => 'volt-ampere',
            self::VoltPerAmpere => 'volt per ampere',
            self::AmperePerVolt => 'ampere per volt',
            self::WeberPerAmpere => 'weber per ampere',
            self::AmpereHour => 'ampere-hour',
            self::VoltAmpereReactive => 'volt-ampere reactive',
            self::WattHour => 'watt-hour',
            self::FootCandle => 'foot-candle',
            self::Atmosphere => 'standard atmosphere',
            self::PoundForcePerSquareInch => 'pound-force per square inch',
            self::OhmMetre => 'ohm-metre',
            self::OhmSquareMillimetrePerMetre => 'ohm square millimetre per metre',
            default => str_replace('_', ' ', $this->value),
        };
    }

    /**
     * The prefixes this unit is offered with, smallest first; just Prefix::None for units that take none.
     *
     * @return non-empty-list<Prefix>
     */
    public function prefixes(): array
    {
        return match ($this) {
            self::Volt, self::Ampere, self::Ohm, self::Siemens, self::Henry => self::NANO_TO_GIGA,
            self::Watt => [Prefix::Milli, Prefix::None, Prefix::Kilo, Prefix::Mega, Prefix::Giga],
            self::VoltAmpere => [Prefix::None, Prefix::Kilo, Prefix::Mega],
            self::Farad => [Prefix::Pico, Prefix::Nano, Prefix::Micro, Prefix::Milli, Prefix::None],
            self::Coulomb => [Prefix::Nano, Prefix::Micro, Prefix::Milli, Prefix::None, Prefix::Kilo, Prefix::Mega],
            self::AmpereHour => [Prefix::Milli, Prefix::None],
            self::Hertz => [Prefix::None, Prefix::Kilo, Prefix::Mega, Prefix::Giga],
            self::Metre => [Prefix::Micro, Prefix::Milli, Prefix::Centi, Prefix::None, Prefix::Kilo],
            self::VoltAmpereReactive, self::Joule, self::WattHour => [Prefix::None, Prefix::Kilo, Prefix::Mega],
            self::Weber => [Prefix::Micro, Prefix::Milli, Prefix::None],
            self::Lumen, self::Lux => [Prefix::None, Prefix::Kilo],
            self::Litre => [Prefix::Milli, Prefix::None],
            self::Pascal => [Prefix::None, Prefix::Kilo, Prefix::Mega],
            default => [Prefix::None],
        };
    }
}
