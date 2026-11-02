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
| Domain | `app/Domain/` | Entities, value objects, domain services, repository interfaces, domain errors | Itself and PHP |
| Application | `app/Application/` | Use cases (one handler per command or query), input and output DTOs | Domain |
| Infrastructure | `app/Infrastructure/` | Eloquent models and repositories, file storage, mail, queues, PDF export | Domain, Application, vendor packages |
| Http | `app/Http/` | Controllers, form requests, API resources, middleware | Domain, Application, vendor packages |
| Console | `app/Console/` | Artisan commands | Domain, Application, vendor packages |
| Providers | `app/Providers/` | The composition root: binds each domain interface to its implementation | Everything |

"PHP" means the language and its bundled classes (`DateTimeImmutable`, `RuntimeException`,
`Stringable`): they belong to no layer, so every layer may use them. Everything else outside `App\`
(Laravel, Symfony, Carbon, any Composer package) is the `Vendor` layer of `deptrac.yaml`.

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

## Errors

Domain and Application code throws its own exception classes, one per failure the caller can act
on (`InvalidDimension`, `LicenceExpired`). PHPStan treats every exception in `App\` as **checked**
(`phpstan.neon`, `exceptions.checkedExceptionRegexes`): a method that throws one, or lets one escape,
declares it with `@throws`, so the caller sees it in the signature. Http maps them to responses.

## Current state

E0 laid the foundation: the folders, the rules, the gate. `app/Domain` and `app/Application` are
empty until E1 (#4) adds the physical quantities. The only application code is the context-base
tooling in `app/Console/` (`context:export`, `context:check`) and the framework defaults.
