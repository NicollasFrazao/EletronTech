<?php

declare(strict_types=1);

use App\Domain\Quantity\ApparentPower;
use App\Domain\Quantity\Area;
use App\Domain\Quantity\Capacitance;
use App\Domain\Quantity\Charge;
use App\Domain\Quantity\Conductance;
use App\Domain\Quantity\Current;
use App\Domain\Quantity\DivisionByZero;
use App\Domain\Quantity\Frequency;
use App\Domain\Quantity\Inductance;
use App\Domain\Quantity\Length;
use App\Domain\Quantity\Power;
use App\Domain\Quantity\Resistance;
use App\Domain\Quantity\Voltage;
use Brick\Math\BigRational;

it('adds and subtracts quantities of the same kind', function (): void {
    $sum = Length::fromMetres('2.5')->plus(Length::fromMetres('0.75'));
    $difference = Length::fromMetres(1)->minus(Length::fromMetres(3));

    expect($sum->toMetres()->toString())->toBe('13/4')
        ->and($difference->toMetres()->toString())->toBe('-2')
        ->and($difference->isNegative())->toBeTrue();
});

it('scales a quantity by a pure number', function (): void {
    expect(Power::fromWatts(100)->multipliedBy('1.5')->toWatts()->toString())->toBe('150')
        ->and(Power::fromWatts(100)->dividedBy(3)->toWatts()->toString())->toBe('100/3');
});

it('refuses to divide a quantity by zero', function (): void {
    Power::fromWatts(100)->dividedBy(0);
})->throws(DivisionByZero::class, 'A quantity cannot be divided by zero.');

it('gives the ratio of two quantities of the same kind as a pure number', function (): void {
    $output = Power::fromWatts(850);
    $input = Power::fromWatts(1000);

    expect($output->ratioTo($input)->toString())->toBe('17/20');
});

it('refuses the ratio to a zero quantity', function (): void {
    Power::fromWatts(1)->ratioTo(Power::zero());
})->throws(DivisionByZero::class);

it('compares quantities whatever unit they were created in', function (): void {
    $metre = Length::fromMetres(1);
    $hundredCentimetres = Length::fromMetres('1.00');

    expect($metre->isEqualTo($hundredCentimetres))->toBeTrue()
        ->and($metre->isGreaterThan(Length::fromMetres('0.3048')))->toBeTrue()
        ->and($metre->isLessThan(Length::fromMetres('0.3048')))->toBeFalse()
        ->and(Length::zero()->isZero())->toBeTrue()
        ->and($metre->isZero())->toBeFalse();
});

it('refuses to combine two kinds of quantity at run time too', function (): void {
    $voltage = Voltage::fromVolts(1);
    $current = Current::fromAmperes(1);

    // PHPStan refuses this call; the test makes the mistake on purpose.
    $voltage->plus($current);
})->throws(InvalidArgumentException::class, 'cannot be combined with');

it('creates every quantity from and reads it back in its coherent SI unit', function (Closure $roundTrip): void {
    expect($roundTrip('2.5')->toString())->toBe('5/2');
})->with([
    'volts' => [fn (string $value): BigRational => Voltage::fromVolts($value)->toVolts()],
    'amperes' => [fn (string $value): BigRational => Current::fromAmperes($value)->toAmperes()],
    'watts' => [fn (string $value): BigRational => Power::fromWatts($value)->toWatts()],
    'volt-amperes' => [fn (string $value): BigRational => ApparentPower::fromVoltAmperes($value)->toVoltAmperes()],
    'ohms' => [fn (string $value): BigRational => Resistance::fromOhms($value)->toOhms()],
    'siemens' => [fn (string $value): BigRational => Conductance::fromSiemens($value)->toSiemens()],
    'farads' => [fn (string $value): BigRational => Capacitance::fromFarads($value)->toFarads()],
    'henries' => [fn (string $value): BigRational => Inductance::fromHenries($value)->toHenries()],
    'coulombs' => [fn (string $value): BigRational => Charge::fromCoulombs($value)->toCoulombs()],
    'hertz' => [fn (string $value): BigRational => Frequency::fromHertz($value)->toHertz()],
    'metres' => [fn (string $value): BigRational => Length::fromMetres($value)->toMetres()],
    'square metres' => [fn (string $value): BigRational => Area::fromSquareMetres($value)->toSquareMetres()],
]);
