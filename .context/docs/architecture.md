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

- **A calculation** (breaker sizing, lighting, outlet count): a class implementing
  `App\Domain\Calculator\Calculator` in `app/Domain/Calculator/<Area>/`, registered in the catalogue,
  taking and returning value objects (`Power`, `Current`, `Length`), never floats with a unit in the
  variable name. Its validation errors are `InvalidInput`. See "Calculators" below.
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
  `Current`, `Power`, `ApparentPower`, `ReactivePower`, `Resistance`, `Conductance`, `Capacitance`,
  `Inductance`, `MagneticFlux`, `Charge`, `Energy`, `Frequency`, `Duration`, `Length`, `Area`,
  `LuminousFlux`, `Illuminance`, `Volume`, `Pressure`, `Velocity`, `Density`, `Resistivity`, plus the
  dimensionless `PowerFactor` (E2 added six that its calculators needed, E3 the last five). Each stores an exact
  `BigRational` in the coherent SI unit and has a named constructor and reader in it
  (`Power::fromWatts()`, `->toWatts()`); `Quantity::of($value, $unit)` and `->in($unit)` take any unit
  of the dimension.
- **Arithmetic** within a kind (`plus`, `minus`, `multipliedBy` a number, `dividedBy` a number,
  `ratioTo`, comparisons) is on `Quantity`, with `static` parameters so PHPStan refuses a voltage plus a
  current. Arithmetic **between** kinds exists only where it means something and lives on the
  subclasses: `Voltage::timesCurrent(): Power`, `Power::dividedByVoltage(): Current`, Ohm's law,
  `Resistance::reciprocal(): Conductance`, `Current::dividedByVoltage(): Conductance`,
  `Capacitance::timesVoltage(): Charge`, `Length::timesLength(): Area`,
  `ApparentPower::timesPowerFactor(): Power`, `Power::timesDuration(): Energy`,
  `Illuminance::timesArea(): LuminousFlux`, `MagneticFlux::dividedByCurrent(): Inductance` (flux
  linkage over current), `Area::timesLength(): Volume`, `Density::dynamicPressureAt(Velocity)` and
  `Density::hydrostaticPressureAt(Length)` (½ρv² and ρg₀h, with standard gravity),
  `Resistivity::resistanceOf(Length, Area)` (Ohm's second law), and their inverses.
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

## Calculators

`app/Domain/Calculator/` is the contract every tool implements
([ADR 0003](/docs/adr/0003-calculators-behind-one-contract.md)):

- `Calculator` (Strategy): `id()`, `inputs()` (the input schema, a list of `InputField`: a quantity
  with its default unit, a pure number, a choice among an enum's cases, or a text the calculator reads
  itself; required or optional) and `calculate(Inputs): Result`. `CalculatorCatalog` finds one by
  identifier; the provider registers them in the order they are offered.
- `Inputs` hands each value out typed and validated (`positiveQuantity()`, `wholeNumber()`,
  `choice()`, `text()`, `missing()` for the tools that solve for the values left empty) and throws
  `InvalidInput` with the field and an `InputProblem` (`NoSolution` when the values admit no answer). `Result` holds the answers and the intermediate
  values as `ResultValue`s, exact, each with the unit it is shown in.
- `RealNumbers` gives π and square roots to 32 significant digits; `FixedUnit` names a unit in code.
- `Electrical/` holds the twelve tools of E2, one class each, with their value objects
  (`RoomDimensions`, `TurnCount`, `Efficiency`, `EnergyTariff`, `ResistorBands`) and enums
  (`SupplySystem`, `CircuitPurpose`, `RoomType`, `LightingSystem`, ...). Tables are data in their own
  classes: `Electrical/Nbr5410/` (`LightingLoad`, `OutletRequirements`, `ConductorTable`,
  `BreakerRatings`) and `LuminaireTables` (lumen-method factors). E3 added `OhmsLaw`,
  `ConductorResistance` and `SeriesParallelResistance` there (the rest of the 2015 resistor tool).
- E3's general tools ([ADR 0004](/docs/adr/0004-arithmetic-expressions-without-eval.md) for the
  expressions): `Geometry/` (`AreaAndPerimeter` and `SurfaceAreaAndVolume`, one small value object per
  shape behind `PlaneFigure` and `SolidFigure`), `Mathematics/` (`BasicCalculator` on `Expression`, a
  recursive-descent parser over exact fractions; `BinaryConverter`; `RuleOfThree`), `Physics/`
  (`BernoulliEquation` with `FlowPoint`) and `Construction/` (`FloorAndWallTiles` and `BlockCount`
  sharing `MaterialCount` and `WasteAllowance`; `BtuSizing`).

`App\Application\Calculation\Calculate` runs any of them: it reads the typed values by the schema, calls
the calculator and rounds each number to 12 significant digits; `ListCalculators` describes the schemas.
`App\Http\Controllers\Tools\CalculatorController` serves both as JSON (`GET /tools/calculators`,
`POST /tools/calculators/{id}`), mapping `InvalidInput` to a validation error on its field.

## Errors

Domain and Application code throws its own exception classes, one per failure the caller can act
on (`InvalidDimension`, `LicenceExpired`). PHPStan treats every exception in `App\` as **checked**
(`phpstan.neon`, `exceptions.checkedExceptionRegexes`): a method that throws one, or lets one escape,
declares it with `@throws`, so the caller sees it in the signature. Http maps them to responses.

## Current state

E0 laid the foundation: the folders, the rules, the gate. E1 (#4) added the physical quantities
(`app/Domain/Quantity/`) and the unit converter, the first use case (`app/Application/UnitConversion/`)
and the first controller (`app/Http/Controllers/Tools/`). E2 (#5) added the calculator contract and
the twelve electrical calculators (`app/Domain/Calculator/`), the use case that runs any of them
(`app/Application/Calculation/`) and their JSON endpoint. E3 (#6) added twelve general calculators on
the same contract, so every 2015 calculation tool, web or mobile, is in the catalogue (the mobile
spirit level reads a sensor and is not a calculation; see [tech-debt.md](tech-debt.md)). The rest is the
context-base tooling in `app/Console/` (`context:export`, `context:check`) and the framework defaults.
