<?php

declare(strict_types=1);

namespace App\Console\ContextBase;

/**
 * The first line where an agent surface differs from the context index.
 */
final readonly class SurfaceDrift
{
    private const string END_OF_FILE = '(end of file)';

    /**
     * @param  string  $surface  Path of the surface, relative to the repository root.
     * @param  int  $line  One-based number of the first different line.
     * @param  string  $expected  That line in the source.
     * @param  string  $actual  That line in the surface.
     */
    public function __construct(
        public string $surface,
        public int $line,
        public string $expected,
        public string $actual,
    ) {}

    /**
     * Finds the first line where the surface differs from the source.
     *
     * @return self|null Null when the two are identical.
     */
    public static function between(string $surface, string $source, string $contents): ?self
    {
        $sourceLines = explode("\n", $source);
        $surfaceLines = explode("\n", $contents);
        $length = max(count($sourceLines), count($surfaceLines));

        for ($index = 0; $index < $length; $index++) {
            $expected = $sourceLines[$index] ?? self::END_OF_FILE;
            $actual = $surfaceLines[$index] ?? self::END_OF_FILE;

            if ($expected !== $actual) {
                return new self($surface, $index + 1, $expected, $actual);
            }
        }

        return null;
    }
}
