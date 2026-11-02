---
type: skill
name: Test Generation
description: Add Pest tests for a new domain rule, application handler, route or bug fix in this repository. Use when writing or extending tests
skillSlug: test-generation
phases: [E, V]
generated: 2026-11-02
status: filled
scaffoldVersion: "2.0.0"
---

# Test generation

1. Pick the folder by what is under test (see [agents/test-writer.md](../../agents/test-writer.md)):
   `tests/Unit/` for Domain and Application, `tests/Feature/` for Http, Console and Infrastructure.
2. List the behaviours: the normal case, each boundary, each domain error. For a calculator, take the
   examples from its screen in `docs/technical-documentation-pt-BR.pdf` (section 6.4).
3. Write one `it()` per behaviour; use a dataset for a table of cases.
4. For a bug, write the failing test first and keep it.
5. Run `make test`; coverage of `app/` must stay at 80% or more.
