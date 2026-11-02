<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Console\ContextBase\AgentSurfaces;
use App\Console\ContextBase\MissingContextSource;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

/**
 * `php artisan context:export`: writes the agent surfaces from `.context/docs/README.md`.
 */
#[Description('Copy .context/docs/README.md over AGENTS.md, .claude/CLAUDE.md and .github/copilot-instructions.md')]
#[Signature('context:export')]
final class ContextExportCommand extends Command
{
    /**
     * Writes every surface and reports which ones.
     */
    public function handle(AgentSurfaces $surfaces): int
    {
        try {
            $surfaces->export();
        } catch (MissingContextSource $exception) {
            $this->error($exception->getMessage());

            return self::FAILURE;
        }

        $this->info('Wrote '.implode(', ', AgentSurfaces::SURFACES).' from '.AgentSurfaces::SOURCE.'.');

        return self::SUCCESS;
    }
}
