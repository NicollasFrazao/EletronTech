<?php

declare(strict_types=1);

namespace App\Domain\Calculator;

use App\Domain\Quantity\Unit;
use BackedEnum;

/**
 * One input of a calculator's schema: its name, the kind of value it takes and whether it may be left empty.
 */
final readonly class InputField
{
    /**
     * @param  Unit|null  $defaultUnit  The unit a quantity is read in when none is given; null for other kinds.
     * @param  list<string>  $options  The identifiers a choice accepts; empty for other kinds.
     */
    private function __construct(
        public string $name,
        public bool $isRequired,
        public ?Unit $defaultUnit,
        public array $options,
    ) {}

    /**
     * A required quantity, read in the default unit unless the caller names another unit of its dimension.
     */
    public static function quantity(string $name, Unit $defaultUnit): self
    {
        return new self($name, true, $defaultUnit, []);
    }

    /**
     * A required pure number.
     */
    public static function number(string $name): self
    {
        return new self($name, true, null, []);
    }

    /**
     * A required choice among the cases of a string-backed enum.
     *
     * @param  non-empty-list<BackedEnum>  $cases
     */
    public static function choice(string $name, array $cases): self
    {
        $options = array_map(static fn (BackedEnum $case): string => (string) $case->value, $cases);

        return new self($name, true, null, $options);
    }

    /**
     * The same input, allowed to be left empty.
     */
    public function optional(): self
    {
        return new self($this->name, false, $this->defaultUnit, $this->options);
    }

    /**
     * The kind of value the input takes: a quantity has a default unit, a choice has options.
     */
    public function kind(): InputKind
    {
        if ($this->defaultUnit instanceof Unit) {
            return InputKind::Quantity;
        }

        return $this->options === [] ? InputKind::Number : InputKind::Choice;
    }
}
