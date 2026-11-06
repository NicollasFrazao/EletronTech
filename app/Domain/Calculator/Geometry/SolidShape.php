<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Geometry;

/**
 * The solids the surface area and volume tool knows, with the dimensions each one is given by.
 */
enum SolidShape: string
{
    /** Edge. */
    case Cube = 'cube';

    /** Edge of the square base, and height. */
    case SquarePyramid = 'square_pyramid';

    /** Edge. */
    case RegularTetrahedron = 'regular_tetrahedron';

    /** Radius of the base, and height. */
    case Cone = 'cone';

    /** Radius of the base, and height. */
    case Cylinder = 'cylinder';
}
