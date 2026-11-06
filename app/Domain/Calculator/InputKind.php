<?php

declare(strict_types=1);

namespace App\Domain\Calculator;

/**
 * What kind of value an input takes.
 */
enum InputKind: string
{
    /** A number with a unit of one dimension, such as a length in metres or feet. */
    case Quantity = 'quantity';

    /** A pure number, such as a power factor or a count of turns. */
    case Number = 'number';

    /** One option of a fixed list, such as a room type. */
    case Choice = 'choice';
}
