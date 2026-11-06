# 0003. Calculators as interchangeable domain services behind one contract

- Status: Accepted
- Date: 2026-11-05
- Issues: #5 (E2, electrical calculators), #6 (E3, general calculators)

## Context

The 2015 version had one page per calculator, each with its own form parsing, its own rounding and its
own way of saying that a field was empty, written three times (web, mobile, admin). E2 rebuilds the
twelve electrical tools, E3 adds the general ones, E5 sells them in packages and records each use.
Everything that is not the formula (listing the tools, describing their inputs, reading what a person
typed, showing the result, refusing a value) should exist once, so that a new tool is only its formula
and its inputs.

## Decision

- **One contract.** `App\Domain\Calculator\Calculator` has three methods: `id()` (a stable identifier
  such as `outlet-count`), `inputs()` (the input schema: a list of `InputField`, each a quantity with a
  default unit, a pure number or a choice among an enum's cases, required or optional) and
  `calculate(Inputs): Result`. Each tool is one final class implementing it (Strategy), in a folder per
  area: `Electrical/` (E2, and E3's Ohm's law, conductor resistance and series/parallel resistance),
  `Geometry/`, `Construction/`, `Mathematics/` and `Physics/` (E3).
- **A catalogue.** `CalculatorCatalog` holds the calculators by identifier, in the order they are
  offered; the composition root (`AppServiceProvider`) registers them. Adding a tool is a class and a
  line there.
- **Typed inputs.** `Inputs` carries what was typed, already read into quantities, exact numbers,
  option identifiers or texts, and hands each one out typed (`positiveQuantity('width', Length::class)`,
  `wholeNumber('days', 1)`, `choice('room_type', RoomType::class)`, `text('expression')`), refusing a
  missing value, a value of the wrong kind or one outside the tool's range with `InvalidInput` (the field
  and an `InputProblem`). A text input (E3) is handed over as typed for tools that read it themselves:
  the basic calculator's expression ([ADR 0004](0004-arithmetic-expressions-without-eval.md)) and the
  binary converter's number. Domain concepts with
  rules of their own are value objects: `RoomDimensions`, `TurnCount`, `Efficiency`, `EnergyTariff`,
  `ResistorBands`, and E1's `PowerFactor`.
- **A result with its steps.** `Result` holds the answers and the intermediate values a person would
  write down (the area, the room index, the factor read from a table), each a `ResultValue`: an exact
  number in the unit it is shown in, a pure number, or a text.
- **One use case for all tools.** `App\Application\Calculation\Calculate` reads the typed values by the
  schema (numbers with `NumberParser`, units from `UnitCatalogue`), runs the calculator and rounds every
  number once, to 12 significant digits, as the unit converter does. `ListCalculators` describes the
  schemas. `CalculatorController` exposes both as JSON (`GET /tools/calculators`,
  `POST /tools/calculators/{id}`); the pages are E9's.
- **Tables are data.** The NBR 5410 tables (lighting load, outlets per room, conductor capacity and
  minimum sections), the breaker ratings and the lumen-method factors are constant arrays in their own
  classes (`Electrical\Nbr5410\*`, `LuminaireTables`), read by small loops, not `if` chains.
- **Irrational values** (√3, π, the root of the power triangle) are computed by `RealNumbers` to 32
  significant digits, as ADR 0002 anticipated, and the rest of the calculation stays exact.
- **Solving for the missing value.** Tools that the 2015 version solved in any direction (conductance,
  inductance, motor efficiency; in E3 Ohm's law, conductor resistance, series/parallel resistance, rule
  of three, Bernoulli) take every value as optional and solve for the ones left empty;
  `Inputs::missing()` refuses any other count. Values with no solution (a resistor that would have to be
  negative, a triangle whose sides do not close) are `InputProblem::NoSolution` on the whole input.
- **A shape, then its dimensions.** Tools with several shapes (area and perimeter, surface area and
  volume) take the shape as a choice and every dimension any shape uses as optional; each shape is a
  small value object (`Rectangle`, `Triangle`, `Cone`...) behind `PlaneFigure` or `SolidFigure`, and
  reads only the dimensions it is given by.

## Alternatives considered

- **One use case and one form request per tool.** The most explicit, and what a tool with a special
  form may still get in E9; but it multiplies the same parsing, rounding and error mapping twelve
  times now and more in E3.
- **A calculator taking a typed input DTO of its own** (`OutletCountInput`). Stronger typing at the
  call site, but the edges could not run a tool they do not know, and the schema would have to be
  written a second time for forms. The schema plus typed getters gives both.
- **Tables in the database.** Editable by an admin, but the values are a standard's, change with a new
  edition of it and need tests; they belong in code next to the rule that reads them.
- **Floats for the irrational steps.** Simple, but the results would lose the exactness the rest of the
  chain keeps, and two runs of the same formula in a different order could disagree in the last digit.

## Consequences

- A new tool is one class implementing `Calculator`, its tests, and one line in the provider. The JSON
  endpoint, the error messages (`lang/en/calculators.php`) and the rounding come for free.
- Tool identifiers and input names are part of the public interface once pages and recorded uses refer
  to them; renaming one later needs a migration of what was stored.
- `Inputs` checks kinds at run time (a quantity of the wrong class is `WrongKind`), because the schema is
  data; PHPStan checks the calculator's own code through the generic getters.
- The NBR 5410 values are copied from the 2004 edition; a new edition means
  revisiting `Electrical\Nbr5410\`.
- The schema does not say which optional dimensions a shape reads; that is in the shape's code. A form
  that shows only the relevant fields needs that mapping (E9, see `tech-debt.md`).
