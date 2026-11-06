---
type: doc
name: security
description: What the 2015 original got wrong, the rules v2 follows, the automated checks and how to report a vulnerability
category: security
generated: 2026-11-02
status: filled
scaffoldVersion: "2.0.0"
---

# Security

## Lessons from the original

The 2015 code (tag `v1`) is kept for reference only. Never copy these patterns:

| In v1 | In v2 |
| --- | --- |
| Passwords stored Base64-encoded | Laravel's `hashed` cast (bcrypt); never store or log a password |
| SQL built by string concatenation, `mysql_escape_string` in places | Eloquent and the query builder with bindings only; no raw SQL with interpolated input |
| Session checks repeated by hand in each page | Auth middleware on route groups; policies for ownership (a user's files, events, projects) |
| Connection credentials in seven `Conexao.php` files | `.env` only; `.env` is git-ignored, `.env.example` holds no secret |
| File downloads blocked by extension (`.php`, `.html`) | Files stored outside `public/` on a private disk, served through a controller that checks ownership, with a forced download content type |
| No CSRF protection | Laravel's CSRF middleware on every web form |
| Login lockout planned (NF 1.4) but weak | Rate limiting on login and password recovery |
| The basic calculator ran the typed text with JavaScript's `eval` | A parser of our own that accepts only numbers, four operators and brackets ([ADR 0004](/docs/adr/0004-arithmetic-expressions-without-eval.md)); no `eval` anywhere |

## Rules

- Every route that touches a user's data is behind `auth` and checks ownership with a policy.
- Validation in form requests; the domain validates its own invariants again.
- Never `eval` or `create_function` anything a person typed; text a tool must interpret goes through a
  grammar of its own with a length limit (the basic calculator's `Expression`).
- Uploaded files: size and MIME limits, random stored names, never executed, never under `public/`.
- Output in Blade with `{{ }}`; `{!! !!}` only for HTML the application generated itself.
- Secrets never in code, tests, logs or fixtures. The `APP_KEY` in `phpunit.xml` is test-only.
- Personal data (CPF, birth date, phone in the original data dictionary) is collected only when a
  feature needs it.

## Automated checks

- `composer audit` (CI job `composer-audit`) and `npm audit --omit=dev --audit-level=high`
  (`npm-audit`) on every pull request.
- Dependabot for Composer, npm, GitHub Actions and the Docker images, weekly.
- CodeQL for the JavaScript (`.github/workflows/codeql.yml`). CodeQL has no PHP analyser; PHP is
  covered by Larastan at max level with `phpstan-strict-rules`.
- GitHub secret scanning and push protection on the repository.

## Reporting a vulnerability

See [SECURITY.md](/SECURITY.md): private vulnerability reporting on GitHub, not a public issue.
