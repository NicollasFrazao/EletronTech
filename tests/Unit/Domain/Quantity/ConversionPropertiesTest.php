<?php

declare(strict_types=1);

use App\Domain\Quantity\Current;
use App\Domain\Quantity\Dimension;
use App\Domain\Quantity\Length;
use App\Domain\Quantity\Precision;
use App\Domain\Quantity\Quantities;
use App\Domain\Quantity\UnitCatalogue;
use App\Domain\Quantity\Voltage;
use Brick\Math\BigRational;
use Eris\Generator;
use Eris\Generators;
use Tests\Support\Property;

/**
 * Decimal numbers from about 10^-21 to 10^24, positive and negative, as a person could type them.
 */
function decimals(): Generator
{
    return Generators::map(
        static fn (array $parts): BigRational => BigRational::of($parts[0])
            ->multipliedBy(BigRational::ten()->power($parts[1])),
        Generators::tuple(Generators::choose(-999_999_999, 999_999_999), Generators::choose(-30, 15)),
    );
}

/**
 * Non-zero decimal numbers.
 */
function nonZeroDecimals(): Generator
{
    return Generators::suchThat(static fn (BigRational $value): bool => ! $value->isZero(), decimals());
}

/**
 * Three units of one dimension, drawn from the whole catalogue.
 */
function unitsOfOneDimension(): Generator
{
    $catalogue = new UnitCatalogue;

    return Generators::bind(
        Generators::elements(Dimension::cases()),
        static function (Dimension $dimension) use ($catalogue): Generator {
            $units = $catalogue->ofDimension($dimension);

            return Generators::tuple(
                Generators::elements($units),
                Generators::elements($units),
                Generators::elements($units),
            );
        },
    );
}

it('gets back the exact value after converting to any unit of the dimension and back', function (): void {
    Property::check(500, [decimals(), unitsOfOneDimension()], function (BigRational $value, array $units): void {
        [$from, $to] = $units;
        $there = Quantities::of($value, $from)->in($to);

        expect(Quantities::of($there, $to)->in($from)->isEqualTo($value))->toBeTrue();
    });
});

it('converts through an intermediate unit to the same value as directly', function (): void {
    Property::check(300, [decimals(), unitsOfOneDimension()], function (BigRational $value, array $units): void {
        [$from, $via, $to] = $units;
        $direct = Quantities::of($value, $from)->in($to);
        $indirect = Quantities::of(Quantities::of($value, $from)->in($via), $via)->in($to);

        expect($indirect->isEqualTo($direct))->toBeTrue();
    });
});

it('converts a sum to the sum of the conversions', function (): void {
    Property::check(300, [decimals(), decimals(), unitsOfOneDimension()], function (
        BigRational $first,
        BigRational $second,
        array $units,
    ): void {
        [$from, $to] = $units;
        $sum = Quantities::of($first->plus($second), $from)->in($to);
        $sumOfConversions = Quantities::of($first, $from)->in($to)->plus(Quantities::of($second, $from)->in($to));

        expect($sum->isEqualTo($sumOfConversions))->toBeTrue();
    });
});

it('rounds a displayed value within half a unit of its last decimal place', function (): void {
    Property::check(300, [decimals(), Generators::choose(0, 12)], function (BigRational $value, int $places): void {
        $shown = Precision::decimalPlaces($places)->apply($value);
        $halfUnit = BigRational::of('1/2')->multipliedBy(BigRational::ten()->power(-$places));

        expect($shown->getScale())->toBe($places)
            ->and($shown->toBigRational()->minus($value)->abs()->isLessThanOrEqualTo($halfUnit))->toBeTrue();
    });
});

it('leaves a value that already fits the significant digits unchanged, and rounding again changes nothing', function (): void {
    Property::check(300, [decimals(), Generators::choose(1, 15)], function (BigRational $value, int $digits): void {
        $precision = Precision::significantDigits($digits);
        $shown = $precision->apply($value);
        $digitsShown = $shown->strippedOfTrailingZeros()->getUnscaledValue()->abs()->toString();

        expect($precision->apply($shown)->isEqualTo($shown))->toBeTrue()
            ->and(strlen(ltrim($digitsShown, '0')) <= max($digits, strlen($shown->getIntegralPart()->abs()->toString())))
            ->toBeTrue();
    });
});

it("keeps Ohm's law and P = V × I consistent in both directions", function (): void {
    Property::check(300, [nonZeroDecimals(), nonZeroDecimals()], function (BigRational $volts, BigRational $amperes): void {
        $voltage = Voltage::fromVolts($volts);
        $current = Current::fromAmperes($amperes);

        expect($voltage->dividedByCurrent($current)->timesCurrent($current)->isEqualTo($voltage))->toBeTrue()
            ->and($voltage->timesCurrent($current)->dividedByVoltage($voltage)->isEqualTo($current))->toBeTrue();
    });
});

it('undoes a sum with a difference and an area with a division', function (): void {
    Property::check(300, [decimals(), nonZeroDecimals()], function (BigRational $first, BigRational $second): void {
        $length = Length::fromMetres($first);
        $width = Length::fromMetres($second);

        expect($length->plus($width)->minus($width)->isEqualTo($length))->toBeTrue()
            ->and($length->timesLength($width)->dividedByLength($width)->isEqualTo($length))->toBeTrue();
    });
});
