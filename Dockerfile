# ---- Stage 1: Build frontend assets ----
FROM node:22-alpine AS frontend

WORKDIR /app

COPY package*.json ./
RUN npm ci --ignore-scripts

COPY . .
RUN npm run build


# ---- Stage 2: Composer dependencies ----
FROM composer:2 AS composer

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --no-interaction

COPY . .
RUN composer dump-autoload --no-dev --optimize


# ---- Stage 3: PHP-FPM application ----
FROM php:8.4-fpm-alpine AS app

# fcgi provides cgi-fcgi binary used for the healthcheck
RUN apk add --no-cache fcgi libpng-dev libzip-dev oniguruma-dev \
    && docker-php-ext-install pdo_mysql mbstring zip opcache

WORKDIR /var/www/html

COPY --from=composer /app .


# Copy built Vite assets
COPY --from=frontend /app/public/build ./public/build

# PHP config
COPY docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
# Extends the [www] pool: enables /ping endpoint for healthcheck
COPY docker/php/zz-ping.conf /usr/local/etc/php-fpm.d/zz-ping.conf

RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache


# ---- Stage 4: Nginx ----
FROM nginx:alpine AS nginx

COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf
# Bake static assets into the nginx image so it can serve them directly
COPY --from=app /var/www/html/public /var/www/html/public
