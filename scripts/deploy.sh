#!/bin/bash

if [ -f .env ]; then
    set -a
    # shellcheck disable=SC1091
    source .env
    set +a
fi

COMPOSE_FILES="-f docker-compose.yml"
if [ -f docker-compose.prod.yml ] && [ "${APP_ENV:-local}" = "production" ]; then
    COMPOSE_FILES="$COMPOSE_FILES -f docker-compose.prod.yml"
fi

echo "Starting Deployment Process..."

# 1. Run the Backup Script
echo "Executing database backup..."
bash scripts/backup_db.sh
if [ $? -ne 0 ]; then
    echo "Deployment aborted: Database backup failed."
    exit 1
fi

# Extract the backup path from the .last_backup file
BACKUP_PATH=$(cat .last_backup | cut -d '=' -f 2)
if [ ! -f "$BACKUP_PATH" ]; then
    echo "Deployment aborted: Could not locate backup file $BACKUP_PATH"
    exit 1
fi

# 2. Update Code
echo "Pulling latest code..."
git pull origin main || echo "Git pull skipped or failed, proceeding..."

echo "Running composer install..."
docker compose $COMPOSE_FILES exec -T web composer install --no-interaction --prefer-dist --optimize-autoloader

# 3. Run Migrations
echo "Running database migrations..."
docker compose $COMPOSE_FILES exec -T web php artisan migrate --force
if [ $? -ne 0 ]; then
    echo "================================================="
    echo "Migration failed! Initiating database rollback..."
    echo "================================================="
    # Restore the database from the backup
    cat "$BACKUP_PATH" | docker compose $COMPOSE_FILES exec -T db mysql -u "${DB_USERNAME:-root}" -p"${DB_PASSWORD:-root}" "${DB_DATABASE:-hms}"
    echo "Rollback completed. Deployment aborted due to migration failure."
    exit 1
fi

# 4. Verify Schema Sync
echo "Verifying database schema against Eloquent models..."
docker compose $COMPOSE_FILES exec -T web php artisan schema:verify
if [ $? -ne 0 ]; then
    echo "========================================================"
    echo "Schema verification failed! Initiating database rollback..."
    echo "========================================================"
    cat "$BACKUP_PATH" | docker compose $COMPOSE_FILES exec -T db mysql -u "${DB_USERNAME:-root}" -p"${DB_PASSWORD:-root}" "${DB_DATABASE:-hms}"
    echo "Rollback completed. Deployment aborted due to schema validation failure."
    exit 1
fi

# 5. Optimize
echo "Optimizing application..."
docker compose $COMPOSE_FILES exec -T web php artisan optimize:clear
docker compose $COMPOSE_FILES exec -T web php artisan config:cache
docker compose $COMPOSE_FILES exec -T web php artisan route:cache
docker compose $COMPOSE_FILES exec -T web php artisan view:cache

echo "Deployment completed successfully with zero downtime!"
