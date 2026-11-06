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
| The quantity classes (`app/Domain/Quantity/`: `Quantity` and its subclasses, `Unit`, `Precision`, `PowerFactor`) are marked `@api` | Nothing in `app/` calls most of their methods before the calculators exist, and the dead-code detector does not count test usages; the tag tells it they are public API. Remove the tag from each class once a calculator uses it, so dead methods are reported again | #5, #6 |
| Unit names on the converter page are English, built by the domain (`kilowatt`), and the page has only English strings (`lang/en/unit-converter.php`) | The Portuguese interface and its translations are designed with the rest of the UI | #12 |
| A conversion is not recorded as a tool use (`tb_utilizacao` in 2015) | Uses are recorded per user, and accounts and licences arrive later | #7, #8 |
| `composer audit` reports abandoned packages instead of failing (`config.audit.abandoned: report`) | `symplify/rule-doc-generator-contracts`, abandoned, comes with `tomasvotruba/cognitive-complexity`; vulnerabilities still fail the job | when the extension drops it |
