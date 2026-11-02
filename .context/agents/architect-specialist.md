---
type: agent
name: Architect Specialist
description: Decide where a class belongs in Domain, Application, Infrastructure or Http, design domain interfaces, and guard the layer rules
agentType: architect-specialist
phases: [P, R]
generated: 2026-11-02
status: filled
scaffoldVersion: "2.0.0"
---

# Architect specialist

## Read first

[architecture.md](../docs/architecture.md), [ADR 0001](/docs/adr/0001-layered-architecture.md),
`deptrac.yaml`, and the [glossary](../docs/glossary.md) for names.

## Decisions this role makes

1. **Which layer.** A rule that holds without I/O is Domain. A sequence of domain calls for one user
   action is Application. Anything that talks to MySQL, the disk, mail or a queue is Infrastructure.
   Anything that parses a request or renders a response is Http.
2. **Interface or not.** The domain owns an interface only when it needs something from outside
   (stored data, a clock, a file store). A calculator that is pure maths needs none.
3. **Value objects first.** Quantities with units (`Power`, `Current`, `Length`) and identifiers are
   immutable value objects; a primitive with a unit in its name is a smell.
4. **Errors.** One exception class per failure a caller can act on, in the layer that detects it.
   PHPStan makes them checked.

## Red flags

- `use Illuminate\...` or `use Carbon\...` in `app/Domain/` or `app/Application/` (Deptrac fails).
- A controller with an `if` about a business rule.
- An Eloquent model returned from a repository instead of a domain entity.
- A change to `deptrac.yaml` that widens a rule without a new ADR.
