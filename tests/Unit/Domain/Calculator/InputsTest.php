<?php

declare(strict_types=1);

use App\Domain\Calculator\Electrical\RoomType;
use App\Domain\Calculator\InputField;
use App\Domain\Calculator\InputKind;
use App\Domain\Calculator\InputProblem;
use App\Domain\Calculator\Inputs;
use App\Domain\Quantity\BaseUnit;
use App\Domain\Quantity\Length;
use App\Domain\Quantity\Quantity;
use App\Domain\Quantity\Unit;
use App\Domain\Quantity\Voltage;
use Brick\Math\BigRational;

it('describes each kind of input', function (): void {
    $quantity = InputField::quantity('length', Unit::of(BaseUnit::Metre));
    $number = InputField::number('turns')->optional();
    $choice = InputField::choice('room_type', [RoomType::Kitchen, RoomType::Bathroom]);

    expect([$quantity->kind(), $number->kind(), $choice->kind()])->toBe([InputKind::Quantity, InputKind::Number, InputKind::Choice])
        ->and([$quantity->isRequired, $number->isRequired])->toBe([true, false])
        ->and($choice->options)->toBe(['kitchen', 'bathroom']);
});

it('gives each value as its kind', function (): void {
    $inputs = new Inputs(['length' => Length::fromMetres(2), 'turns' => BigRational::of(3), 'room_type' => 'kitchen']);

    expect($inputs->quantity('length', Length::class)->toMetres()->toString())->toBe('2')
        ->and($inputs->positiveWholeNumber('turns'))->toBe(3)
        ->and($inputs->choice('room_type', RoomType::class))->toBe(RoomType::Kitchen)
        ->and($inputs->has('width'))->toBeFalse();
});

it('refuses a missing value or one of another kind', function (): void {
    $inputs = new Inputs(['length' => Length::fromMetres(2), 'turns' => BigRational::of(3), 'room_type' => 'kitchen']);

    expectInvalid(fn (): Quantity => $inputs->quantity('width', Length::class), 'width', InputProblem::Missing);
    expectInvalid(fn (): Quantity => $inputs->quantity('length', Voltage::class), 'length', InputProblem::WrongKind);
    expectInvalid(fn (): BigRational => $inputs->number('length'), 'length', InputProblem::WrongKind);
    expectInvalid(fn (): BigRational => $inputs->number('width'), 'width', InputProblem::Missing);
    expectInvalid(fn (): BackedEnum => $inputs->choice('turns', RoomType::class), 'turns', InputProblem::WrongKind);
    expectInvalid(fn (): BackedEnum => $inputs->choice('width', RoomType::class), 'width', InputProblem::Missing);
});

it('refuses values outside the range asked for', function (): void {
    $inputs = new Inputs([
        'zero' => Length::zero(),
        'negative' => Length::fromMetres(-1),
        'fraction' => BigRational::of('1/2'),
        'huge' => BigRational::of('1e30'),
    ]);

    expectInvalid(fn (): Quantity => $inputs->positiveQuantity('zero', Length::class), 'zero', InputProblem::NotPositive);
    expectInvalid(fn (): Quantity => $inputs->nonNegativeQuantity('negative', Length::class), 'negative', InputProblem::Negative);
    expectInvalid(fn (): int => $inputs->positiveWholeNumber('fraction'), 'fraction', InputProblem::NotWhole);
    expectInvalid(fn (): int => $inputs->positiveWholeNumber('huge'), 'huge', InputProblem::TooLarge);

    expect($inputs->nonNegativeQuantity('zero', Length::class)->isZero())->toBeTrue();
});

it('names the inputs left empty, refusing any other count', function (): void {
    $inputs = new Inputs(['a' => BigRational::one()]);

    expect($inputs->missing(['a', 'b', 'c'], 2))->toBe(['b', 'c']);
    expectInvalid(fn (): array => $inputs->missing(['a', 'b', 'c'], 1), 'inputs', InputProblem::WrongNumberOfValues);
    expectInvalid(fn (): array => $inputs->missing(['a'], 1), 'inputs', InputProblem::WrongNumberOfValues);
});
