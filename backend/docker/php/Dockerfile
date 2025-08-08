FROM php:8.3-fpm-alpine

# Systemowe paczki + potrzebne do kompilacji amqp
RUN apk add --no-cache \
    bash \
    git \
    unzip \
    icu-dev \
    zlib-dev \
    libzip-dev \
    oniguruma-dev \
    postgresql-dev \
    libxml2-dev \
    libpng-dev \
    rabbitmq-c-dev \
    autoconf \
    build-base

# PHP rozszerzenia
RUN docker-php-ext-install intl pdo pdo_pgsql zip opcache

# Instalacja rozszerzenia amqp przez PECL
RUN pecl install amqp \
    && docker-php-ext-enable amqp

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
