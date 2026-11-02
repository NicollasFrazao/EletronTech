<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Entry point of `php artisan db:seed`.
 *
 * Empty on purpose: the catalogue of tools and packages is seeded by the phases that model it
 * (E2 #5, E5 #8), not by the foundation.
 */
final class DatabaseSeeder extends Seeder
{
    /**
     * Seeds the application's database.
     */
    public function run(): void
    {
        // The seeders of each phase are called from here as they arrive.
    }
}
