<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Electrical;

use App\Domain\Calculator\RealNumbers;
use Brick\Math\BigRational;

/**
 * How a load is supplied: from one phase and the neutral, between two phases, or from three phases.
 *
 * The voltage given with it is the one across the load: phase to neutral for a single-phase load, phase to phase
 * for a two-phase or three-phase load.
 */
enum SupplySystem: string
{
    case SinglePhase = 'single_phase';
    case TwoPhase = 'two_phase';
    case ThreePhase = 'three_phase';

    /**
     * Conductors that carry the load current, as NBR 5410 counts them for the current-carrying capacity tables
     * (table 46): two for a single-phase or two-phase circuit, three for a balanced three-phase one.
     */
    private const array LOADED_CONDUCTORS = [
        'single_phase' => self::TWO_CONDUCTORS,
        'two_phase' => self::TWO_CONDUCTORS,
        'three_phase' => self::THREE_CONDUCTORS,
    ];

    private const int TWO_CONDUCTORS = 2;

    private const int THREE_CONDUCTORS = 3;

    /**
     * The factor between the apparent power and V × I: 1 for one or two phases, √3 for three phases with the
     * phase-to-phase voltage (S = √3 × V × I).
     */
    public function lineFactor(): BigRational
    {
        if ($this !== self::ThreePhase) {
            return BigRational::one();
        }

        return RealNumbers::squareRoot(BigRational::of(self::THREE_CONDUCTORS));
    }

    /**
     * How many conductors carry the load current, the column of the capacity table to read.
     *
     * @return 2|3
     */
    public function loadedConductors(): int
    {
        return self::LOADED_CONDUCTORS[$this->value];
    }
}
