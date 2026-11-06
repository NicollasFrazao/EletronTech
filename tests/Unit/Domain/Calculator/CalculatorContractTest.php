<?php

declare(strict_types=1);

use App\Domain\Calculator\Calculator;
use App\Domain\Calculator\CalculatorCatalog;
use App\Domain\Calculator\Construction\BlockCount;
use App\Domain\Calculator\Construction\BtuSizing;
use App\Domain\Calculator\Construction\FloorAndWallTiles;
use App\Domain\Calculator\Electrical\BreakerAndWiring;
use App\Domain\Calculator\Electrical\ConductorResistance;
use App\Domain\Calculator\Electrical\ElectricalCapacitance;
use App\Domain\Calculator\Electrical\ElectricalConductance;
use App\Domain\Calculator\Electrical\ElectricalConsumption;
use App\Domain\Calculator\Electrical\ElectricalImpedance;
use App\Domain\Calculator\Electrical\ElectricalInductance;
use App\Domain\Calculator\Electrical\GeneralLighting;
use App\Domain\Calculator\Electrical\GeneralPower;
use App\Domain\Calculator\Electrical\LightingPower;
use App\Domain\Calculator\Electrical\MotorEfficiency;
use App\Domain\Calculator\Electrical\OhmsLaw;
use App\Domain\Calculator\Electrical\OutletCount;
use App\Domain\Calculator\Electrical\ResistorColourCode;
use App\Domain\Calculator\Electrical\SeriesParallelResistance;
use App\Domain\Calculator\Geometry\AreaAndPerimeter;
use App\Domain\Calculator\Geometry\SurfaceAreaAndVolume;
use App\Domain\Calculator\InputField;
use App\Domain\Calculator\InputKind;
use App\Domain\Calculator\Inputs;
use App\Domain\Calculator\InvalidInput;
use App\Domain\Calculator\Mathematics\BasicCalculator;
use App\Domain\Calculator\Mathematics\BinaryConverter;
use App\Domain\Calculator\Mathematics\RuleOfThree;
use App\Domain\Calculator\Physics\BernoulliEquation;
use App\Domain\Calculator\UnknownCalculator;

dataset('calculators', fn (): array => [
    new ElectricalCapacitance,
    new ElectricalConductance,
    new ElectricalImpedance,
    new ElectricalInductance,
    new GeneralPower,
    new LightingPower,
    new GeneralLighting,
    new OutletCount,
    new BreakerAndWiring,
    new MotorEfficiency,
    new ElectricalConsumption,
    new ResistorColourCode,
    new OhmsLaw,
    new ConductorResistance,
    new SeriesParallelResistance,
    new AreaAndPerimeter,
    new SurfaceAreaAndVolume,
    new BasicCalculator,
    new BinaryConverter,
    new RuleOfThree,
    new BernoulliEquation,
    new BtuSizing,
    new FloorAndWallTiles,
    new BlockCount,
]);

it('declares inputs with distinct names, each quantity with a unit and each choice with options', function (Calculator $calculator): void {
    $names = array_map(static fn (InputField $field): string => $field->name, $calculator->inputs());

    expect(array_unique($names))->toHaveCount(count($names))
        ->and($calculator->id())->toMatch('/^[a-z]+(-[a-z]+)*$/');

    foreach ($calculator->inputs() as $field) {
        expect($field->kind() === InputKind::Choice)->toBe($field->options !== [])
            ->and($field->kind() === InputKind::Quantity)->toBe($field->defaultUnit !== null);
    }
})->with('calculators');

it('refuses to calculate without inputs', function (Calculator $calculator): void {
    $calculator->calculate(new Inputs([]));
})->with('calculators')->throws(InvalidInput::class);

it('finds a calculator by its identifier and lists them in order', function (): void {
    $capacitance = new ElectricalCapacitance;
    $catalog = new CalculatorCatalog($capacitance, new OutletCount);

    expect($catalog->find('electrical-capacitance'))->toBe($capacitance)
        ->and(array_map(static fn (Calculator $calculator): string => $calculator->id(), $catalog->all()))
        ->toBe(['electrical-capacitance', 'outlet-count']);
});

it('rejects an identifier no calculator has', function (): void {
    new CalculatorCatalog(new OutletCount)->find('flux-capacitor');
})->throws(UnknownCalculator::class, 'There is no calculator "flux-capacitor".');

it('refuses two calculators with the same identifier', function (): void {
    new CalculatorCatalog(new OutletCount, new OutletCount);
})->throws(InvalidArgumentException::class);
