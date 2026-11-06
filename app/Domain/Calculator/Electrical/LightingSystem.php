<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Electrical;

/**
 * How the luminaires send their light: straight down to the work plane, up to the ceiling, or both.
 */
enum LightingSystem: string
{
    case Direct = 'direct';
    case Diffuse = 'diffuse';
    case Indirect = 'indirect';
    case SemiDirect = 'semi_direct';
    case SemiIndirect = 'semi_indirect';

    /**
     * Whether most of the light reaches the work plane after the ceiling reflects it; the room index of such a
     * system is measured from the ceiling, and the luminaires' suspension does not count.
     */
    public function isMostlyIndirect(): bool
    {
        return $this === self::Indirect || $this === self::SemiIndirect;
    }
}
