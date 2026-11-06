---
type: doc
name: architecture
description: The four layers, their dependency rules, where each kind of class goes, and why
category: architecture
generated: 2026-11-02
status: filled
scaffoldVersion: "2.0.0"
---

# Architecture

Laravel only at the edges. The calculations, the licence rules and the floor-plan geometry are plain
PHP objects that a test can build with `new`; the framework delivers requests to them and stores
what they return. The decision and its alternatives are in
[ADR 0001](/docs/adr/0001-layered-architecture.md).

## Layers

| Layer | Folder | Holds | May depend on |
| --- | --- | --- | --- |
| Domain | `app/Domain/` | Entities, value objects, domain services, repository interfaces, domain errors | Itself, PHP and brick/math |
| Application | `app/Application/` | Use cases (one handler per command or query), input and output DTOs | Domain, brick/math |
| Infrastructure | `app/Infrastructure/` | Eloquent models and repositories, file storage, mail, queues, PDF export | Domain, Application, vendor packages |
| Http | `app/Http/` | Controllers, form requests, API resources, middleware | Domain, Application, vendor packages |
| Console | `app/Console/` | Artisan commands | Domain, Application, vendor packages |
| Providers | `app/Providers/` | The composition root: binds each domain interface to its implementation | Everything |

"PHP" means the language and its bundled classes (`DateTimeImmutable`, `RuntimeException`,
`Stringable`): they belong to no layer, so every layer may use them. `Brick\Math` (exact numbers)
is the `Math` layer, open to every layer for the same reason
([ADR 0002](/docs/adr/0002-exact-arithmetic-for-quantities.md)). Everything else outside `App\`
(Laravel, Symfony, Carbon, any other Composer package) is the `Vendor` layer of `deptrac.yaml`.

The rules are checked by **Deptrac** (`composer deptrac`, CI job `deptrac`). A violation is fixed by
moving the code or adding an interface in the domain, never by widening the rule; widening it needs a
new ADR.

## Where things go

- **A calculation** (breaker sizing, lighting, outlet count): a domain service in
  `app/Domain/<Area>/`, taking and returning value objects (`Power`, `Current`, `Length`), never
  floats with a unit in the variable name. Its validation errors are domain errors.
- **A rule that needs stored data** (is this tool in the user's licence?): the domain defines the
  repository interface; Infrastructure implements it with Eloquent; a provider binds them.
- **A user action** (acquire a package, save a room): an Application handler with an input DTO. The
  controller builds the DTO from a form request, calls the handler, maps the result to a view or a
  resource. Controllers hold no rules.
- **Eloquent models** live in `app/Infrastructure/Persistence/Eloquent/` and never leave it: a
  repository maps them to domain entities. The default `User` model is there for the framework's
  auth guard until accounts are modelled (E4, #7).
- **Framework glue** (middleware, jobs, mailables, notifications): Infrastructure or Http, by who
  calls it.

## Physical quantities

`app/Domain/Quantity/` is the kernel every calculator builds on
([ADR 0002](/docs/adr/0002-exact-arithmetic-for-quantities.md)):

- **Value objects**, one final class per quantity, all extending the abstract `Quantity`: `Voltage`,
  `Current`, `Power`, `ApparentPower`, `Resistance`, `Conductance`, `Capacitance`, `Inductance`,
  `Charge`, `Frequency`, `Length`, `Area`, plus the dimensionless `PowerFactor`. Each stores an exact
  `BigRational` in the coherent SI unit and has a named constructor and reader in it
  (`Power::fromWatts()`, `->toWatts()`); `Quantity::of($value, $unit)` and `->in($unit)` take any unit
  of the dimension.
- **Arithmetic** within a kind (`plus`, `minus`, `multipliedBy` a number, `dividedBy` a number,
  `ratioTo`, comparisons) is on `Quantity`, with `static` parameters so PHPStan refuses a voltage plus a
  current. Arithmetic **between** kinds exists only where it means something and lives on the
  subclasses: `Voltage::timesCurrent(): Power`, `Power::dividedByVoltage(): Current`, Ohm's law,
  `Resistance::reciprocal(): Conductance`, `Capacitance::timesVoltage(): Charge`,
  `Length::timesLength(): Area`, `ApparentPower::timesPowerFactor(): Power`, and their inverses.
- **Units**: `BaseUnit` (SI and the other units the 2015 converter offered, each with its exact size),
  `Prefix` (pico to giga), `Unit` (a base unit with a prefix it is offered with) and `UnitCatalogue`
  (every unit by identifier, such as `kilowatt`, or by `Dimension`).
- **Display**: `Precision` rounds half up to significant digits or decimal places; it is the only
  place that rounds. `NumberParser` reads a typed number with a digit limit.
- Quantities accept negative values; whether a negative input is valid is the calculator's rule.

The unit converter is the first tool on top of it: `App\Application\UnitConversion\ConvertQuantity`
(input DTO in, result DTO of strings out), `ListConvertibleUnits`, and
`App\Http\Controllers\Tools\UnitConverterController` at `/tools/unit-converter` (a form, or JSON
for a client that asks for it).

## Errors

Domain and Application code throws its own exception classes, one per failure the caller can act
on (`InvalidDimension`, `LicenceExpired`). PHPStan treats every exception in `App\` as **checked**
(`phpstan.neon`, `exceptions.checkedExceptionRegexes`): a method that throws one, or lets one escape,
declares it with `@throws`, so the caller sees it in the signature. Http maps them to responses.

## Current state

E0 laid the foundation: the folders, the rules, the gate. E1 (#4) added the physical quantities
(`app/Domain/Quantity/`) and the unit converter, the first use case (`app/Application/UnitConversion/`)
and the first controller (`app/Http/Controllers/Tools/`). The rest is the context-base tooling in
`app/Console/` (`context:export`, `context:check`) and the framework defaults.
