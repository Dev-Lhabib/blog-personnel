#!/bin/sh
set -e

echo "Waiting for MySQL at ${DB_HOST:-db}:${DB_PORT:-3306}..."

attempt=0
while [ "$attempt" -lt 60 ]; do
    if php -r 'try { new PDO(sprintf("mysql:host=%s;port=%s", getenv("DB_HOST") ?: "db", getenv("DB_PORT") ?: "3306"), getenv("DB_USERNAME") ?: "root", getenv("DB_PASSWORD") ?: "root"); exit(0); } catch (PDOException $e) { exit(1); }' 2>/dev/null; then
        break
    fi
    attempt=$((attempt + 1))
    sleep 2
done

if [ "$attempt" -ge 60 ]; then
    echo "MySQL not reachable after 120s, continuing anyway" >&2
fi

if [ "$DB_CONNECTION" = "mysql" ]; then
    php artisan migrate --force
    php artisan db:seed --force
fi

php artisan storage:link --force

exec apache2-foreground