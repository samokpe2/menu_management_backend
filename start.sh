#!/usr/bin/env bash
set -e

# Install dependencies
echo "Running composer..."
composer install --no-dev --optimize-autoloader

# Cache configurations and routes
echo "Caching configuration..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

# Run migrations
echo "Running migrations..."
php artisan migrate --force

# Start PHP-FPM
echo "Starting PHP-FPM..."
php-fpm &

# Start Nginx in the foreground
echo "Starting Nginx..."
nginx -g 'daemon off;'
