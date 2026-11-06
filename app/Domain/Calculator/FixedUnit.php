<?php

declare(strict_types=1);

namespace App\Domain\Calculator;

use App\Domain\Quantity\BaseUnit;
use App\Domain\Quantity\Prefix;
use App\Domain\Quantity\Unit;
use App\Domain\Quantity\UnknownUnit;
use LogicException;

/**
 * A unit a calculator names in its own code, such as the unit an input is read in or a result is shown in.
 *
 * Such a unit is written by the programmer, not typed by a person, so a prefix the base unit is not offered with
 * is a programming error, not a domain error.
 */
final class FixedUnit
{
    /**
     * The unit made of a base unit and one of the prefixes it is offered with.
     */
    public static function of(BaseUnit $base, Prefix $prefix = Prefix::None): Unit
    {
        try {
            return Unit::of($base, $prefix);
        } catch (UnknownUnit $exception) {
            throw new LogicException($exception->getMessage(), $exception->getCode(), previous: $exception);
        }
    }
}
