---
type: doc
name: development-conventions
description: Normative conventions — quality gate, layer rules, doc comments and readability, naming, commits, branches, PRs, language
category: workflow
generated: 2026-11-02
status: filled
scaffoldVersion: "2.0.0"
---

# Development conventions

What is mandatory when changing this repository. Setup and step-by-step recipes are in
[development-workflow.md](development-workflow.md); this file holds only what must hold without
anything prompting it, written as commands.

## Quality gate

**Before every commit, run the gate** (it runs one check at a time; PHP runs in the Docker image):

```bash
make gate
```

It is exactly the CI, one job per check, every one of them a required check on `master`:

| CI job | Command | Catches |
| --- | --- | --- |
| `pint` | `composer pint` | Code style (Laravel preset, strict types, strict comparison, final classes) |
| `phpcs` | `composer phpcs` | Missing doc comments, doc-comment shape, commented-out code, untracked `TODO`, nesting, multi-line conditions |
| `phpstan` | `composer phpstan` | Larastan at max level, strict rules, cognitive complexity, dead code, undeclared checked exceptions |
| `phpmd` | `composer phpmd` | Unused parameters, variables and private members; more than 4 parameters; size and cyclomatic limits |
| `phpmnd` | `composer phpmnd` | Magic numbers |
| `deptrac` | `composer deptrac` | Layer rules |
| `rector` | `composer rector` | Pending PHP 8.4 / Laravel 13 upgrades, dead code, missing types (dry run) |
| `composer-unused` | `composer unused` | Composer packages nothing uses |
| `eslint` | `npm run lint` | JavaScript lint with the Sonar rules |
| `knip` | `npm run check:unused` | Unused JavaScript files, exports and npm packages |
| `test` | `composer test:coverage` | Pest, 80% line coverage |
| `composer-audit` | `composer audit` | Known vulnerabilities in Composer packages |
| `npm-audit` | `npm audit --omit=dev --audit-level=high` | Known vulnerabilities in runtime npm packages |
| `context` | `composer context:check` | Agent surfaces drifted from `.context/docs/README.md` |
| `commitlint` | (pull requests) | A commit that is not a Conventional Commit |

- Run checks **one at a time**. `make gate` does; do not run several of them in parallel on a small
  machine.
- The `pre-commit` hook runs Pint and PHP_CodeSniffer on the staged PHP files and ESLint on the staged
  JavaScript; `commit-msg` runs commitlint. They are a first filter, not the gate.
- A rule is fixed in the code, never silenced. No baseline files. A targeted ignore
  (`@phpstan-ignore <identifier>`, `// phpcs:ignore <Sniff>`, `@SuppressWarnings(...)`) is allowed only
  with a reason on the same line, and a reviewer may refuse it.

## Layer rules

Enforced by Deptrac (`deptrac.yaml`). Reasoning in [architecture.md](architecture.md) and
[ADR 0001](/docs/adr/0001-layered-architecture.md).

- `app/Domain/` depends on **nothing** outside itself except PHP's own classes: no Laravel, no
  Carbon, no `Illuminate\Support\Str`, no Eloquent.
- `app/Application/` depends only on `app/Domain/`.
- `app/Infrastructure/`, `app/Http/` and `app/Console/` may use vendor packages; Http and Console
  never use Infrastructure directly: they call Application handlers, and the provider injects the
  implementations.
- `app/Providers/` is the only place that binds an interface to an implementation.
- Controllers hold no business rule; a rule in a controller is a bug in review.

## Doc comments (PHPDoc)

Enforced by the local sniff `EletronTech.Commenting.RequirePublicDocComment`, Slevomat's docblock
sniffs and PHPStan.

- **Every class, interface, trait, enum and public method has a doc comment** that starts with one
  summary sentence saying what it does for the caller. Constructors are exempt; document their
  parameters with `@param` when the type does not say enough. `{@inheritDoc}` is accepted on an
  implementation of an interface method.
- `@param` and `@return` only when they add something the type does not say (a unit, a range, a
  generic: `@return list<SurfaceDrift>`). Use PHPDoc generics wherever Larastan needs them.
- `@throws` for every exception defined in `App\` that the method throws or lets escape. PHPStan
  treats them as checked exceptions and fails when one is missing or the declaration is too wide.
- One blank line after the summary and between tag groups; tag groups in this order: generics,
  `@property`/`@method`, `@var`/`@param`, `@return`, `@throws`, `@see`/`@deprecated`. No `@author`,
  `@package`, `@version`, `@copyright`, `@license`.
- Comments explain **why**, not what. No commented-out code (`Squiz.PHP.CommentedOutCode`, error). A
  `TODO` or `FIXME` names its issue: `TODO(#12): ...` (`EletronTech.Commenting.TodoWithIssue`).

## Readability rules

All enforced by a tool, at error level:

- Cognitive complexity at most **15** per method (PHPStan, `tomasvotruba/cognitive-complexity`);
  nesting at most **3** (`Generic.Metrics.NestingLevel`).
- At most **4** parameters (PHPMD `ExcessiveParameterList`). Beyond that, take a DTO.
- No magic numbers in `app/`, `database/` (except migrations, where a column length is the readable
  form) and `routes/`: name them as class constants (`phpmnd`). Tests are exempt: a literal is the
  readable form of a test case.
- One statement per line. A condition that does not fit in 120 characters is split with one operand
  per line and the operator leading (`SlevomatCodingStandard.ControlStructures.RequireMultiLineCondition`).
- One blank line around control structures and before `return` (Pint and Slevomat).
- `declare(strict_types=1)` in every file, `===` only, classes `final` unless designed for
  extension (Pint).
- No unused code: parameters, variables, private members (PHPMD), public members and classes nothing
  calls (`shipmonk/dead-code-detector`), Composer packages (`composer-unused`), npm packages and
  JavaScript exports (`knip`). Remove it; do not keep it "for later".

## Naming

- Intention-revealing names in the domain vocabulary of [glossary.md](glossary.md): `Room`, not
  `Comodo`; `ElectricalPoint`, not `PontoEletrico`; `Licence`, not `UserPackage`.
- No abbreviations except those in the glossary's list.
- Booleans read as predicates: `isActive`, `isCustom`, `hasExpired`.
- Units are types, not suffixes: `Power $power`, not `float $powerInWatts`.

## Language

Everything is in English: identifiers, comments, log and error messages, documentation, commit
messages, PR and issue text. User-facing text goes through Laravel's translation files, so the
Portuguese interface is a translation, not hard-coded strings.

## Branches, commits and pull requests

- `master` is the default branch and is never pushed to directly. Branch prefixes: `feat/`, `fix/`,
  `docs/`, `refactor/`, `chore/`, `test/`, `ci/`.
- Commits follow **Conventional Commits** (`type(scope): description`, lower-case subject), checked
  by commitlint in the `commit-msg` hook and, for every commit of a pull request, in CI.
- **The commit type is the version.** `feat` → minor; `fix`, `perf`, `refactor` → patch; a `!` after
  the type or a `BREAKING CHANGE:` footer → major; `docs`, `test`, `build`, `ci`, `chore`, `style` →
  no release.
- Small pull requests, one concern each; merged by squash, so the PR title is the commit on `master`
  and must itself be a Conventional Commit.
- The PR template asks for the what and why, the issue, the verification **as results**
  ("24/24 tests, coverage 93.2%"), and the risks.
- Link the issue with an English closing keyword (`Closes #12`); anything else does not link, silently.

## Context base

`.context/docs/` is the source. `AGENTS.md`, `.claude/CLAUDE.md` and
`.github/copilot-instructions.md` are copies of `.context/docs/README.md` written by
`php artisan context:export`; edit the source and re-export. Never generate the surfaces with the
dotcontext `exportDocs`, `exportContext` or `reverseSync` tools: they write targets this repository
does not control and re-import generated files as sources.
