<?php

declare(strict_types=1);

use Symfony\Component\Process\Process;

/**
 * Runs the local PHP_CodeSniffer standard on a fixture and returns "line:code" for each error.
 *
 * @return list<string>
 */
function sniffErrors(string $fixture): array
{
    $process = new Process([
        PHP_BINARY,
        'vendor/bin/phpcs',
        '--standard=phpcs/EletronTech',
        '--report=json',
        '--no-cache',
        "phpcs/tests/fixtures/{$fixture}",
    ], dirname(__DIR__, 2));
    $process->run();

    /** @var array{files: array<string, array{messages: list<array{line: int, source: string}>}>} $report */
    $report = json_decode($process->getOutput(), true, flags: JSON_THROW_ON_ERROR);
    $messages = array_merge(...array_column(array_values($report['files']), 'messages'));

    return array_map(
        fn (array $message): string => $message['line'].':'.$message['source'],
        $messages,
    );
}

it('reports undocumented public API and untracked TODOs', function (): void {
    expect(sniffErrors('violations.php'))->toBe([
        '7:EletronTech.Commenting.RequirePublicDocComment.Missing',
        '11:EletronTech.Commenting.RequirePublicDocComment.MissingSummary',
        '17:EletronTech.Commenting.RequirePublicDocComment.Missing',
        '19:EletronTech.Commenting.TodoWithIssue.MissingIssue',
    ]);
});

it('accepts documented API, constructors, {@inheritDoc} and tracked TODOs', function (): void {
    expect(sniffErrors('compliant.php'))->toBe([]);
});
