<?php

declare(strict_types=1);

namespace App\Domain\Calculator;

/**
 * Why an input was refused; the edges translate each case into a message for the person.
 */
enum InputProblem: string
{
    case Missing = 'missing';
    case NotANumber = 'not_a_number';
    case UnknownUnit = 'unknown_unit';
    case WrongUnit = 'wrong_unit';
    case WrongKind = 'wrong_kind';
    case UnknownOption = 'unknown_option';
    case NotPositive = 'not_positive';
    case Negative = 'negative';
    case NotWhole = 'not_whole';
    case OutOfRange = 'out_of_range';
    case TooLarge = 'too_large';
    case NotRepresentable = 'not_representable';
    case WrongNumberOfValues = 'wrong_number_of_values';

    /**
     * A short English description, for logs and exception messages.
     */
    public function describe(): string
    {
        return match ($this) {
            self::Missing => 'a value is required',
            self::NotANumber => 'the value is not a number',
            self::UnknownUnit => 'there is no such unit',
            self::WrongUnit => 'the unit measures another quantity',
            self::WrongKind => 'the value is of the wrong kind',
            self::UnknownOption => 'the value is not one of the options',
            self::NotPositive => 'the value must be greater than zero',
            self::Negative => 'the value cannot be negative',
            self::NotWhole => 'the value must be a whole number',
            self::OutOfRange => 'the value is outside the range the calculation accepts',
            self::TooLarge => 'the value is beyond the largest the tables cover',
            self::NotRepresentable => 'the value cannot be written this way',
            self::WrongNumberOfValues => 'the number of values filled in does not match what the calculation solves',
        };
    }
}
