<?php

declare(strict_types=1);

namespace App\Domain\Quantity;

use Brick\Math\BigDecimal;
use Brick\Math\BigNumber;
use Brick\Math\BigRational;
use InvalidArgumentException;

/**
 * A physical quantity with an exact value, expressible in any unit of its dimension, and the arithmetic every
 * quantity shares: comparison, sums and scaling by a pure number.
 *
 * The value is kept as an exact fraction in the coherent SI unit of the dimension, so a conversion or a sum
 * never drifts; rounding happens only in rounded(). A quantity does not refuse negative values: a difference of
 * two lengths is a negative length, and whether a negative input makes sense is a rule of the calculator that
 * receives it. Each kind of quantity is a final subclass; the operations between kinds (a voltage times a
 * current is a power) live on the subclasses, so a combination that makes no sense has no method.
 */
abstract readonly class Quantity
{
    /**
     * @param  BigRational  $value  The value in the coherent SI unit of the dimension.
     */
    final protected function __construct(
        protected BigRational $value,
    ) {}

    /**
     * The dimension every value of this quantity has.
     */
    abstract public static function dimension(): Dimension;

    /**
     * The quantity of a value given in a unit of its dimension.
     *
     * @throws IncompatibleUnit
     *
     * @api
     */
    public static function of(BigNumber|int|string $value, Unit $unit): static
    {
        self::assertMeasures($unit);

        return new static($unit->toCoherentUnit($value));
    }

    /**
     * A quantity of exactly zero.
     *
     * @api
     */
    public static function zero(): static
    {
        return new static(BigRational::zero());
    }

    /**
     * The exact value expressed in a unit of this quantity's dimension.
     *
     * @throws IncompatibleUnit
     */
    public function in(Unit $unit): BigRational
    {
        self::assertMeasures($unit);

        return $this->value->dividedBy($unit->size());
    }

    /**
     * The value expressed in a unit and rounded for display.
     *
     * @throws IncompatibleUnit
     *
     * @api
     */
    public function rounded(Unit $unit, Precision $precision): BigDecimal
    {
        return $precision->apply($this->in($unit));
    }

    /**
     * The sum of two quantities of the same kind.
     *
     * @param  static  $other
     */
    public function plus(self $other): static
    {
        return new static($this->value->plus($this->valueOfSameKind($other)));
    }

    /**
     * The difference of two quantities of the same kind; negative when the other is larger.
     *
     * @param  static  $other
     */
    public function minus(self $other): static
    {
        return new static($this->value->minus($this->valueOfSameKind($other)));
    }

    /**
     * The quantity scaled by a pure number.
     */
    public function multipliedBy(BigNumber|int|string $factor): static
    {
        return new static($this->value->multipliedBy($factor));
    }

    /**
     * The quantity divided by a pure number.
     *
     * @throws DivisionByZero
     */
    public function dividedBy(BigNumber|int|string $divisor): static
    {
        return new static(self::quotient($this->value, BigRational::of($divisor)));
    }

    /**
     * How many times the other quantity fits in this one, as a pure number.
     *
     * @param  static  $other
     *
     * @throws DivisionByZero
     */
    public function ratioTo(self $other): BigRational
    {
        return self::quotient($this->value, $this->valueOfSameKind($other));
    }

    /**
     * Whether both quantities are exactly equal, whatever units they were created in.
     *
     * @param  static  $other
     *
     * @api
     */
    public function isEqualTo(self $other): bool
    {
        return $this->compare($other) === 0;
    }

    /**
     * Whether this quantity is larger than the other.
     *
     * @param  static  $other
     */
    public function isGreaterThan(self $other): bool
    {
        return $this->compare($other) > 0;
    }

    /**
     * Whether this quantity is smaller than the other.
     *
     * @param  static  $other
     */
    public function isLessThan(self $other): bool
    {
        return $this->compare($other) < 0;
    }

    /**
     * Whether the value is exactly zero.
     */
    public function isZero(): bool
    {
        return $this->value->isZero();
    }

    /**
     * Whether the value is below zero.
     */
    public function isNegative(): bool
    {
        return $this->value->isNegative();
    }

    /**
     * The exact quotient of two values.
     *
     * @throws DivisionByZero
     */
    protected static function quotient(BigRational $dividend, BigRational $divisor): BigRational
    {
        if ($divisor->isZero()) {
            throw new DivisionByZero;
        }

        return $dividend->dividedBy($divisor);
    }

    /**
     * Refuses a unit of another dimension.
     *
     * @throws IncompatibleUnit
     */
    private static function assertMeasures(Unit $unit): void
    {
        if ($unit->dimension() !== static::dimension()) {
            throw IncompatibleUnit::forDimension($unit, static::dimension());
        }
    }

    /**
     * -1, 0 or 1 as this quantity is smaller than, equal to or larger than the other.
     */
    private function compare(self $other): int
    {
        return $this->value->compareTo($this->valueOfSameKind($other));
    }

    /**
     * The other quantity's value, after making sure it is of the same kind as this one.
     *
     * PHPStan already refuses a voltage plus a current (the parameters are `static`); this check keeps the
     * mistake from going unnoticed in code it does not analyse.
     */
    private function valueOfSameKind(self $other): BigRational
    {
        if ($other::class !== static::class) {
            throw new InvalidArgumentException(sprintf('A %s cannot be combined with a %s.', static::class, $other::class));
        }

        return $other->value;
    }
}
