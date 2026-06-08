#!/bin/bash

# Configuration
BACKUP_DIR="backups"
KEEP_BACKUPS=5
TIMESTAMP=$(date +"%Y-%m-%d_%H-%M-%S")
BACKUP_FILE="${BACKUP_DIR}/db_backup_${TIMESTAMP}.sql"

mkdir -p "$BACKUP_DIR"

echo "Creating database backup: ${BACKUP_FILE}"

DB_USER="${DB_USERNAME:-root}"
DB_PASS="${DB_PASSWORD:-root}"
DB_NAME="${DB_DATABASE:-hms}"

# Load .env if present
if [ -f .env ]; then
    set -a
    # shellcheck disable=SC1091
    source .env
    set +a
    DB_USER="${DB_USERNAME:-$DB_USER}"
    DB_PASS="${DB_PASSWORD:-$DB_PASS}"
    DB_NAME="${DB_DATABASE:-$DB_NAME}"
fi

# Run mysqldump inside the db container using -T to disable pseudo-TTY allocation
docker-compose exec -T db mysqldump -u "$DB_USER" -p"$DB_PASS" "$DB_NAME" > "$BACKUP_FILE"

if [ $? -eq 0 ]; then
    echo "Backup completed successfully."
    echo "BACKUP_PATH=${BACKUP_FILE}" > .last_backup
else
    echo "Backup failed!"
    exit 1
fi

# Clean up old backups, keeping only the last $KEEP_BACKUPS
# Ensure we only try to remove if there are old files
OLD_BACKUPS=$(ls -t ${BACKUP_DIR}/db_backup_*.sql 2>/dev/null | tail -n +$((KEEP_BACKUPS + 1)))
if [ -n "$OLD_BACKUPS" ]; then
    echo "Cleaning up old backups (keeping last ${KEEP_BACKUPS})..."
    echo "$OLD_BACKUPS" | xargs rm -f
    echo "Cleanup done."
fi
