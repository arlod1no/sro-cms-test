#!/bin/bash
php artisan migrate --force  # Auto-migrate (comment nếu không cần)
php artisan storage:link
php-fpm -D
nginx -g "daemon off;"
