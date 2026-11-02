<?php

declare(strict_types=1);

namespace Fixture;

final class Undocumented
{
    /**
     * @return int
     */
    public function withoutSummary(): int
    {
        return 1;
    }

    public function withoutComment(): void
    {
        // TODO handle the rest
    }

    private function privateNeedsNothing(): void
    {
        // TODO(#12): tracked work is allowed.
    }
}
