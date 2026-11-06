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
     * The unit a quantity is read in when none is given; null for other kinds.
     */
    public ?Unit $defaultUnit;

    /**
     * The identifiers a choice accepts; empty for other kinds.
     *
     * @var list<string>
     */
    public array $options;

    /**
     * @param  Unit|list<string>|null  $accepts  A quantity's default unit, a choice's options, or nothing.
     */
    private function __construct(
        public string $name,
        public bool $isRequired,
        private InputKind $kind,
        Unit|array|null $accepts = null,
    ) {
        $this->defaultUnit = $accepts instanceof Unit ? $accepts : null;
        $this->options = is_array($accepts) ? $accepts : [];
    }

    /**
     * A required quantity, read in the default unit unless the caller names another unit of its dimension.
     */
    public static function quantity(string $name, Unit $defaultUnit): self
    {
        return new self($name, true, InputKind::Quantity, $defaultUnit);
    }

    /**
     * A required pure number.
     */
    public static function number(string $name): self
    {
        return new self($name, true, InputKind::Number);
    }

    /**
     * A required choice among the cases of a string-backed enum.
     *
     * @param  non-empty-list<BackedEnum>  $cases
     */
    public static function choice(string $name, array $cases): self
    {
        $options = array_map(static fn (BackedEnum $case): string => (string) $case->value, $cases);

        return new self($name, true, InputKind::Choice, $options);
    }

    /**
     * A required text, handed to the calculator as typed; the calculator reads it.
     */
    public static function text(string $name): self
    {
        return new self($name, true, InputKind::Text);
    }

    /**
     * The same input, allowed to be left empty.
     */
    public function optional(): self
    {
        return new self($this->name, false, $this->kind, $this->defaultUnit ?? $this->options);
    }

    /**
     * The kind of value the input takes.
     */
    public function kind(): InputKind
    {
        return $this->kind;
    }
}
