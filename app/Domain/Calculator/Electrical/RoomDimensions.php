<?php

declare(strict_types=1);

namespace App\Domain\Calculator\Electrical;

use App\Domain\Calculator\FixedUnit;
use App\Domain\Calculator\InputField;
use App\Domain\Calculator\Inputs;
use App\Domain\Calculator\InvalidInput;
use App\Domain\Quantity\Area;
use App\Domain\Quantity\BaseUnit;
use App\Domain\Quantity\Length;

/**
 * The floor of a rectangular room: its length and width, both greater than zero.
 */
final readonly class RoomDimensions
{
    private const string LENGTH = 'length';

    private const string WIDTH = 'width';

    private function __construct(
        private Length $length,
        private Length $width,
    ) {}

    /**
     * The two inputs a room's floor is read from, in metres by default.
     *
     * @return non-empty-list<InputField>
     */
    public static function fields(): array
    {
        $metre = FixedUnit::of(BaseUnit::Metre);

        return [InputField::quantity(self::LENGTH, $metre), InputField::quantity(self::WIDTH, $metre)];
    }

    /**
     * The room's floor, read from its two inputs.
     *
     * @throws InvalidInput
     */
    public static function from(Inputs $inputs): self
    {
        return new self(
            $inputs->positiveQuantity(self::LENGTH, Length::class),
            $inputs->positiveQuantity(self::WIDTH, Length::class),
        );
    }

    /**
     * The floor area (length × width).
     */
    public function area(): Area
    {
        return $this->length->timesLength($this->width);
    }

    /**
     * The sum of the length and the width, half the perimeter.
     */
    public function semiPerimeter(): Length
    {
        return $this->length->plus($this->width);
    }

    /**
     * The perimeter, 2 × (length + width).
     */
    public function perimeter(): Length
    {
        $semiPerimeter = $this->semiPerimeter();

        return $semiPerimeter->plus($semiPerimeter);
    }
}
