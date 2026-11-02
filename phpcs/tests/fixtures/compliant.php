<?php

declare(strict_types=1);

namespace Fixture;

/**
 * A class with every public member documented.
 */
#[\Attribute]
final readonly class Documented
{
    public function __construct(private int $value)
    {
    }

    /**
     * Returns the value given to the constructor.
     */
    public function value(): int
    {
        return $this->value;
    }

    /**
     * {@inheritDoc}
     */
    public function __toString(): string
    {
        return (string) $this->value;
    }
}
