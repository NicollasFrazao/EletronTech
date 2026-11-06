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
| `DatabaseSeeder` seeds nothing | The calculators are a catalogue in code (`CalculatorCatalog`, E2); the tools as rows that packages refer to arrive with the shop | #8 |
| Feature tests run on SQLite, production on MySQL 8.4 | No MySQL-specific behaviour exists yet; add a MySQL service to the `test` job with the first one | first Infrastructure repository |
| The home page is a placeholder without Vite assets | The interface is designed in E9 | #12 |
| No mutation testing | The calculators exist (E2) and are what it would protect; adding Infection to CI costs a job of several minutes, so it waits for a decision | to be decided (raised in the E2 pull request) |
| `docker compose up` serves with `php artisan serve` | Enough for development; a production image (FPM or FrankenPHP) is part of the release | #13 |
| `minimatch` is forced to 11 through `overrides` in `package.json` | ESLint 10 and `eslint-plugin-sonarjs` ask for `^10`, and GHSA-g3hv-75wg-m249 is fixed only in 11.0.1 | when both accept `minimatch` 11 |
| Some quantity methods carry a method-level `@api`: `Quantity::of()`, `zero()`, `rounded()`, `isEqualTo()`; `Unit::isEqualTo()`; `Precision::decimalPlaces()`; `Power::toWatts()`, `dividedByVoltage()`, `dividedByPowerFactor()`; `Voltage::dividedByCurrent()`, `dividedByResistance()`; `Current::timesVoltage()`; `Resistance::timesCurrent()`, `reciprocal()`; `Conductance::reciprocal()`; `Capacitance::timesVoltage()`; `Charge::toCoulombs()`, `dividedByCapacitance()` | No calculator of E2 calls them and the dead-code detector does not count test usages; E2 removed the class-level tags, so every other method is checked again. Remove each tag when E3 or the interface uses the method, or delete the method | #6, #12 |
| Unit names on the converter page are English, built by the domain (`kilowatt`), and the page has only English strings (`lang/en/unit-converter.php`) | The Portuguese interface and its translations are designed with the rest of the UI | #12 |
| A conversion or a calculation is not recorded as a tool use (`tb_utilizacao` in 2015) | Uses are recorded per user, and accounts and licences arrive later | #7, #8 |
| The calculators have no pages and no translated names or input labels: `/tools/calculators` answers identifiers (`outlet-count`, `room_type`) as JSON | The interface is designed with the rest of the UI | #12 |
| The utilisation factors of `LuminaireTables` are the 2015 table, whose luminaire is not named; its 80/30/10 column is not monotonic (at K = 1.5 it is above 80/50/10) | Kept as the 2015 values until the source table is found or a luminaire's own table replaces it | to be decided (raised in the E2 pull request) |
| `composer audit` reports abandoned packages instead of failing (`config.audit.abandoned: report`) | `symplify/rule-doc-generator-contracts`, abandoned, comes with `tomasvotruba/cognitive-complexity`; vulnerabilities still fail the job | when the extension drops it |
