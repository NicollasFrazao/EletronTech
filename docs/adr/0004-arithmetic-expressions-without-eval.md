# 0004. Arithmetic expressions evaluated by a parser of our own, never `eval`

- Status: Accepted
- Date: 2026-11-05
- Issues: #6 (E3, general calculators)

## Context

The basic calculator of 2015 (`FEI/EletronTech Calc.php`, screen F13) built a string from its buttons
and ran it with JavaScript's `eval("result = " + text)`. Whatever reached that string ran as code, the
arithmetic was binary floating point (`0.1 + 0.2` gave `0.30000000000000004`), a division by zero showed
`Infinity`, and the button logic refused to type `((`. The mobile site's "equation calculator" added
square and curly brackets and a decimal comma, and never computed anything.

E3 moves the calculator to the server, behind the same contract as every other tool
([ADR 0003](0003-calculators-behind-one-contract.md)): the expression arrives as text in a JSON request.
Evaluating it with PHP's `eval` would run any PHP a person typed. The issue's checklist says it plainly:
the basic calculator parses expressions safely, without `eval`.

## Decision

- **A recursive-descent parser over a fixed grammar**, `App\Domain\Calculator\Mathematics\Expression`,
  evaluates while it parses:

  ```text
  sum     = product { ("+" | "-") product }
  product = signed { ("*" | "/") signed | implied product }
  signed  = ("+" | "-") signed | primary
  primary = number | "(" sum ")" | "[" sum "]" | "{" sum "}"
  ```

  The tokenizer accepts only numbers (decimal point or comma, optional exponent) and those symbols
  (plus `×`, `÷` and `−`); anything else refuses the whole text. A bracket written against a number or
  another bracket multiplies (`2(3 + 1)`, `(1 + 1)(2)`), as in the 2015 calculator and by hand; two
  numbers side by side are refused.
- **Exact arithmetic.** Every number goes through `NumberParser` (40 digits at most) into a
  `BigRational`, and every operation is exact; the use case rounds the result for display like any
  other ([ADR 0002](0002-exact-arithmetic-for-quantities.md)).
- **Bounded input.** At most 255 characters, which also bounds the nesting depth and the size of the
  numbers; the HTTP request refuses a longer value on its field.
- **Errors are reasons, not exceptions from the engine.** `InvalidExpression` carries an `InputProblem`
  (`NotAnExpression`, `DivisionByZero`, `TooLong`); the calculator turns it into `InvalidInput` on the
  `expression` field, so the person sees a message on the field they typed.
- **A text input kind.** The contract gained `InputKind::Text` (`InputField::text()`, `Inputs::text()`)
  for values the calculator reads itself; the binary converter uses it too.

## Alternatives considered

- **`eval`** (PHP) or a JavaScript `eval` in the browser. Runs arbitrary code; refused by the issue.
- **symfony/expression-language.** Safe and maintained, but it evaluates with PHP floats, has a
  grammar far larger than arithmetic (variables, functions, `matches`, arrays), and is a vendor package
  the Domain may not use (ADR 0001); wrapping it in Infrastructure would put a calculator's rule outside
  the Domain.
- **Shunting-yard into reverse Polish notation.** Equivalent in power; a recursive-descent parser reads
  like the grammar above, so each rule is one short method and the order of operations is visible.
- **Floats.** Simpler, and wrong in the last digit for ordinary decimal input; the rest of the
  application is exact.

## Consequences

- Adding an operator (a power `^`, a percentage) is a grammar change with its tests; nothing is
  accepted by accident.
- Implied products bind like explicit ones, left to right: `8 / 2(2 + 2)` is 16, as in most
  calculators; a person who means 1 writes `8 / (2(2 + 2))`.
- Long chains of divisions grow numerators and denominators; 255 characters keep them small.
