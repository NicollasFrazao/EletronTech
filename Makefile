# Day-to-day commands. PHP runs inside the `app` image (PHP 8.4), so the host needs only Docker,
# and Node.js 22 for the JavaScript checks and the git hooks.
# The gate runs one check at a time on purpose: in parallel they compete for memory.

export HOST_UID := $(shell id -u)
export HOST_GID := $(shell id -g)

PHP := docker compose run --rm --no-deps app

.DEFAULT_GOAL := help
.PHONY: help setup up down sh test lint analyse audit context gate fix

help: ## List the targets
	@grep -E '^[a-z-]+:.*## ' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*## "} {printf "  %-8s %s\n", $$1, $$2}'

setup: ## Install PHP and Node dependencies and the git hooks
	$(PHP) composer install
	npm ci
	npm run hooks

up: ## Start app, queue worker, MySQL and Mailpit; wait until healthy
	docker compose up -d --build --wait

down: ## Stop the environment (the database volume is kept)
	docker compose down

sh: ## Open a shell in the running app container
	docker compose exec app bash

test: ## Pest with the 80% coverage gate
	$(PHP) composer test:coverage

lint: ## Code style, doc comments, readability limits, JavaScript lint
	$(PHP) composer pint
	$(PHP) composer phpcs
	npm run lint

analyse: ## Static analysis, architecture, magic numbers, upgrades, unused code and dependencies
	$(PHP) composer phpstan
	$(PHP) composer phpmd
	$(PHP) composer phpmnd
	$(PHP) composer deptrac
	$(PHP) composer rector
	$(PHP) composer unused
	npm run check:unused

audit: ## Known vulnerabilities in Composer and npm dependencies
	$(PHP) composer audit
	npm audit --omit=dev --audit-level=high

context: ## Agent surfaces are copies of .context/docs/README.md
	$(PHP) composer context:check

gate: lint analyse test audit context ## Every CI check, one at a time

fix: ## Apply Pint and Rector fixes
	$(PHP) composer pint:fix
	$(PHP) vendor/bin/rector process
