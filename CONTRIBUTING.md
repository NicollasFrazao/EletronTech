# Contributing

Thanks for taking the time. The bar is rules that are correct against the technical documentation
and NBR 5410, in code a reviewer can read in one sitting.

The full rules are in [`.context/docs/development-conventions.md`](.context/docs/development-conventions.md).
This page is the short version.

## Setup

```bash
make setup   # composer install (in Docker), npm ci, git hooks
make up      # app, queue worker, MySQL 8.4, Mailpit
```

PHP runs in the Docker image; the host needs Docker and Node.js 22.

## Branches

Branch from `master`, named by the kind of change:

| Prefix | For |
| --- | --- |
| `feat/` | a new capability |
| `fix/` | a defect |
| `docs/` | documentation only |
| `refactor/` | a structural change with no behaviour change |
| `chore/` | maintenance, dependencies |
| `test/` | tests only |
| `ci/` | workflows |

## Commits

[Conventional Commits](https://www.conventionalcommits.org/), checked by commitlint in the
`commit-msg` hook and, in CI, on every commit of a pull request:

```
fix(calculators): round the current up before choosing the breaker

The v1 formula rounded down, which picked a breaker one size too small for
loads just above a standard rating.

Closes #5
```

**The commit type is the version**: `feat` → minor; `fix`, `perf`, `refactor` → patch; `!` after the
type or a `BREAKING CHANGE:` footer → major; `docs`, `test`, `build`, `ci`, `chore`, `style` → no
release. Pull requests are merged by squash, so the PR title follows the same format.

## Before pushing: the local gate

```bash
make gate
```

It runs, one at a time, exactly the CI jobs: `pint`, `phpcs`, `phpstan`, `phpmd`, `phpmnd`,
`deptrac`, `rector`, `composer-unused`, `eslint`, `knip`, `test` (80% coverage), `composer-audit`,
`npm-audit` and `context`. If they pass locally, CI passes. `make fix` applies the Pint and Rector fixes.

## Pull requests

- Small, one concern each. A refactor and a behaviour change are two pull requests.
- Fill in the template. Verification states **results** ("24/24 tests, coverage 93.2%"), not "tested".
- Link the issue with an English closing keyword: `Closes #12`. Other words do not link.
- A ported feature names the screen of the technical documentation it comes from and any mistake of
  v1 it fixes.

## Language

Code, comments, docs, commits, issues and pull requests are in English. Domain names come from the
[glossary](.context/docs/glossary.md), which maps them to the Portuguese of the original.

## Repository settings (maintainers)

- **Branch ruleset on `master`**: pull request required, squash only, linear history, no force push
  or deletion, and every CI job above plus `commitlint` and `CodeQL` as required status checks.
- **Code security**: secret scanning, push protection, Dependabot alerts and security updates, and
  private vulnerability reporting (used by [SECURITY.md](SECURITY.md)).
