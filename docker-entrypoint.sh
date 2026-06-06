#!/bin/bash

# Ensure proper permissions on the mounted volume for Laravel
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Clear any stale host cache files that might reference missing dev dependencies
rm -f /var/www/html/bootstrap/cache/*.php

# If vendor directory is empty/missing, install dependencies
if [ ! -f "vendor/autoload.php" ]; then
    echo "Vendor directory not found or empty. Installing dependencies..."
    composer install --no-interaction --optimize-autoloader
fi

# Run the main container command (apache2)
exec "$@"
