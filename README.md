# 🐳 Docker + PHP 8 + PostgreSQL + Vue 3 + Nginx + Symfony 6

## Description

This is a complete stack for running Symfony 6 into Docker containers using docker-compose tool.

It is composed by 3 services:

- `nginx`, acting as the webserver.
- `php-fpm`, the PHP-FPM container with the PHP 8.1 version.
- `postgres` which is the MySQL database container with a **PostgreSQL 15.1** image.

## Installation

1. 😀 Clone this rep.
2. Run `docker-compose up -d`
3. Make sure you have an updated node version in your machine and run `npm i` inside frontend folder, followed by `npm run dev`
4. run ` docker exec -it -u root search_php-fpm bash` to open the container and `php bin/console doctrine:fixtures:load` to create fake data


For performance improvements you may need to turn off xdebug in the php-fpm container
