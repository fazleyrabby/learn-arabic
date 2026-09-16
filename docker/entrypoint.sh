#!/bin/sh
set -e

# Wait for DB if DB_HOST is set
if [ -n "$DB_HOST" ]; then
    echo "Waiting for database at $DB_HOST:${DB_PORT:-5432}..."
    until nc -z "$DB_HOST" "${DB_PORT:-5432}"; do
        sleep 1
    done
    echo "Database connection established."
fi

# Run database migrations and seeding
php artisan migrate --force --no-interaction
php artisan db:seed --force --no-interaction

# Optimize config and route caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

exec "$@"
