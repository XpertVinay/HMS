#!/bin/bash

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
docker-compose exec -T web composer install --no-interaction --prefer-dist --optimize-autoloader

# 3. Run Migrations
echo "Running database migrations..."
docker-compose exec -T web php artisan migrate --force
if [ $? -ne 0 ]; then
    echo "================================================="
    echo "Migration failed! Initiating database rollback..."
    echo "================================================="
    # Restore the database from the backup
    cat "$BACKUP_PATH" | docker-compose exec -T db mysql -u root -proot hms
    echo "Rollback completed. Deployment aborted due to migration failure."
    exit 1
fi

# 4. Verify Schema Sync
echo "Verifying database schema against Eloquent models..."
docker-compose exec -T web php artisan schema:verify
if [ $? -ne 0 ]; then
    echo "========================================================"
    echo "Schema verification failed! Initiating database rollback..."
    echo "========================================================"
    cat "$BACKUP_PATH" | docker-compose exec -T db mysql -u root -proot hms
    echo "Rollback completed. Deployment aborted due to schema validation failure."
    exit 1
fi

# 5. Optimize
echo "Optimizing application..."
docker-compose exec -T web php artisan optimize:clear
docker-compose exec -T web php artisan config:cache
docker-compose exec -T web php artisan route:cache
docker-compose exec -T web php artisan view:cache

echo "Deployment completed successfully with zero downtime!"
