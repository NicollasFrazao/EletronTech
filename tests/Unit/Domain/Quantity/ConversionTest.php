<?php

declare(strict_types=1);

use App\Domain\Quantity\ApparentPower;
use App\Domain\Quantity\Area;
use App\Domain\Quantity\Capacitance;
use App\Domain\Quantity\Charge;
use App\Domain\Quantity\Conductance;
use App\Domain\Quantity\Current;
use App\Domain\Quantity\Frequency;
use App\Domain\Quantity\IncompatibleUnit;
use App\Domain\Quantity\Inductance;
use App\Domain\Quantity\Length;
use App\Domain\Quantity\Power;
use App\Domain\Quantity\Precision;
use App\Domain\Quantity\Quantities;
use App\Domain\Quantity\Resistance;
use App\Domain\Quantity\UnitCatalogue;
use App\Domain\Quantity\Voltage;
use Brick\Math\BigRational;

it('converts between units exactly', function (string $value, string $from, string $to, string $expected): void {
    $catalogue = new UnitCatalogue;

    $converted = Quantities::of($value, $catalogue->find($from))->in($catalogue->find($to));

    expect($converted->toString())->toBe(BigRational::of($expected)->toString());
})->with([
    'kilowatt to watt' => ['1', 'kilowatt', 'watt', '1000'],
    'horsepower to watt' => ['1', 'horsepower', 'watt', '745.69987158227022'],
    'metric horsepower to watt' => ['1', 'metric_horsepower', 'watt', '735.49875'],
    'kilovolt-ampere to volt-ampere' => ['2.5', 'kilovolt_ampere', 'volt_ampere', '2500'],
    'millivolt to volt' => ['250', 'millivolt', 'volt', '0.25'],
    'statvolt to volt' => ['1', 'statvolt', 'volt', '299.792458'],
    'abvolt to nanovolt' => ['1', 'abvolt', 'nanovolt', '10'],
    'abampere to ampere' => ['1', 'abampere', 'ampere', '10'],
    'microampere to milliampere' => ['1500', 'microampere', 'milliampere', '1.5'],
    'kiloohm to ohm' => ['4.7', 'kiloohm', 'ohm', '4700'],
    'gigaohm to megaohm' => ['1', 'gigaohm', 'megaohm', '1000'],
    'mho to siemens' => ['3', 'mho', 'siemens', '3'],
    'microfarad to picofarad' => ['1', 'microfarad', 'picofarad', '1000000'],
    'abhenry to nanohenry' => ['1', 'abhenry', 'nanohenry', '1'],
    'ampere-hour to coulomb' => ['1', 'ampere_hour', 'coulomb', '3600'],
    'milliampere-hour to coulomb' => ['1', 'milliampere_hour', 'coulomb', '3.6'],
    'coulomb to statcoulomb' => ['1', 'coulomb', 'statcoulomb', '2997924580'],
    'faraday to coulomb' => ['1', 'faraday', 'coulomb', '96485.3321233100184'],
    'megahertz to hertz' => ['1', 'megahertz', 'hertz', '1000000'],
    'inch to centimetre' => ['1', 'inch', 'centimetre', '2.54'],
    'mile to kilometre' => ['1', 'mile', 'kilometre', '1.609344'],
    'hectare to square metre' => ['1', 'hectare', 'square_metre', '10000'],
    'square foot to square inch' => ['1', 'square_foot', 'square_inch', '144'],
    'kilovolt-ampere reactive to volt-ampere reactive' => ['1.2', 'kilovolt_ampere_reactive', 'volt_ampere_reactive', '1200'],
    'maxwell to microweber' => ['100', 'maxwell', 'microweber', '1'],
    'kilowatt-hour to megajoule' => ['1', 'kilowatt_hour', 'megajoule', '3.6'],
    'day to minute' => ['1', 'day', 'minute', '1440'],
    'hour to second' => ['0.5', 'hour', 'second', '1800'],
    'kilolumen to lumen' => ['3.25', 'kilolumen', 'lumen', '3250'],
    'foot-candle to lux' => ['1', 'foot_candle', 'lux', '1562500/145161'],
    'square millimetre to square metre' => ['2.5', 'square_millimetre', 'square_metre', '0.0000025'],
]);

it('expresses one elementary charge in coulombs exactly', function (): void {
    $catalogue = new UnitCatalogue;
    $charge = Quantities::of(1, $catalogue->find('elementary_charge'));

    expect($charge->in($catalogue->find('coulomb'))->toBigDecimal()->toString())
        ->toBe('0.0000000000000000001602176634');
});

it('rounds only the displayed result', function (): void {
    $catalogue = new UnitCatalogue;
    $cooling = Quantities::of(12000, $catalogue->find('btu_per_hour'));

    expect($cooling->rounded($catalogue->find('watt'), Precision::significantDigits(6))->toString())->toBe('3516.85')
        ->and($cooling->rounded($catalogue->find('watt'), Precision::decimalPlaces(3))->toString())->toBe('3516.853')
        ->and($cooling->in($catalogue->find('watt'))->toString())->toBe('52752792631/15000000');
});

it('has none of the float drift of the 2015 converter', function (): void {
    $total = Length::fromMetres('0.1')->plus(Length::fromMetres('0.2'));

    expect($total->isEqualTo(Length::fromMetres('0.3')))->toBeTrue();
});

it('refuses a unit of another dimension when creating a quantity', function (): void {
    Voltage::of(1, (new UnitCatalogue)->find('ampere'));
})->throws(IncompatibleUnit::class, 'ampere measures current, not voltage.');

it('refuses a unit of another dimension when converting', function (): void {
    Voltage::fromVolts(1)->in((new UnitCatalogue)->find('metre'));
})->throws(IncompatibleUnit::class, 'metre measures length, not voltage.');

it('builds the value object that matches the unit', function (string $unit, string $class): void {
    expect(Quantities::of(1, (new UnitCatalogue)->find($unit)))->toBeInstanceOf($class);
})->with([
    ['volt', Voltage::class],
    ['ampere', Current::class],
    ['watt', Power::class],
    ['volt_ampere', ApparentPower::class],
    ['ohm', Resistance::class],
    ['siemens', Conductance::class],
    ['farad', Capacitance::class],
    ['henry', Inductance::class],
    ['coulomb', Charge::class],
    ['hertz', Frequency::class],
    ['metre', Length::class],
    ['square_metre', Area::class],
]);
