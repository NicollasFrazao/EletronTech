<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Geometry;

/**
 * The flat shapes the area and perimeter tool knows, with the dimensions each one is given by.
 */
enum PlaneShape: string
{
    /** Length and width. */
    case Rectangle = 'rectangle';

    /** Side. */
    case Square = 'square';

    /** Radius. */
    case Circle = 'circle';

    /** Its three sides. */
    case Triangle = 'triangle';

    /** Its two diagonals. */
    case Rhombus = 'rhombus';

    /** Base, slanted side and height. */
    case Parallelogram = 'parallelogram';

    /** Its two parallel bases and its two legs. */
    case Trapezoid = 'trapezoid';

    /** Side. */
    case RegularPentagon = 'regular_pentagon';

    /** Side. */
    case RegularHexagon = 'regular_hexagon';
}
