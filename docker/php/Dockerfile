FROM php:8.3-fpm-alpine

# Systemowe paczki
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
    libpng-dev

# PHP rozszerzenia
RUN docker-php-ext-install intl pdo pdo_pgsql zip opcache

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
