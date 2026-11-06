# 0002. Exact arithmetic for physical quantities with brick/math

- Status: Accepted
- Date: 2026-11-05
- Issues: #4 (E1, physical quantities)
- Amends: [0001](0001-layered-architecture.md) — the Domain may depend on `Brick\Math`

## Context

Every calculator works on voltages, currents, powers, lengths and areas, and shows the result to a
person. The 2015 version did this with JavaScript floats, where `0.1 + 0.2` is `0.30000000000000004`:
the unit converter multiplied and divided floats by literals such as `1000000000000000000` and printed
whatever came out, and each page rounded (or not) in its own way. E1 needs
quantities whose conversions and sums are exact, and one rounding rule applied only to what is
displayed.

Units make the problem harder than decimals alone: a third of a unit is common (`1 ft` in yards,
`1 C` in ampere-hours is `1/3600`), and several conversion factors are fractions with no finite
decimal form (`1 statC = 1/2997924580 C`). A decimal type with a fixed number of places loses
digits on every such division, so a conversion followed by its inverse does not return the input.

ADR 0001 lets the Domain depend on nothing but PHP's own classes.

## Decision

- **Values are exact fractions.** Quantities store their value as a `Brick\Math\BigRational` in the
  coherent SI unit of their dimension (volts, amperes, watts, metres...). Unit sizes are exact
  decimals or fractions written as strings (`'745.69987158227022'`, `'1/2997924580'`), never floats.
  A conversion is one multiplication and one division of fractions, so converting to any unit and
  back returns the input exactly; property-based tests check that on generated values and units.
- **Rounding happens once, for display.** `App\Domain\Quantity\Precision` rounds a value to
  significant digits or decimal places, always **half up** (`0.125` to two places is `0.13`, `-0.125`
  is `-0.13`), the rule people apply by hand. Nothing else in the domain rounds.
- **User input is parsed with limits.** `NumberParser` accepts integers, decimals and scientific
  notation up to 40 digits, as written and once expanded, so `1e999999999` is rejected instead of
  allocating gigabytes.
- **brick/math is a layer of its own in Deptrac** (`Math`, `^Brick\\Math\\`), which every layer may
  depend on, like PHP's own number types. It is not in the `Vendor` layer, so this does not open the
  Domain to any other package. `brick/math` is a direct dependency in `composer.json` (Laravel already
  required it, so the vendor tree does not grow).

## Alternatives considered

- **bcmath, through PHP 8.4's `BcMath\Number`.** In PHP itself, so no layer rule changes, and the
  Docker image already has the extension. But it is a decimal with a chosen scale: every division
  by a factor such as `3600` or `2997924580` rounds, so a round trip is exact only up to that scale
  and the tests would need tolerances. Building exact fractions on top of it means writing and
  testing our own rational type (normalisation, gcd, comparison), which brick/math already is.
- **Floats with rounding at the end.** The approach of 2015; the drift it causes is what this phase
  removes.
- **Integers in the smallest unit** (nanovolts, micrometres). Exact for sums, but the range a
  converter needs (from `10⁻¹⁹ C` to gigawatts) overflows 64-bit integers, and divisions still round.
- **A units library** (`php-units-of-measure` and similar). They convert with floats and model units
  as strings, so they would bring back the drift and lose the typed arithmetic (`Voltage × Current →
  Power`) that the calculators need.

## Consequences

- A Domain class may `use Brick\Math\...`; anything else outside `App\` is still refused by Deptrac.
  Calculators take and return quantities, and get exact intermediate results for free.
- brick/math is a dependency whose breaking changes reach the Domain. It follows semantic
  versioning since 1.0; the constraint is `^1.0`.
- Rational values can grow long numerators and denominators in long chains of divisions. The
  calculators do a handful of operations per request, so this is not a concern now; a calculator
  that iterates would round with `Precision` at a documented step.
- The quantities share their arithmetic through an abstract `Quantity` class rather than a trait, an
  exception to the composition-over-inheritance default of 0001: its parameters are typed `static`, so
  PHPStan refuses `$voltage->plus($current)`; the dead-code detector reads `@api` on it (it does not on a
  trait's methods); and every subclass is `final` and only adds its unit and its operations with other
  kinds, so there is no hierarchy to grow.
- Irrational results (square roots for impedance, π for reactance) cannot be fractions: the
  calculators of E2 (#5) will compute them as `BigDecimal` with a stated number of digits.
- The quantity classes are the shared kernel of E2 and E3; until those phases call them, the dead
  code detector would report their public methods as unused. They are marked `@api`, which the
  detector reads as "public API", and the tag is removed once the calculators use them
  ([tech-debt.md](/.context/docs/tech-debt.md)).
