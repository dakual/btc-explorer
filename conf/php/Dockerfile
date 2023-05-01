FROM php:8.1-fpm-alpine

WORKDIR /app

RUN apk add --no-cache zlib-dev libpng-dev gmp-dev libmcrypt-dev

RUN docker-php-ext-install bcmath gd gmp

# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# COPY app/composer.json composer.json

# RUN composer install \
#     --no-interaction \
#     --no-plugins \
#     --no-scripts \
#     --no-dev \
#     --prefer-dist

# RUN composer dump-autoload

# COPY app .

# RUN chown -R www-data:www-data .