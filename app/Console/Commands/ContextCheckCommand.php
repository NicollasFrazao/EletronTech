<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Console\ContextBase\AgentSurfaces;
use App\Console\ContextBase\MissingContextSource;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

/**
 * `php artisan context:check`: fails when an agent surface is not a copy of `.context/docs/README.md`.
 *
 * A failure means a surface drifted, never that the content is wrong; CI runs it as the `context` job.
 */
#[Description('Verify that the agent surfaces are byte-for-byte copies of .context/docs/README.md')]
#[Signature('context:check')]
final class ContextCheckCommand extends Command
{
    private const int PREVIEW_LENGTH = 96;

    /**
     * Reports the first different line of each drifted surface.
     */
    public function handle(AgentSurfaces $surfaces): int
    {
        try {
            $drifts = $surfaces->drifts();
        } catch (MissingContextSource $exception) {
            $this->error($exception->getMessage());

            return self::FAILURE;
        }

        if ($drifts === []) {
            $this->info('OK: '.implode(', ', AgentSurfaces::SURFACES).' are copies of '.AgentSurfaces::SOURCE.'.');

            return self::SUCCESS;
        }

        $this->error('The agent surfaces drifted from their source:');

        foreach ($drifts as $drift) {
            $this->line("  - {$drift->surface} is not a copy of ".AgentSurfaces::SOURCE.", line {$drift->line}:");
            $this->line('      source:  '.$this->preview($drift->expected));
            $this->line('      surface: '.$this->preview($drift->actual));
        }

        $this->line('Run `php artisan context:export` and commit the result.');

        return self::FAILURE;
    }

    private function preview(string $line): string
    {
        return mb_substr(trim($line), 0, self::PREVIEW_LENGTH);
    }
}
