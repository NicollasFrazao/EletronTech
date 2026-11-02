// Fast first filter on commit; the full gate is `make gate` (CONTRIBUTING.md).
// PHP goes through scripts/php, which falls back to the Docker image when the host has no PHP 8.4.
const CONTEXT_FILES = '{.context/docs/README.md,AGENTS.md,.claude/CLAUDE.md,.github/copilot-instructions.md}';

// The sniff fixtures break the rules on purpose; tests/Unit/CodingStandardTest.php checks them.
const FIXTURES = '/phpcs/tests/fixtures/';

/** Pint and PHP_CodeSniffer on the staged PHP files, except the sniff fixtures. */
function php(files) {
    const checked = files.filter((file) => !file.includes(FIXTURES)).join(' ');

    if (checked === '') {
        return [];
    }

    return [`scripts/php vendor/bin/pint ${checked}`, `scripts/php vendor/bin/phpcs ${checked}`];
}

export default {
    '*.php': php,
    '*.{js,mjs,cjs}': 'eslint --max-warnings 0',
    // The check reads the files from disk, so it takes no file arguments.
    [CONTEXT_FILES]: () => 'scripts/php artisan context:check',
};
