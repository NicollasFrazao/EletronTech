<?php

declare(strict_types=1);

namespace App\Domain\Calculator;

use App\Domain\Quantity\IncompatibleUnit;
use App\Domain\Quantity\Quantity;
use App\Domain\Quantity\Unit;
use Brick\Math\BigNumber;
use Brick\Math\BigRational;
use LogicException;

/**
 * One named value of a calculation's result: an exact number in the unit it is shown in, a pure number, or a
 * text such as a colour name.
 */
final readonly class ResultValue
{
    /**
     * @param  BigRational|string  $value  The exact number, in $unit when there is one, or the text.
     */
    private function __construct(
        public string $name,
        public BigRational|string $value,
        public ?Unit $unit,
    ) {}

    /**
     * A quantity, kept exact and expressed in the unit it is shown in.
     */
    public static function quantity(string $name, Quantity $quantity, Unit $unit): self
    {
        try {
            return new self($name, $quantity->in($unit), $unit);
        } catch (IncompatibleUnit $exception) {
            $message = "The result \"{$name}\" is shown in a unit of another dimension.";

            throw new LogicException($message, $exception->getCode(), previous: $exception);
        }
    }

    /**
     * A pure number: a count, a ratio, a factor.
     */
    public static function number(string $name, BigNumber|int $number): self
    {
        return new self($name, BigRational::of($number), null);
    }

    /**
     * A text, such as the identifier of a colour band.
     */
    public static function text(string $name, string $text): self
    {
        return new self($name, $text, null);
    }
}
