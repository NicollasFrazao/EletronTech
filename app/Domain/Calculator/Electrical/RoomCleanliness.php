<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Electrical;

/**
 * How much dirt the room's air carries, which sets how fast the luminaires lose light.
 */
enum RoomCleanliness: string
{
    case Clean = 'clean';
    case Normal = 'normal';
    case Dirty = 'dirty';
}
