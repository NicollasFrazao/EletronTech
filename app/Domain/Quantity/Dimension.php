<?php

declare(strict_types=1);

namespace App\Domain\Quantity;

/**
 * The kind of physical quantity a value measures; only units of the same dimension convert into each other.
 */
enum Dimension: string
{
    case Voltage = 'voltage';
    case Current = 'current';
    case Power = 'power';
    case ApparentPower = 'apparent_power';
    case Resistance = 'resistance';
    case Conductance = 'conductance';
    case Capacitance = 'capacitance';
    case Inductance = 'inductance';
    case Charge = 'charge';
    case Frequency = 'frequency';
    case Length = 'length';
    case Area = 'area';
    case ReactivePower = 'reactive_power';
    case MagneticFlux = 'magnetic_flux';
    case Energy = 'energy';
    case Duration = 'duration';
    case LuminousFlux = 'luminous_flux';
    case Illuminance = 'illuminance';
}
