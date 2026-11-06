<?php

declare(strict_types=1);

use App\Domain\Quantity\BaseUnit;
use App\Domain\Quantity\Dimension;
use App\Domain\Quantity\Prefix;
use App\Domain\Quantity\Unit;
use App\Domain\Quantity\UnitCatalogue;
use App\Domain\Quantity\UnknownUnit;

it('names a prefixed unit by its prefix and base unit', function (): void {
    $unit = Unit::of(BaseUnit::AmpereHour, Prefix::Milli);

    expect($unit->id())->toBe('milliampere_hour')
        ->and($unit->name())->toBe('milliampere-hour')
        ->and($unit->symbol())->toBe('mAh')
        ->and($unit->dimension())->toBe(Dimension::Charge)
        ->and($unit->size()->toString())->toBe('18/5');
});

it('writes micro with the micro sign and ohm with omega', function (): void {
    expect(Unit::of(BaseUnit::Farad, Prefix::Micro)->symbol())->toBe('µF')
        ->and(Unit::of(BaseUnit::Ohm, Prefix::Kilo)->symbol())->toBe('kΩ');
});

it('refuses a prefix the base unit is not offered with', function (): void {
    Unit::of(BaseUnit::Hectare, Prefix::Kilo);
})->throws(UnknownUnit::class, 'There is no unit "kilohectare".');

it('compares units by base unit and prefix', function (): void {
    expect(Unit::of(BaseUnit::Watt, Prefix::Kilo)->isEqualTo(Unit::of(BaseUnit::Watt, Prefix::Kilo)))->toBeTrue()
        ->and(Unit::of(BaseUnit::Watt, Prefix::Kilo)->isEqualTo(Unit::of(BaseUnit::Watt)))->toBeFalse();
});

it('finds every unit by its identifier', function (): void {
    $catalogue = new UnitCatalogue;

    expect($catalogue->find('kilowatt')->isEqualTo(Unit::of(BaseUnit::Watt, Prefix::Kilo)))->toBeTrue()
        ->and($catalogue->find('square_millimetre')->symbol())->toBe('mm²');
});

it('rejects an identifier no unit has', function (): void {
    (new UnitCatalogue)->find('furlong');
})->throws(UnknownUnit::class, 'There is no unit "furlong".');

it('lists the units of a dimension from the smallest to the largest', function (): void {
    $symbols = array_map(
        static fn (Unit $unit): string => $unit->symbol(),
        (new UnitCatalogue)->ofDimension(Dimension::Length),
    );

    expect($symbols)->toBe(['µm', 'mm', 'cm', 'in', 'ft', 'yd', 'm', 'km', 'mi']);
});

it('offers every dimension at least two units, all with distinct identifiers', function (Dimension $dimension): void {
    $units = (new UnitCatalogue)->ofDimension($dimension);
    $ids = array_map(static fn (Unit $unit): string => $unit->id(), $units);

    expect(count($units))->toBeGreaterThanOrEqual(2)
        ->and(array_unique($ids))->toHaveCount(count($ids));
})->with(Dimension::cases());

it('offers every base unit without a prefix, with a positive size', function (BaseUnit $base): void {
    expect(Unit::of($base)->size()->isPositive())->toBeTrue();
})->with(BaseUnit::cases());
