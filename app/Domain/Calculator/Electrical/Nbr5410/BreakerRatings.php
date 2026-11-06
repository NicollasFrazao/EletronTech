<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Electrical\Nbr5410;

use App\Domain\Quantity\Current;

/**
 * The rated currents of circuit breakers for household installations, the preferred values of IEC 60898-1
 * (ABNT NBR NM 60898 in Brazil).
 */
final class BreakerRatings
{
    /**
     * Rated currents in amperes, smallest first.
     *
     * @var non-empty-list<string>
     */
    private const array RATINGS = ['6', '8', '10', '13', '16', '20', '25', '32', '40', '50', '63', '80', '100', '125'];

    /**
     * The smallest rated current not below the design current (I_B ≤ I_n, NBR 5410 section 5.3.4.1); null when
     * the design current is above the largest rating.
     */
    public static function smallestAtLeast(Current $designCurrent): ?Current
    {
        foreach (self::RATINGS as $rating) {
            $rated = Current::fromAmperes($rating);

            if (! $rated->isLessThan($designCurrent)) {
                return $rated;
            }
        }

        return null;
    }
}
