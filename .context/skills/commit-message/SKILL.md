---
type: skill
name: Commit Message
description: Write a Conventional Commit that passes commitlint and sets the right version bump. Use when committing or naming a pull request
skillSlug: commit-message
phases: [E, C]
generated: 2026-11-02
status: filled
scaffoldVersion: "2.0.0"
---

# Commit message

Format: `type(scope): description`, lower-case, imperative, no final period, in English.

- **The type is the version**: `feat` → minor; `fix`, `perf`, `refactor` → patch; `!` or a
  `BREAKING CHANGE:` footer → major; `docs`, `test`, `build`, `ci`, `chore`, `style` → no release.
- Scope: the area, from the glossary or the folder: `calculators`, `licences`, `floor-plan`,
  `accounts`, `files`, `events`, `admin`, `context`, `docker`, `ci`.
- Body: why, and what was wrong before when it is a fix. Wrap at 100 columns.
- Footer: `Closes #N` with an English keyword.

Examples:

```
feat(calculators): size the breaker and wire gauge from power and voltage

Ports screen F18 of the technical documentation. The v1 version rounded the
current down before choosing the breaker; this one rounds up, as NBR 5410 asks.

Closes #5
```

```
docs(context): add the floor-plan terms to the glossary
```

The PR is merged by squash, so its title must also follow this format.
