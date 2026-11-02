# EletronTech: context index

The knowledge base of this repository, for people and for coding agents. Start with the project
overview, then open the guide the task needs.

## Mandatory for anyone editing this repository

**Before editing any file, read [`development-conventions.md`](/.context/docs/development-conventions.md).**
It is the normative file: the quality gate to run before every commit, the layer rules, the
documentation and readability rules the tools enforce, commits and branches, and the language
everything is written in. Its rules are commands, not background reading.

Three more readings, each with the moment it applies:

- **before adding a class to `app/`** — [`architecture.md`](/.context/docs/architecture.md), section
  "Layers", and [ADR 0001](/docs/adr/0001-layered-architecture.md);
- **before porting a feature from the 2015 version** — [`project-overview.md`](/.context/docs/project-overview.md),
  section "The original as the functional reference", and the [glossary](/.context/docs/glossary.md)
  for the English name of each Portuguese term;
- **before writing a test** — [`testing-strategy.md`](/.context/docs/testing-strategy.md).

> **This file is the source of the agent surfaces.** `AGENTS.md`, `.claude/CLAUDE.md` and
> `.github/copilot-instructions.md` are byte-for-byte copies of `.context/docs/README.md`, written by
> `php artisan context:export` and verified by `php artisan context:check` (the `context` CI job).
> Edit this file, never a copy. The rules themselves are not copied into the surfaces: they live in
> `development-conventions.md`, one hop away, so there is a single place to change them.

## Guides

| Guide | What it answers |
| --- | --- |
| [Project overview](/.context/docs/project-overview.md) | What EletronTech does, for whom, the 2015 original and the v2 roadmap |
| [Architecture](/.context/docs/architecture.md) | Layers and their dependency rules, where each kind of class goes |
| [Development conventions](/.context/docs/development-conventions.md) | **Normative.** Quality gate, code and doc-comment rules, commits, branches, PRs, language |
| [Development workflow](/.context/docs/development-workflow.md) | Setup with Docker, day-to-day commands, recipes |
| [Testing strategy](/.context/docs/testing-strategy.md) | Pest, unit and feature tests, the 80% coverage gate |
| [Glossary](/.context/docs/glossary.md) | Domain vocabulary, English ↔ Portuguese of the original, allowed abbreviations |
| [Security](/.context/docs/security.md) | What the original got wrong, the rules for v2, how to report a vulnerability |
| [Tooling](/.context/docs/tooling.md) | Every composer and npm script, hook and CI job, and what each one catches |
| [Technical debt](/.context/docs/tech-debt.md) | Known gaps, each with its issue |
| [Decision records](/docs/adr/README.md) | Why the code is organised the way it is |

## Agents and skills

Playbooks tailored to this repository, for agents that support them:

- [`agents/architect-specialist.md`](/.context/agents/architect-specialist.md), [`agents/code-reviewer.md`](/.context/agents/code-reviewer.md), [`agents/test-writer.md`](/.context/agents/test-writer.md)
- [`skills/code-review`](/.context/skills/code-review/SKILL.md), [`skills/commit-message`](/.context/skills/commit-message/SKILL.md), [`skills/test-generation`](/.context/skills/test-generation/SKILL.md)

## Repository map

- `app/Domain/` — entities, value objects, domain services, repository interfaces, domain errors; no framework
- `app/Application/` — use cases (command handlers) and DTOs; depends only on the domain
- `app/Infrastructure/` — Eloquent repositories, storage, mail, queues
- `app/Http/` — controllers, form requests, resources
- `app/Console/` — Artisan commands (`context:export`, `context:check`)
- `app/Providers/` — the composition root: interface → implementation bindings
- `resources/views/`, `resources/js/`, `resources/css/` — Blade views and the Vite assets
- `tests/Unit/`, `tests/Feature/` — Pest
- `phpcs/EletronTech/` — local PHP_CodeSniffer sniffs (doc comments, `TODO` with an issue)
- `docker/`, `docker-compose.yml`, `Makefile` — the local environment and the gate
- `docs/technical-documentation-pt-BR.pdf` — the 2015 technical documentation, the functional reference
- `docs/adr/` — architecture decision records
- `.github/` — CI, CodeQL, Dependabot, PR and issue templates, CODEOWNERS
