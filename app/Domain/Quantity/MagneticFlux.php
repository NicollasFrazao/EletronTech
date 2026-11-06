<?php

declare(strict_types=1);

namespace App\Domain\Quantity;

use Brick\Math\BigNumber;
use Brick\Math\BigRational;

/**
 * A magnetic flux, stored in webers.
 */
final readonly class MagneticFlux extends Quantity
{
    /**
     * The dimension every value of this quantity has.
     */
    public static function dimension(): Dimension
    {
        return Dimension::MagneticFlux;
    }

    /**
     * The magnetic flux of a value in webers.
     */
    public static function fromWebers(BigNumber|int|string $webers): self
    {
        return new self(BigRational::of($webers));
    }

    /**
     * The inductance of a coil whose turns all link this flux when a current flows through it (L = N × Φ / I),
     * for this flux already multiplied by the number of turns.
     *
     * @throws DivisionByZero
     */
    public function dividedByCurrent(Current $current): Inductance
    {
        return Inductance::fromHenries(self::quotient($this->value, $current->toAmperes()));
    }

    /**
     * The current that makes an inductance link this flux (I = N × Φ / L), for this flux already multiplied by the
     * number of turns.
     *
     * @throws DivisionByZero
     */
    public function dividedByInductance(Inductance $inductance): Current
    {
        return Current::fromAmperes(self::quotient($this->value, $inductance->toHenries()));
    }
}
