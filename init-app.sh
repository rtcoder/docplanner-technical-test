#!/usr/bin/sh
#install dependencies
composer install

#create secret
php artisan jwt:secret
