FROM php:8.1-fpm-alpine

# WORKDIR /app

# COPY . .

RUN apk add zlib-dev libpng-dev gmp-dev

RUN docker-php-ext-install bcmath gd gmp

# RUN chown -R www-data:www-data .