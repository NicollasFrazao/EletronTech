---
type: doc
name: development-workflow
description: Setup with Docker, day-to-day commands and recipes
category: workflow
generated: 2026-11-02
status: filled
scaffoldVersion: "2.0.0"
---

# Development workflow

The rules are in [development-conventions.md](development-conventions.md); this file is the how.

## Requirements

- Docker with Compose v2. PHP 8.4 and Composer run inside the `app` image, so the host needs no PHP.
- Node.js 22 on the host, for Vite, ESLint, knip and the git hooks.

## First run

```bash
git clone https://github.com/NicollasFrazao/eletrontech.git && cd eletrontech
make setup   # composer install (in the image), npm ci, git hooks
make up      # app, queue worker, MySQL 8.4 and Mailpit; waits until healthy
```

- App: <http://localhost:8000> (health check at `/up`).
- Mailpit (every outgoing email): <http://localhost:8025>.
- MySQL: `localhost:3306`, database, user and password `eletrontech`.

`docker compose up` alone also works on a fresh clone: the image's entrypoint
(`docker/php/entrypoint.sh`) installs the Composer dependencies, copies `.env.example` to `.env` and
generates the app key when they are missing, and the `app` service runs the migrations before
serving. If a port is taken, set `APP_PORT`, `FORWARD_DB_PORT` or `FORWARD_MAILPIT_PORT` in `.env`.

The containers run as your user (`HOST_UID`/`HOST_GID`, exported by the Makefile), so files they
write in the working tree stay yours.

## Day to day

| Command | What it does |
| --- | --- |
| `make up` / `make down` | Start or stop the environment (the database volume survives `down`) |
| `make sh` | A shell in the running `app` container |
| `make test` | Pest with the 80% coverage gate |
| `make lint` | Pint, PHP_CodeSniffer, ESLint |
| `make analyse` | PHPStan, PHPMD, phpmnd, Deptrac, Rector (dry run), composer-unused, knip |
| `make audit` | `composer audit` and `npm audit` |
| `make context` | Agent surfaces in sync with the index |
| `make gate` | All of the above, one at a time: the CI |
| `make fix` | Apply Pint and Rector fixes |
| `npm run dev` | Vite with hot reload for `resources/` |

Any single check: `docker compose run --rm --no-deps app composer <script>` (the scripts are listed
in `composer.json`, with descriptions: `composer list` inside the container).

## Recipes

### Port a feature from the 2015 version

1. Find the screen in the technical documentation (`docs/technical-documentation-pt-BR.pdf`,
   section 6.4, screens F1–F25) and the code at the `v1` tag.
2. Translate every term with the [glossary](glossary.md); add the missing ones there first.
3. Model it in `app/Domain/` with tests first (unit tests, no framework), then the Application
   handler, then Infrastructure and Http. See [architecture.md](architecture.md), "Where things go".
4. Where the original was wrong (a formula, a validation), fix it and say so in the PR.

### Add a domain interface and its implementation

1. Interface in `app/Domain/<Area>/`, documented, with `@throws` for its domain errors.
2. Implementation in `app/Infrastructure/`.
3. Binding in `app/Providers/AppServiceProvider.php` (or a provider per area once it grows).

### Change the context base

Edit `.context/docs/README.md` (or any guide), then `php artisan context:export` (inside the
container: `docker compose run --rm --no-deps app php artisan context:export`) and commit the source
and the three surfaces together.
