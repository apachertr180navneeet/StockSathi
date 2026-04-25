#!/bin/bash
set -e

echo "Starting deployment..."

# Install dependencies without dev-dependencies and optimize autoloader
echo "Installing Composer dependencies..."
composer install --optimize-autoloader --no-dev

# Compile assets
echo "Compiling frontend assets..."
npm install
npm run build

# Cache configuration, routes, and views for production
echo "Caching configuration and routes..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Link storage if not already linked
echo "Linking storage..."
php artisan storage:link || true

echo "Deployment finished successfully!"
