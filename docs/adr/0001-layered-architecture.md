# 0001. Layered architecture with Laravel only at the edges

- Status: Accepted
- Date: 2026-11-02
- Issues: #2 (rewrite), #3 (foundation)

## Context

EletronTech v1 (2015) is procedural PHP: each page opens its own database connection, builds SQL by
concatenation, computes, and prints HTML, all in one file. The same calculation exists two or three
times (web, mobile, admin) and nothing is tested. The value of the application is in its rules: the
calculator formulas, the NBR 5410 tables, the licence periods, the floor-plan geometry. Those rules
must be testable on their own and must outlive framework upgrades.

## Decision

The code under `app/` is split into four layers, plus two edge folders:

- **Domain** (`app/Domain`): entities, value objects, domain services, repository interfaces and
  domain errors. Plain PHP; it depends on nothing but itself and PHP's own classes.
- **Application** (`app/Application`): one use case per user action, with input and output DTOs. It
  depends only on the Domain.
- **Infrastructure** (`app/Infrastructure`): Eloquent models and repositories, file storage, mail,
  queues, PDF export. It implements the Domain's interfaces.
- **Http** (`app/Http`): controllers, form requests, resources. It calls Application use cases.
- `app/Console` (Artisan commands) is an edge like Http; `app/Providers` is the composition root,
  the only place where an interface is bound to an implementation.

The rules are enforced in CI by Deptrac (`deptrac.yaml`), not by convention.

Other decisions that follow: constructor injection only (no facades or `app()` outside Providers and
the edges), immutable value objects for quantities with units, one exception class per failure a
caller can act on (checked by PHPStan), composition over inheritance.

## Alternatives considered

- **Standard Laravel structure** (`app/Models`, fat models or service classes that use Eloquent).
  Fastest to write, and fine for CRUD; but the calculators and the licence rules would depend on the
  framework and on the database to be tested, which is the problem of v1 in another form.
- **Modules per feature** (`app/Calculators/{Domain,Application,...}`). Better locality once there are
  many areas. Not chosen now because the areas share the physical quantities and the user/licence
  model; it can be adopted later inside each layer (`app/Domain/Calculators/...`) without breaking
  the rules.
- **Hexagonal with separate Composer packages** for the domain. Stronger isolation, but more ceremony
  than a project of this size needs; Deptrac gives the same guarantee within one package.

## Consequences

- Domain and Application tests run without booting Laravel or a database.
- More classes per feature (entity, repository interface, Eloquent repository, handler, DTO,
  controller) than a typical Laravel app; the readability limits keep each one small.
- Eloquent features that leak into callers (lazy loading, magic attributes) stay inside
  Infrastructure; repositories map models to domain objects explicitly.
- Filament (admin, E8) works on Eloquent models; it lives in Infrastructure/Http and calls
  Application use cases for anything that changes state with a rule.
- Widening a Deptrac rule requires a new ADR that supersedes or amends this one.
