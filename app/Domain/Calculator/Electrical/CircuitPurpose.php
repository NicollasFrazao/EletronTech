<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Electrical;

/**
 * What a circuit feeds, which sets the smallest conductor NBR 5410 allows for it (table 47).
 */
enum CircuitPurpose: string
{
    /** Light points. */
    case Lighting = 'lighting';

    /** Outlets and appliances ("circuitos de força"). */
    case Power = 'power';
}
