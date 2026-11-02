<?php

declare(strict_types=1);

namespace App\Providers;

use App\Console\ContextBase\AgentSurfaces;
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
    }
}
