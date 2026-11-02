---
type: doc
name: tech-debt
description: Known gaps of the foundation, each with its issue or the phase that closes it
category: reference
generated: 2026-11-02
status: filled
scaffoldVersion: "2.0.0"
---

# Technical debt

Every entry names the issue or phase that closes it. Deferred work in code is a `TODO(#N)` that
points here or to the issue.

| Item | Why it is still open | Closes in |
| --- | --- | --- |
| `App\Infrastructure\Persistence\Eloquent\User` is the framework default user, not the domain account | Accounts are modelled with their rules in E4 | #7 |
| `DatabaseSeeder` seeds nothing | The tool and package catalogue arrives with the calculators and the shop | #5, #8 |
| Feature tests run on SQLite, production on MySQL 8.4 | No MySQL-specific behaviour exists yet; add a MySQL service to the `test` job with the first one | first Infrastructure repository |
| The home page is a placeholder without Vite assets | The interface is designed in E9 | #12 |
| No mutation testing | Worth it once there are calculators to protect | #5 |
| `docker compose up` serves with `php artisan serve` | Enough for development; a production image (FPM or FrankenPHP) is part of the release | #13 |
| `minimatch` is forced to 11 through `overrides` in `package.json` | ESLint 10 and `eslint-plugin-sonarjs` ask for `^10`, and GHSA-g3hv-75wg-m249 is fixed only in 11.0.1 | when both accept `minimatch` 11 |
| `composer audit` reports abandoned packages instead of failing (`config.audit.abandoned: report`) | `symplify/rule-doc-generator-contracts`, abandoned, comes with `tomasvotruba/cognitive-complexity`; vulnerabilities still fail the job | when the extension drops it |
