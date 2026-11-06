<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Electrical;

/**
 * The reflectances of the ceiling, the walls and the work plane, in percent, as the columns of the utilisation
 * factor table: "80_50_30" is a ceiling reflecting 80%, walls 50% and a work plane 30%.
 */
enum SurfaceReflectances: string
{
    case Ceiling80Walls80Plane30 = '80_80_30';
    case Ceiling80Walls50Plane30 = '80_50_30';
    case Ceiling80Walls30Plane30 = '80_30_30';
    case Ceiling50Walls50Plane30 = '50_50_30';
    case Ceiling50Walls30Plane30 = '50_30_30';
    case Ceiling70Walls70Plane20 = '70_70_20';
    case Ceiling70Walls50Plane20 = '70_50_20';
    case Ceiling70Walls30Plane20 = '70_30_20';
    case Ceiling80Walls80Plane10 = '80_80_10';
    case Ceiling80Walls50Plane10 = '80_50_10';
    case Ceiling80Walls30Plane10 = '80_30_10';
    case Ceiling50Walls50Plane10 = '50_50_10';
    case Ceiling50Walls30Plane10 = '50_30_10';
    case Ceiling30Walls30Plane10 = '30_30_10';
}
