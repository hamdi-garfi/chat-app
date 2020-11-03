FROM php:fpm-alpine
RUN apk update && apk add --no-cache \
        postgresql-dev \
    && docker-php-ext-install -j$(nproc) pgsql \
&& docker-php-ext-install -j$(nproc) pdo_pgsql


RUN curl -sS https://getcomposer.org/installer | \
    php -- --install-dir=/usr/bin/ --filename=composer

WORKDIR /app
COPY . ./
RUN composer install --no-dev --no-interaction -o
 