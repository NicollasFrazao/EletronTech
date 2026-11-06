<?php

declare(strict_types=1);

namespace App\Providers;

use App\Application\UnitConversion\ConvertQuantity;
use App\Application\UnitConversion\ListConvertibleUnits;
use App\Console\ContextBase\AgentSurfaces;
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
    }
}
