<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Electrical;

/**
 * The kinds of room the outlet count knows, as NBR 5410 groups them in section 9.5.2.2.
 */
enum RoomType: string
{
    case ServiceArea = 'service_area';
    case Bathroom = 'bathroom';
    case Pantry = 'pantry';
    case Kitchen = 'kitchen';
    case Garage = 'garage';
    case Laundry = 'laundry';
    case Bedroom = 'bedroom';
    case LivingRoom = 'living_room';
    case Attic = 'attic';
    case Basement = 'basement';
    case Veranda = 'veranda';
}
