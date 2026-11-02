<?php

declare(strict_types=1);

namespace App\Console\ContextBase;

/**
 * Keeps the agent surfaces byte-for-byte copies of `.context/docs/README.md`.
 *
 * That file is the index of the context base and tells an agent to read the conventions before
 * editing. The rules themselves are not copied: a surface that sends the agent to them costs one
 * read and keeps a single place to change them. Copying is the whole generation step, so there is
 * no template engine here.
 */
final readonly class AgentSurfaces
{
    /**
     * The file every surface is a copy of, relative to the repository root.
     */
    public const string SOURCE = '.context/docs/README.md';

    /**
     * Where each tool looks for its instructions, relative to the repository root.
     *
     * @var list<string>
     */
    public const array SURFACES = [
        'AGENTS.md',
        '.claude/CLAUDE.md',
        '.github/copilot-instructions.md',
    ];

    /**
     * @param  string  $root  Absolute path of the repository root.
     */
    public function __construct(private string $root) {}

    /**
     * Copies the source over every surface, creating missing directories.
     *
     * @throws MissingContextSource when `.context/docs/README.md` does not exist.
     */
    public function export(): void
    {
        $source = $this->source();

        foreach (self::SURFACES as $surface) {
            $path = $this->path($surface);
            $directory = dirname($path);

            // The directory may be gone: deleting it is how someone recovers from a surface broken by hand.
            if (! is_dir($directory)) {
                mkdir($directory, recursive: true);
            }

            file_put_contents($path, $source);
        }
    }

    /**
     * Compares every surface with the source, line by line, without normalising anything.
     *
     * @return list<SurfaceDrift> One entry per surface that differs, at its first different line.
     *
     * @throws MissingContextSource when `.context/docs/README.md` does not exist.
     */
    public function drifts(): array
    {
        $source = $this->source();
        $drifts = [];

        foreach (self::SURFACES as $surface) {
            $drift = SurfaceDrift::between($surface, $source, $this->read($surface) ?? '');

            if ($drift instanceof SurfaceDrift) {
                $drifts[] = $drift;
            }
        }

        return $drifts;
    }

    /**
     * @throws MissingContextSource
     */
    private function source(): string
    {
        return $this->read(self::SOURCE) ?? throw new MissingContextSource(self::SOURCE);
    }

    private function read(string $relativePath): ?string
    {
        $path = $this->path($relativePath);

        if (! is_file($path)) {
            return null;
        }

        $contents = file_get_contents($path);

        return $contents === false ? null : $contents;
    }

    private function path(string $relativePath): string
    {
        return $this->root.DIRECTORY_SEPARATOR.$relativePath;
    }
}
