<?php

declare(strict_types=1);

namespace App\Domain\Quantity;

/**
 * A power factor outside (0, 1].
 */
final class PowerFactorOutOfRange extends QuantityError
{
    public function __construct(string $value)
    {
        parent::__construct("A power factor is greater than 0 and at most 1; got {$value}.");
    }
}
