<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Electrical;

/**
 * How two resistors are connected: one after the other, or side by side across the same two points.
 */
enum ResistorConnection: string
{
    case Series = 'series';
    case Parallel = 'parallel';
}
