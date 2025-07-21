#!/bin/bash
php artisan storage:link
php-fpm -D
nginx -g "daemon off;"
