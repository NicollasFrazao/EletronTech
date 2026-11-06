<?php

declare(strict_types=1);

namespace App\Domain\Quantity;

/**
 * Every unit the application offers, found by its identifier or listed by dimension, smallest first.
 */
final readonly class UnitCatalogue
{
    /**
     * @var array<string, Unit> Keyed by unit identifier.
     */
    private array $units;

    public function __construct()
    {
        $units = [];

        foreach (BaseUnit::cases() as $base) {
            foreach (Unit::allOf($base) as $unit) {
                $units[$unit->id()] = $unit;
            }
        }

        $this->units = $units;
    }

    /**
     * The unit with this identifier.
     *
     * @throws UnknownUnit
     */
    public function find(string $id): Unit
    {
        return $this->units[$id] ?? throw UnknownUnit::withId($id);
    }

    /**
     * The units of one dimension, from the smallest to the largest.
     *
     * @return list<Unit>
     */
    public function ofDimension(Dimension $dimension): array
    {
        $units = array_values(array_filter(
            $this->units,
            static fn (Unit $unit): bool => $unit->dimension() === $dimension,
        ));

        usort($units, static fn (Unit $first, Unit $second): int => $first->size()->compareTo($second->size()));

        return $units;
    }
}
