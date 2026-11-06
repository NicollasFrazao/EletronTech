---
type: doc
name: tooling
description: Every composer and npm script, git hook and CI job, its configuration file and what it catches
category: tooling
generated: 2026-11-02
status: filled
scaffoldVersion: "2.0.0"
---

# Tooling

Which tool enforces which rule of [development-conventions.md](development-conventions.md), and where
it is configured. The CI workflow is `.github/workflows/ci.yml`: one job per check, each a required
status check, named exactly as in the first column.

## PHP

| CI job | Script | Tool | Configuration |
| --- | --- | --- | --- |
| `pint` | `composer pint` (`pint:fix` to apply) | Laravel Pint | `pint.json` |
| `phpcs` | `composer phpcs` | PHP_CodeSniffer 4 + Slevomat + local sniffs | `phpcs.xml`, `phpcs/EletronTech/` |
| `phpstan` | `composer phpstan` | PHPStan + Larastan (max), `phpstan-strict-rules`, `tomasvotruba/cognitive-complexity`, `shipmonk/dead-code-detector` | `phpstan.neon` |
| `phpmd` | `composer phpmd` | PHPMD 3, `unusedcode` and `codesize` | `phpmd.xml` |
| `phpmnd` | `composer phpmnd` | PHP Magic Number Detector | arguments in `composer.json` |
| `deptrac` | `composer deptrac` | Deptrac 4 | `deptrac.yaml` |
| `rector` | `composer rector` | Rector 2 + `driftingly/rector-laravel`, dry run | `rector.php` |
| `composer-unused` | `composer unused` | composer-unused | — |
| `test` | `composer test:coverage` | Pest 4, pcov, `--min=80` | `phpunit.xml`, `tests/Pest.php` |
| `composer-audit` | `composer audit` | Composer | — |
| `context` | `composer context:check` | `php artisan context:check` | `app/Console/ContextBase/AgentSurfaces.php` |

`pint.json` overrides the Laravel preset's `phpdoc_separation` so that `@param` and `@return` stay in
separate groups, as `phpcs.xml` (Slevomat `DocCommentSpacing`) and the conventions require; with the
preset's default the two tools contradict each other on any doc comment that has both.

PHPStan, Rector and Deptrac cache under `storage/framework/cache/` and `.deptrac.cache`, both
git-ignored.

### Local sniffs (`phpcs/EletronTech/`)

- `Commenting.RequirePublicDocComment` — a class-like or public method without a doc comment, or
  whose comment does not start with a summary. Constructors exempt; `{@inheritDoc}` accepted.
- `Commenting.TodoWithIssue` — a `TODO`/`FIXME` not followed by `(#<issue>)`.

They are tested by `tests/Unit/CodingStandardTest.php` against `phpcs/tests/fixtures/`.

## JavaScript

| CI job | Script | Tool | Configuration |
| --- | --- | --- | --- |
| `eslint` | `npm run lint` | ESLint 10 + `eslint-plugin-sonarjs` (recommended, error level) | `eslint.config.js` |
| `knip` | `npm run check:unused` | knip | `knip.json` |
| `npm-audit` | `npm audit --omit=dev --audit-level=high` | npm | — |
| `commitlint` | — | commitlint, every commit of a pull request | `commitlint.config.js` |
| `CodeQL` | — | CodeQL `javascript-typescript`, `security-and-quality` | `.github/workflows/codeql.yml` |

## Git hooks

Installed by `make setup` (`npm run hooks`, which runs husky; `.npmrc` disables install scripts, so
`npm ci` alone does not).

- `pre-commit` → lint-staged (`lint-staged.config.js`): Pint (fixing) and PHP_CodeSniffer on staged
  PHP files, ESLint on staged JavaScript, `context:check` when the index or a surface is staged.
- `commit-msg` → commitlint.

PHP in the hooks goes through `scripts/php`: the host's PHP when it is 8.4 or newer, the `app` image
otherwise.

## Dependabot

`.github/dependabot.yml`: Composer, npm, GitHub Actions and the Docker images, weekly, with
Conventional Commit prefixes (`build` for dependencies, `ci` for actions).
