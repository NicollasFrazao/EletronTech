<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Electrical;

/**
 * How many hours of use pass between two cleanings of the luminaires.
 */
enum MaintenanceInterval: string
{
    case Hours2500 = '2500_hours';
    case Hours5000 = '5000_hours';
    case Hours7500 = '7500_hours';
}
