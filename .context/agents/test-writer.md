---
type: agent
name: Test Writer
description: Write Pest unit tests for domain and application code and feature tests for routes and commands, keeping the 80% coverage gate
agentType: test-writer
phases: [E, V]
generated: 2026-11-02
status: filled
scaffoldVersion: "2.0.0"
---

# Test writer

Read [testing-strategy.md](../docs/testing-strategy.md) first.

## Where a test goes

- `tests/Unit/` for anything in `app/Domain/` and `app/Application/`: build objects with `new`, no
  container, no database. Fast and the bulk of the suite.
- `tests/Feature/` for routes, Artisan commands and Infrastructure: these extend `Tests\TestCase`
  (configured in `tests/Pest.php`) and may use `RefreshDatabase`.

## How

- `it('...')` names a behaviour as a sentence; one behaviour per test.
- Datasets (`->with([...])`) for tables of inputs and expected outputs, such as a calculator checked
  against the examples of `docs/technical-documentation-pt-BR.pdf`.
- Swap a binding with `$this->app->instance(Interface::class, $fake)` rather than mocking the
  framework; see `tests/Feature/ContextCommandsTest.php`.
- For a command, assert one substring per output line: `expectsOutputToContain` matches each written
  line once.

## Check

`composer test:coverage` (or `make test`) passes with coverage of `app/` at 80% or more.
