<?php

declare(strict_types=1);

use App\Domain\Quantity\ApparentPower;
use App\Domain\Quantity\Area;
use App\Domain\Quantity\Capacitance;
use App\Domain\Quantity\Charge;
use App\Domain\Quantity\Conductance;
use App\Domain\Quantity\Current;
use App\Domain\Quantity\DivisionByZero;
use App\Domain\Quantity\Length;
use App\Domain\Quantity\Power;
use App\Domain\Quantity\PowerFactor;
use App\Domain\Quantity\PowerFactorOutOfRange;
use App\Domain\Quantity\Resistance;
use App\Domain\Quantity\Voltage;

it('multiplies voltage by current into power, either way round', function (): void {
    $voltage = Voltage::fromVolts(127);
    $current = Current::fromAmperes(10);

    expect($voltage->timesCurrent($current)->toWatts()->toString())->toBe('1270')
        ->and($current->timesVoltage($voltage)->toWatts()->toString())->toBe('1270');
});

it('divides power by voltage into current and by current into voltage', function (): void {
    $shower = Power::fromWatts(5500);

    expect($shower->dividedByVoltage(Voltage::fromVolts(220))->toAmperes()->toString())->toBe('25')
        ->and($shower->dividedByCurrent(Current::fromAmperes(25))->toVolts()->toString())->toBe('220');
});

it("applies Ohm's law in every direction", function (): void {
    $voltage = Voltage::fromVolts(12);
    $current = Current::fromAmperes('0.5');
    $resistance = Resistance::fromOhms(24);

    expect($voltage->dividedByCurrent($current)->toOhms()->toString())->toBe('24')
        ->and($voltage->dividedByResistance($resistance)->toAmperes()->toString())->toBe('1/2')
        ->and($current->timesResistance($resistance)->toVolts()->toString())->toBe('12')
        ->and($resistance->timesCurrent($current)->toVolts()->toString())->toBe('12');
});

it('turns resistance into conductance and back', function (): void {
    $conductance = Resistance::fromOhms(4)->reciprocal();

    expect($conductance->toSiemens()->toString())->toBe('1/4')
        ->and($conductance->reciprocal()->toOhms()->toString())->toBe('4')
        ->and(Conductance::fromSiemens(2)->reciprocal()->toOhms()->toString())->toBe('1/2');
});

it('refuses the reciprocal of a zero resistance or conductance', function (Closure $reciprocal): void {
    $reciprocal();
})->with([
    'resistance' => [fn (): Conductance => Resistance::zero()->reciprocal()],
    'conductance' => [fn (): Resistance => Conductance::zero()->reciprocal()],
])->throws(DivisionByZero::class);

it('refuses to divide by a zero voltage, current or resistance', function (Closure $division): void {
    $division();
})->with([
    'power by voltage' => [fn (): Current => Power::fromWatts(1)->dividedByVoltage(Voltage::zero())],
    'power by current' => [fn (): Voltage => Power::fromWatts(1)->dividedByCurrent(Current::zero())],
    'voltage by current' => [fn (): Resistance => Voltage::fromVolts(1)->dividedByCurrent(Current::zero())],
    'voltage by resistance' => [fn (): Current => Voltage::fromVolts(1)->dividedByResistance(Resistance::zero())],
    'apparent power by voltage' => [fn (): Current => ApparentPower::fromVoltAmperes(1)->dividedByVoltage(Voltage::zero())],
    'charge by voltage' => [fn (): Capacitance => Charge::fromCoulombs(1)->dividedByVoltage(Voltage::zero())],
    'charge by capacitance' => [fn (): Voltage => Charge::fromCoulombs(1)->dividedByCapacitance(Capacitance::zero())],
    'area by length' => [fn (): Length => Area::fromSquareMetres(1)->dividedByLength(Length::zero())],
])->throws(DivisionByZero::class);

it('relates apparent and active power through the power factor', function (): void {
    $apparent = ApparentPower::fromVoltageAndCurrent(Voltage::fromVolts(220), Current::fromAmperes(10));
    $factor = PowerFactor::of('0.8');

    expect($apparent->toVoltAmperes()->toString())->toBe('2200')
        ->and($apparent->timesPowerFactor($factor)->toWatts()->toString())->toBe('1760')
        ->and(Power::fromWatts(1760)->dividedByPowerFactor($factor)->toVoltAmperes()->toString())->toBe('2200');
});

it('gives the current a circuit of an apparent power draws, as NBR 5410 sizes outlet circuits', function (): void {
    $outlets = ApparentPower::fromVoltAmperes(1270);

    expect($outlets->dividedByVoltage(Voltage::fromVolts(127))->toAmperes()->toString())->toBe('10');
});

it('accepts a power factor greater than 0 and at most 1', function (string $value): void {
    expect(PowerFactor::of($value)->value()->isEqualTo($value))->toBeTrue();
})->with(['1', '0.92', '0.0001']);

it('refuses a power factor outside (0, 1]', function (string $value): void {
    PowerFactor::of($value);
})->with(['0', '-0.5', '1.01'])->throws(PowerFactorOutOfRange::class);

it('relates charge, capacitance and voltage', function (): void {
    $capacitance = Capacitance::fromFarads('0.000047');
    $charge = $capacitance->timesVoltage(Voltage::fromVolts(10));

    expect($charge->toCoulombs()->toString())->toBe('47/100000')
        ->and($charge->dividedByVoltage(Voltage::fromVolts(10))->toFarads()->isEqualTo('0.000047'))->toBeTrue()
        ->and($charge->dividedByCapacitance($capacitance)->toVolts()->toString())->toBe('10');
});

it('multiplies two lengths into an area and divides it back', function (): void {
    $area = Length::fromMetres('3.5')->timesLength(Length::fromMetres(4));

    expect($area->toSquareMetres()->toString())->toBe('14')
        ->and($area->dividedByLength(Length::fromMetres(4))->toMetres()->toString())->toBe('7/2');
});
