<?php

declare(strict_types=1);

namespace App\Domain\Quantity;

/**
 * A quantity was divided by zero, or the reciprocal of a zero quantity was asked for.
 */
final class DivisionByZero extends QuantityError
{
    public function __construct()
    {
        parent::__construct('A quantity cannot be divided by zero.');
    }
}
