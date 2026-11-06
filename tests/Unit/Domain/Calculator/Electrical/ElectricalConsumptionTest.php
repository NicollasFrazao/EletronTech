<?php

declare(strict_types=1);

use App\Domain\Calculator\Electrical\ElectricalConsumption;
use App\Domain\Calculator\Inputs;
use App\Domain\Calculator\InvalidInput;
use App\Domain\Calculator\Result;
use App\Domain\Quantity\BaseUnit;
use App\Domain\Quantity\Duration;
use App\Domain\Quantity\Power;
use App\Domain\Quantity\Prefix;
use App\Domain\Quantity\Unit;
use Brick\Math\BigRational;
use Tests\Support\Results;

// E = P × t × days, as an electricity bill counts it (ANEEL, consumption of household appliances): a 5500 W
// shower used 30 minutes a day for 30 days uses 82.5 kWh; at 0.80 per kWh that is 66.

it('counts the energy over the period and its cost', function (): void {
    $result = (new ElectricalConsumption)->calculate(new Inputs([
        'power' => Power::fromWatts(5500),
        'daily_use' => Duration::of('0.5', Unit::of(BaseUnit::Hour)),
        'days' => BigRational::of(30),
        'tariff' => BigRational::of('0.80'),
    ]));

    expect(Results::exact($result, 'daily_energy'))->toBe('11/4')
        ->and(Results::exact($result, 'energy'))->toBe('165/2')
        ->and(Results::unit($result, 'energy'))->toBe('kWh')
        ->and(Results::exact($result, 'cost'))->toBe('66');
});

it('leaves the cost out without a tariff', function (): void {
    $result = (new ElectricalConsumption)->calculate(new Inputs([
        'power' => Power::of(1, Unit::of(BaseUnit::Watt, Prefix::Kilo)),
        'daily_use' => Duration::of(24, Unit::of(BaseUnit::Hour)),
        'days' => BigRational::of(1),
    ]));

    expect(Results::names($result))->toBe(['energy'])
        ->and(Results::exact($result, 'energy'))->toBe('24');
});

it('refuses impossible periods and prices', function (array $overrides, string $message): void {
    expect(fn (): Result => (new ElectricalConsumption)->calculate(new Inputs([
        'power' => Power::fromWatts(100),
        'daily_use' => Duration::of(1, Unit::of(BaseUnit::Hour)),
        'days' => BigRational::of(30),
        ...$overrides,
    ])))->toThrow(InvalidInput::class, $message);
})->with([
    'more than 24 hours a day' => [['daily_use' => Duration::of(25, Unit::of(BaseUnit::Hour))], 'Input "daily_use"'],
    'a fraction of a day' => [['days' => BigRational::of('1.5')], 'Input "days": the value must be a whole number.'],
    'no days' => [['days' => BigRational::zero()], 'Input "days": the value must be greater than zero.'],
    'a negative tariff' => [['tariff' => BigRational::of('-0.1')], 'Input "tariff": the value cannot be negative.'],
]);
