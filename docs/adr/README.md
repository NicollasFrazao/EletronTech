# Architecture decision records

One file per decision that shaped the code and would be expensive to reverse. Each says what was
decided, what else was considered, and what it costs. A superseded record stays, marked as such.

| # | Decision | Status |
| --- | --- | --- |
| [0001](0001-layered-architecture.md) | Layered architecture with Laravel only at the edges, enforced by Deptrac | Accepted |
| [0002](0002-exact-arithmetic-for-quantities.md) | Exact arithmetic for physical quantities with brick/math; amends 0001 so the Domain may use `Brick\Math` | Accepted |
| [0003](0003-calculators-behind-one-contract.md) | Calculators as interchangeable domain services behind one `Calculator` contract, with a catalogue, an input schema and NBR 5410 tables as data | Accepted |
