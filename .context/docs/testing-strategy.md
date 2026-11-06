---
type: doc
name: testing-strategy
description: Pest, unit and feature tests, the coverage gate and what each layer is tested with
category: testing
generated: 2026-11-02
status: filled
scaffoldVersion: "2.0.0"
---

# Testing strategy

Pest 4 on PHPUnit 12. `composer test:coverage` (CI job `test`) runs every test with pcov and fails
under **80% line coverage** of `app/`.

## Suites

| Folder | Boots Laravel | For |
| --- | --- | --- |
| `tests/Unit/` | No | Domain and Application code, built with `new`; the local PHP_CodeSniffer sniffs |
| `tests/Feature/` | Yes (`Tests\TestCase`, set in `tests/Pest.php`) | HTTP routes, Artisan commands, Infrastructure against the database |

Most tests belong in `tests/Unit/`: a domain calculation has inputs and outputs and needs no
container. A feature test proves the wiring (route → handler → response), not every case of the rule.

## Database

Feature tests run on SQLite in memory (`phpunit.xml`), with `RefreshDatabase` where a test writes.
Anything that depends on MySQL behaviour (JSON columns, collations, locking) gets a test that runs
against MySQL and is marked so; add a MySQL service to the `test` job when the first one appears.

## Writing tests

- One behaviour per test, named as a sentence: `it('rejects a room with a negative width')`.
- Arrange, act, assert, separated by blank lines.
- Calculators: test the values of the technical documentation's examples and the NBR 5410 tables
  they rely on, including the boundaries (the smallest and largest valid input, the first invalid one).
- Use Pest datasets for tables of inputs and expected outputs.
- Literals are fine in tests (no magic-number rule there).
- **Property-based tests** for laws that hold for every input (a conversion and its inverse, Ohm's
  law both ways, rounding within half a unit): `Tests\Support\Property::check($runs, $generators,
  $assertion)` runs the assertion with [Eris](https://github.com/giorgiosironi/eris) generators and
  shrinks a failure to a small counterexample. The seed changes on every run; a failure prints
  `ERIS_SEED=...`, and `ERIS_SEED=<seed> composer test` reproduces it.
- A bug fix comes with a test that fails before the fix.

## Current tests

- `tests/Feature/SmokeTest.php` — the home page and `/up` answer 200.
- `tests/Feature/ContextCommandsTest.php` — `context:export` and `context:check` on a temporary
  directory: export, drift report, missing surface, missing index.
- `tests/Unit/CodingStandardTest.php` — the local sniffs on the fixtures in `phpcs/tests/fixtures/`.
- `tests/Unit/Domain/Quantity/` — units and the catalogue, exact conversions (every kind of unit,
  against known values), arithmetic within and between quantities, `Precision`, `NumberParser`, and
  `ConversionPropertiesTest.php`, the property-based round trips and laws.
- `tests/Unit/Application/UnitConversion/` — the converter use cases.
- `tests/Feature/UnitConverterTest.php` — the converter page and its JSON answer, and each
  validation error on its field.

## Coverage

Line coverage of `app/` only. Mutation testing (Infection) is optional and not in CI yet; consider it
when the calculators arrive in E2 (#5).
