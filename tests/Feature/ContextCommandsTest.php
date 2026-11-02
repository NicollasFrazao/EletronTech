<?php

declare(strict_types=1);

use App\Console\ContextBase\AgentSurfaces;
use Illuminate\Support\Facades\File;

beforeEach(function (): void {
    $this->root = sys_get_temp_dir().'/context-'.bin2hex(random_bytes(6));
    File::ensureDirectoryExists($this->root.'/.context/docs');
    $this->app->instance(AgentSurfaces::class, new AgentSurfaces($this->root));
});

afterEach(function (): void {
    File::deleteDirectory($this->root);
});

it('writes every surface as a copy of the index', function (): void {
    File::put($this->root.'/.context/docs/README.md', "# Index\n\nRead the conventions.\n");

    $this->artisan('context:export')->assertSuccessful();

    foreach (AgentSurfaces::SURFACES as $surface) {
        expect(File::get($this->root.'/'.$surface))->toBe("# Index\n\nRead the conventions.\n");
    }

    $this->artisan('context:check')
        ->expectsOutputToContain('OK: AGENTS.md')
        ->assertSuccessful();
});

it('reports the first different line of a drifted surface', function (): void {
    File::put($this->root.'/.context/docs/README.md', "# Index\n\nRead the conventions.\n");
    $this->artisan('context:export')->assertSuccessful();
    File::put($this->root.'/AGENTS.md', "# Index\n\nEdited by hand.\n");

    $this->artisan('context:check')
        ->expectsOutputToContain('AGENTS.md is not a copy of .context/docs/README.md, line 3:')
        ->expectsOutputToContain('surface: Edited by hand.')
        ->expectsOutputToContain('Run `php artisan context:export`')
        ->assertFailed();
});

it('reports a missing surface as ending early', function (): void {
    File::put($this->root.'/.context/docs/README.md', "# Index\n");
    $this->artisan('context:export')->assertSuccessful();
    File::delete($this->root.'/.github/copilot-instructions.md');

    $this->artisan('context:check')
        ->expectsOutputToContain('.github/copilot-instructions.md is not a copy')
        ->assertFailed();
});

it('fails both commands when the index is missing', function (string $command): void {
    $this->artisan($command)
        ->expectsOutputToContain('.context/docs/README.md is missing')
        ->assertFailed();
})->with(['context:export', 'context:check']);
