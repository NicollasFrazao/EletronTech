<?php

declare(strict_types=1);

use App\Application\UnitConversion\ConversionInput;
use App\Application\UnitConversion\ConversionResult;
use App\Application\UnitConversion\ConvertQuantity;
use App\Application\UnitConversion\ListConvertibleUnits;
use App\Domain\Quantity\IncompatibleUnit;
use App\Domain\Quantity\InvalidNumber;
use App\Domain\Quantity\UnitCatalogue;
use App\Domain\Quantity\UnknownUnit;

it('converts a value and says when the result is exact', function (): void {
    $result = new ConvertQuantity(new UnitCatalogue)->handle(new ConversionInput('1.5', 'kilowatt', 'watt'));

    expect($result->from->value)->toBe('1.5')
        ->and($result->from->unit->symbol)->toBe('kW')
        ->and($result->to->value)->toBe('1500')
        ->and($result->to->unit->name)->toBe('watt')
        ->and($result->isExact)->toBeTrue();
});

it('rounds a repeating result to 12 significant digits and says it is not exact', function (): void {
    $result = new ConvertQuantity(new UnitCatalogue)->handle(new ConversionInput('1', 'foot', 'yard'));

    expect($result->to->value)->toBe('0.333333333333')
        ->and($result->isExact)->toBeFalse();
});

it('shows a value typed in scientific notation as a plain decimal', function (): void {
    $result = new ConvertQuantity(new UnitCatalogue)->handle(new ConversionInput('4.7e-6', 'farad', 'microfarad'));

    expect($result->from->value)->toBe('0.0000047')
        ->and($result->to->value)->toBe('4.7');
});

it('refuses what the converter cannot answer', function (ConversionInput $input, string $error): void {
    expect(fn (): ConversionResult => new ConvertQuantity(new UnitCatalogue)->handle($input))->toThrow($error);
})->with([
    'not a number' => [new ConversionInput('abc', 'volt', 'kilovolt'), InvalidNumber::class],
    'unknown unit' => [new ConversionInput('1', 'volt', 'parsec'), UnknownUnit::class],
    'different dimensions' => [new ConversionInput('1', 'volt', 'ampere'), IncompatibleUnit::class],
]);

it('lists one group per dimension with its units smallest first', function (): void {
    $groups = new ListConvertibleUnits(new UnitCatalogue)->handle();

    expect($groups)->toHaveCount(12)
        ->and($groups[0]->dimension)->toBe('voltage')
        ->and($groups[0]->units[0]->id)->toBe('nanovolt')
        ->and(array_column($groups, 'dimension'))->toContain('apparent_power', 'area');
});
