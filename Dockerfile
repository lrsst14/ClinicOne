FROM node:22-alpine AS assets

WORKDIR /app

COPY package.json ./
COPY package-lock.json ./
RUN npm ci --ignore-scripts

COPY . .
RUN npm run build

FROM php:8.4-cli AS app

RUN apt-get update \
    && apt-get install -y --no-install-recommends libonig-dev libpq-dev libzip-dev unzip \
    && docker-php-ext-install mbstring pdo_pgsql zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock ./
COPY . .

RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

COPY --from=assets /app/public/build ./public/build

RUN mkdir -p storage/framework/cache/data storage/framework/sessions \
        storage/framework/views storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

USER www-data

EXPOSE 8080

CMD ["sh", "-c", "exec php artisan serve --host=0.0.0.0 --port=${PORT:-8080}"]
