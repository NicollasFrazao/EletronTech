<?php

declare(strict_types=1);

namespace App\Console\ContextBase;

use RuntimeException;

/**
 * The context index the agent surfaces copy does not exist.
 */
final class MissingContextSource extends RuntimeException
{
    /**
     * @param  string  $source  Path of the missing index, relative to the repository root.
     */
    public function __construct(string $source)
    {
        parent::__construct("{$source} is missing: it is the source every agent surface copies.");
    }
}
