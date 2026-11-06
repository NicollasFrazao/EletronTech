<?php

declare(strict_types=1);

namespace App\Providers;

use App\Application\Calculation\Calculate;
use App\Application\Calculation\ListCalculators;
use App\Application\UnitConversion\ConvertQuantity;
use App\Application\UnitConversion\ListConvertibleUnits;
use App\Console\ContextBase\AgentSurfaces;
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
use App\Domain\Calculator\Mathematics\BasicCalculator;
use App\Domain\Calculator\Mathematics\BinaryConverter;
use App\Domain\Calculator\Mathematics\RuleOfThree;
use App\Domain\Calculator\Physics\BernoulliEquation;
use App\Domain\Quantity\UnitCatalogue;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

/**
 * Composition root: binds the application's interfaces to their implementations.
 */
final class AppServiceProvider extends ServiceProvider
{
    /**
     * Registers the application's bindings.
     */
    public function register(): void
    {
        $this->app->bind(AgentSurfaces::class, fn (): AgentSurfaces => new AgentSurfaces(base_path()));

        // The catalogue is immutable and the same for every request: build it once per process.
        $this->app->singleton(UnitCatalogue::class, fn (): UnitCatalogue => new UnitCatalogue);
        $this->app->bind(
            ConvertQuantity::class,
            fn (Application $app): ConvertQuantity => new ConvertQuantity($app->make(UnitCatalogue::class)),
        );
        $this->app->bind(
            ListConvertibleUnits::class,
            fn (Application $app): ListConvertibleUnits => new ListConvertibleUnits($app->make(UnitCatalogue::class)),
        );

        // Every calculator is stateless; the catalogue lists them in the order the tools are offered.
        $this->app->singleton(CalculatorCatalog::class, fn (): CalculatorCatalog => new CalculatorCatalog(
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
        ));
        $this->app->bind(Calculate::class, fn (Application $app): Calculate => new Calculate(
            $app->make(CalculatorCatalog::class),
            $app->make(UnitCatalogue::class),
        ));
        $this->app->bind(ListCalculators::class, fn (Application $app): ListCalculators => new ListCalculators(
            $app->make(CalculatorCatalog::class),
            $app->make(UnitCatalogue::class),
        ));
    }
}
