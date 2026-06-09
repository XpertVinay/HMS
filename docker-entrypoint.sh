#!/bin/bash
set -e

echo "=== HMS Docker Entrypoint ==="

# Ensure proper permissions on the mounted volume for Laravel
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Clear any stale host cache files that might reference missing dev dependencies
rm -f /var/www/html/bootstrap/cache/*.php

# Install dependencies when vendor is missing or composer.lock changed
if [ ! -f "vendor/autoload.php" ] || [ "composer.lock" -nt "vendor/composer/installed.json" ]; then
    echo "Installing/updating Composer dependencies..."
    composer install --no-interaction --optimize-autoloader
fi

# Ensure Vite production manifest includes all configured entrypoints
if [ ! -f "public/build/manifest.json" ] || ! grep -q '"resources/css/businzo.css"' public/build/manifest.json 2>/dev/null; then
    echo "Building frontend assets (Vite manifest missing or outdated)..."
    npm run build
fi

# Generate APP_KEY if not set
if [ -z "$APP_KEY" ] && ! grep -q "^APP_KEY=base64:" .env 2>/dev/null; then
    echo "Generating application key..."
    php artisan key:generate --force
fi

# Wait for MySQL to be ready before running migrations
echo "Waiting for database to be ready..."
MAX_RETRIES=30
RETRY_COUNT=0

until php -r "
try {
    \$host = getenv('DB_HOST') ?: '127.0.0.1';
    \$port = getenv('DB_PORT') ?: '3306';
    \$user = getenv('DB_USERNAME') ?: 'root';
    \$pass = getenv('DB_PASSWORD') ?: '';
    new PDO(\"mysql:host=\$host;port=\$port\", \$user, \$pass, [
        PDO::ATTR_TIMEOUT => 3
    ]);
    echo 'ok';
} catch (Exception \$e) {
    exit(1);
}
" 2>/dev/null; do
    RETRY_COUNT=$((RETRY_COUNT + 1))
    if [ "$RETRY_COUNT" -ge "$MAX_RETRIES" ]; then
        echo "ERROR: Database not ready after ${MAX_RETRIES} attempts (60s). Aborting."
        exit 1
    fi
    echo "  Database not ready yet (attempt $RETRY_COUNT/$MAX_RETRIES). Retrying in 2s..."
    sleep 2
done
echo "Database is ready!"

# Run database migrations
echo "Running database migrations..."
php artisan migrate --force

# Cache configuration for production performance
if [ "$APP_ENV" = "production" ]; then
    echo "Caching configuration for production..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
fi

echo "=== Entrypoint complete. Starting Apache... ==="

# Run the main container command (apache2)
exec "$@"
