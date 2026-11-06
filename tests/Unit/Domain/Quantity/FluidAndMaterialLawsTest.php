<?php

declare(strict_types=1);

use App\Domain\Quantity\Area;
use App\Domain\Quantity\BaseUnit;
use App\Domain\Quantity\Density;
use App\Domain\Quantity\DivisionByZero;
use App\Domain\Quantity\Length;
use App\Domain\Quantity\Resistivity;
use App\Domain\Quantity\Unit;
use App\Domain\Quantity\Velocity;

// Operations between the quantities E3 added: V = A × h (a prism), q = ½ρv² (dynamic pressure),
// p = ρg₀h with g₀ = 9.80665 m/s² (hydrostatic pressure, CGPM 1901), R = ρL/A (Ohm's second law).

it('gives the volume of a prism from its base and height', function (): void {
    $volume = Area::fromSquareMetres(2)->timesLength(Length::fromMetres(3));

    expect($volume->in(Unit::of(BaseUnit::Litre))->toString())->toBe('6000');
});

it('gives the dynamic pressure of a flow', function (): void {
    $pressure = Density::fromKilogramsPerCubicMetre(1000)->dynamicPressureAt(Velocity::fromMetresPerSecond(2));

    expect($pressure->in(Unit::of(BaseUnit::Pascal))->toString())->toBe('2000');
});

it('gives the pressure of a column of water, one metre of water per metre', function (): void {
    $pressure = Density::fromKilogramsPerCubicMetre(1000)->hydrostaticPressureAt(Length::fromMetres(10));

    expect($pressure->in(Unit::of(BaseUnit::MetreOfWater))->toString())->toBe('10')
        ->and($pressure->in(Unit::of(BaseUnit::Pascal))->toString())->toBe('196133/2');
});

it('gives the resistance of a conductor from its material, length and cross-section', function (): void {
    $copper = Resistivity::fromOhmMetres('0.0000000172');

    expect($copper->resistanceOf(Length::fromMetres(100), Area::fromSquareMetres('0.0000025'))->toOhms()->toString())
        ->toBe('86/125');
});

it('refuses a conductor without a cross-section', function (): void {
    Resistivity::fromOhmMetres(1)->resistanceOf(Length::fromMetres(1), Area::zero());
})->throws(DivisionByZero::class);
