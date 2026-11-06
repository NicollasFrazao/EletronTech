<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Electrical;

/**
 * The number of turns of a coil: a whole number, at least one.
 */
final readonly class TurnCount
{
    /**
     * @param  positive-int  $turns
     */
    private function __construct(
        private int $turns,
    ) {}

    /**
     * The count of a whole number of turns; null when it is below one.
     */
    public static function tryOf(int $turns): ?self
    {
        return $turns >= 1 ? new self($turns) : null;
    }

    /**
     * The number of turns.
     *
     * @return positive-int
     */
    public function value(): int
    {
        return $this->turns;
    }
}
