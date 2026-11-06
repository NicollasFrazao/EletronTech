<?php

declare(strict_types=1);

use App\Domain\Calculator\Electrical\MotorEfficiency;
use App\Domain\Calculator\InputProblem;
use App\Domain\Calculator\Inputs;
use App\Domain\Calculator\Result;
use App\Domain\Quantity\Power;
use Brick\Math\BigRational;
use Tests\Support\Results;

// η = P_u / P_t and P_t = P_u + P_d (Fitzgerald, Electric Machinery). A 5 cv motor delivering 3680 W and losing
// 920 W takes 4600 W: η = 0.8.

it('derives the other two values from any two', function (array $given): void {
    $result = (new MotorEfficiency)->calculate(new Inputs($given));

    expect(Results::exact($result, 'useful_power'))->toBe('3680')
        ->and(Results::exact($result, 'lost_power'))->toBe('920')
        ->and(Results::exact($result, 'input_power'))->toBe('4600')
        ->and(Results::exact($result, 'efficiency'))->toBe('4/5');
})->with([
    'useful and lost' => [['useful_power' => Power::fromWatts(3680), 'lost_power' => Power::fromWatts(920)]],
    'useful and input' => [['useful_power' => Power::fromWatts(3680), 'input_power' => Power::fromWatts(4600)]],
    'useful and efficiency' => [['useful_power' => Power::fromWatts(3680), 'efficiency' => BigRational::of('0.8')]],
    'lost and input' => [['lost_power' => Power::fromWatts(920), 'input_power' => Power::fromWatts(4600)]],
    'input and efficiency' => [['input_power' => Power::fromWatts(4600), 'efficiency' => BigRational::of('0.8')]],
    'lost and efficiency' => [['lost_power' => Power::fromWatts(920), 'efficiency' => BigRational::of('0.8')]],
]);

it('accepts a motor without losses', function (): void {
    $result = (new MotorEfficiency)->calculate(new Inputs([
        'useful_power' => Power::fromWatts(1000),
        'lost_power' => Power::zero(),
    ]));

    expect(Results::exact($result, 'efficiency'))->toBe('1');
});

it('refuses impossible combinations', function (array $given, string $field, InputProblem $problem): void {
    expectInvalid(fn (): Result => (new MotorEfficiency)->calculate(new Inputs($given)), $field, $problem);
})->with([
    'useful above input' => [
        ['useful_power' => Power::fromWatts(500), 'input_power' => Power::fromWatts(400)], 'input_power', InputProblem::OutOfRange,
    ],
    'losses equal to input' => [
        ['lost_power' => Power::fromWatts(400), 'input_power' => Power::fromWatts(400)], 'lost_power', InputProblem::OutOfRange,
    ],
    'efficiency above one' => [
        ['useful_power' => Power::fromWatts(500), 'efficiency' => BigRational::of('1.2')], 'efficiency', InputProblem::OutOfRange,
    ],
    'lossless with losses' => [
        ['lost_power' => Power::fromWatts(10), 'efficiency' => BigRational::one()], 'efficiency', InputProblem::OutOfRange,
    ],
    'negative losses' => [
        ['useful_power' => Power::fromWatts(500), 'lost_power' => Power::fromWatts(-1)], 'lost_power', InputProblem::Negative,
    ],
    'three values' => [
        ['useful_power' => Power::fromWatts(1), 'lost_power' => Power::fromWatts(1), 'input_power' => Power::fromWatts(2)],
        'inputs',
        InputProblem::WrongNumberOfValues,
    ],
]);
