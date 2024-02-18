#!/usr/bin/sh

cp ./env.example ./.env
php artisan key:generate

#install dependencies
composer install

#create secret
