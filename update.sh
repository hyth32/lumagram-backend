#!/bin/bash

composer install --optimize-autoloader --prefer-dist

php artisan optimize:clear
php artisan config:cache
php artisan route:cache

php artisan migrate --force

php artisan l5-swagger:generate
