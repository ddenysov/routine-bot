#!/bin/bash
#
#  This script should be used for generating .env file for Laravel
#
echo "Touching .env file...."
touch /var/www/html/.env

echo "Artisan Seed....."
php artisan migrate --seed

echo "Starting PHP-FPM......."
php-fpm
