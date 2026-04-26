# ---- Stage 1: Composer dependencies ----
FROM composer:2 AS composer

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --no-interaction

COPY . .
RUN composer dump-autoload --no-dev --optimize


# ---- Stage 2: PHP-FPM application + frontend build ----
FROM php:8.4-fpm-alpine AS app

# fcgi provides cgi-fcgi binary used for the healthcheck
# sqlite-dev needed so artisan can boot with DB_CONNECTION=sqlite during the frontend build
RUN apk add --no-cache fcgi libpng-dev libzip-dev oniguruma-dev sqlite-dev nodejs npm \
    && docker-php-ext-install pdo_mysql pdo_sqlite mbstring zip opcache

WORKDIR /var/www/html

COPY --from=composer /app .

# wayfinder Vite plugin calls `php artisan wayfinder:generate` during build.
# We run it explicitly first so any artisan errors are visible in CI logs,
# and the generated files already exist when Vite runs it again.
COPY package*.json ./
RUN printf 'APP_KEY=base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA=\nDB_CONNECTION=sqlite\nDB_DATABASE=:memory:\n' > .env \
    && php artisan wayfinder:generate --with-form \
    && npm ci --ignore-scripts \
    && npm run build \
    && rm -rf node_modules .env

# PHP config
COPY docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
# Extends the [www] pool: enables /ping endpoint for healthcheck
COPY docker/php/zz-ping.conf /usr/local/etc/php-fpm.d/zz-ping.conf

RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache


# ---- Stage 3: Nginx ----
FROM nginx:alpine AS nginx

COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf
# Bake static assets into the nginx image so it can serve them directly
COPY --from=app /var/www/html/public /var/www/html/public
