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
        ->and($inputs->wholeNumber('turns', 1))->toBe(3)
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
    expectInvalid(fn (): int => $inputs->wholeNumber('fraction', 1), 'fraction', InputProblem::NotWhole);
    expectInvalid(fn (): int => $inputs->wholeNumber('huge', 1), 'huge', InputProblem::TooLarge);

    expect($inputs->nonNegativeQuantity('zero', Length::class)->isZero())->toBeTrue();
});

it('names the inputs left empty, refusing any other count', function (): void {
    $inputs = new Inputs(['a' => BigRational::one()]);

    expect($inputs->missing(['a', 'b', 'c'], 2))->toBe(['b', 'c']);
    expectInvalid(fn (): array => $inputs->missing(['a', 'b', 'c'], 1), 'inputs', InputProblem::WrongNumberOfValues);
    expectInvalid(fn (): array => $inputs->missing(['a'], 1), 'inputs', InputProblem::WrongNumberOfValues);
});

it('describes a text input and gives the text as typed', function (): void {
    $field = InputField::text('expression')->optional();
    $inputs = new Inputs(['expression' => '(2 + 3) * 4', 'turns' => BigRational::of(3)]);

    expect([$field->kind(), $field->isRequired, $field->defaultUnit, $field->options])->toBe([InputKind::Text, false, null, []])
        ->and($inputs->text('expression'))->toBe('(2 + 3) * 4');
    expectInvalid(fn (): string => $inputs->text('turns'), 'turns', InputProblem::WrongKind);
    expectInvalid(fn (): string => $inputs->text('value'), 'value', InputProblem::Missing);
});

it('keeps the default unit and the options of an optional input', function (): void {
    $quantity = InputField::quantity('length', Unit::of(BaseUnit::Metre))->optional();
    $choice = InputField::choice('room_type', [RoomType::Kitchen])->optional();

    expect([$quantity->kind(), $quantity->defaultUnit?->id()])->toBe([InputKind::Quantity, 'metre'])
        ->and([$choice->kind(), $choice->options])->toBe([InputKind::Choice, ['kitchen']]);
});

it('reads a whole number of at least zero or at least one', function (): void {
    $inputs = new Inputs(['none' => BigRational::zero(), 'negative' => BigRational::of(-1)]);

    expect($inputs->wholeNumber('none', 0))->toBe(0);
    expectInvalid(fn (): int => $inputs->wholeNumber('none', 1), 'none', InputProblem::NotPositive);
    expectInvalid(fn (): int => $inputs->wholeNumber('negative', 0), 'negative', InputProblem::Negative);
    expectInvalid(fn (): int => $inputs->wholeNumber('negative', 1), 'negative', InputProblem::NotPositive);
});
