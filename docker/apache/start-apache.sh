#!/bin/bash

# This script needs to run as root initially, then switch to www-data for Laravel operations
# But since we're starting as www-data, we need sudo for certain operations


# Ensure all Laravel files are owned by www-data
sudo chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Run Laravel migrations as www-data user (no sudo needed, we're already www-data)
php artisan migrate --force --path=database/migrations/sessions/0000_00_00_000000_create_sessions_table_fixed.php

# Start Apache in foreground (needs sudo since we need to bind to port 80)
exec sudo apache2-foreground