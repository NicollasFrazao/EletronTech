<?php

declare(strict_types=1);

namespace App\Domain\Quantity;

use Brick\Math\BigNumber;
use Brick\Math\BigRational;

/**
 * A unit of measurement: a base unit with an optional SI prefix, such as kilowatt or milliampere-hour.
 */
final readonly class Unit
{
    private function __construct(
        private BaseUnit $base,
        private Prefix $prefix,
    ) {}

    /**
     * The unit made of a base unit and one of the prefixes it is offered with.
     *
     * @throws UnknownUnit When the base unit is not offered with that prefix (a kilohectare, say).
     */
    public static function of(BaseUnit $base, Prefix $prefix = Prefix::None): self
    {
        if (! in_array($prefix, $base->prefixes(), true)) {
            throw UnknownUnit::withId($prefix->word().$base->value);
        }

        return new self($base, $prefix);
    }

    /**
     * Every unit the base unit is offered as, one per prefix, smallest first.
     *
     * @return non-empty-list<self>
     */
    public static function allOf(BaseUnit $base): array
    {
        return array_map(static fn (Prefix $prefix): self => new self($base, $prefix), $base->prefixes());
    }

    /**
     * The stable identifier of the unit, for forms and URLs: "kilowatt", "milliampere_hour".
     */
    public function id(): string
    {
        return $this->prefix->word().$this->base->value;
    }

    /**
     * The unit's symbol with its prefix: "kW", "mAh", "µF".
     */
    public function symbol(): string
    {
        return $this->prefix->symbol().$this->base->symbol();
    }

    /**
     * The unit's English name with its prefix: "kilowatt", "milliampere-hour".
     */
    public function name(): string
    {
        return $this->prefix->word().$this->base->word();
    }

    /**
     * The quantity this unit measures.
     */
    public function dimension(): Dimension
    {
        return $this->base->dimension();
    }

    /**
     * How many coherent SI units one of this unit is, exactly: 1000 for the kilowatt, 3.6 for the milliampere-hour.
     */
    public function size(): BigRational
    {
        return BigRational::of($this->base->sizeInCoherentUnit())
            ->multipliedBy(BigRational::ten()->power($this->prefix->value));
    }

    /**
     * Expresses a value given in this unit in the coherent SI unit of its dimension, exactly.
     */
    public function toCoherentUnit(BigNumber|int|string $value): BigRational
    {
        return BigRational::of($value)->multipliedBy($this->size());
    }

    /**
     * Whether both are the same unit.
     *
     * @api
     */
    public function isEqualTo(self $other): bool
    {
        return $this->base === $other->base && $this->prefix === $other->prefix;
    }
}
