#!/bin/sh
# Prepares a fresh clone on the first `docker compose up`: dependencies, .env and the app key.
# Every step is skipped when its result already exists, so later starts go straight to the command.
set -e

if [ ! -f vendor/autoload.php ]; then
    composer install --no-interaction --no-progress
fi

if [ ! -f .env ]; then
    cp .env.example .env
fi

if ! grep -q '^APP_KEY=base64:' .env; then
    php artisan key:generate --no-interaction
fi

exec "$@"
