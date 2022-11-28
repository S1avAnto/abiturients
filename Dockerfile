FROM php:8.2-rc-fpm

RUN docker-php-ext-install pdo pdo_mysql