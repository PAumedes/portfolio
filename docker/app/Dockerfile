FROM composer:2 AS dependencies

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Production stage
FROM dunglas/frankenphp:php8.3 AS production

ENV COMPOSER_ALLOW_SUPERUSER=1

# Install PHP extensions required by dependencies
RUN install-php-extensions exif pdo_mysql gd pcntl

WORKDIR /var/www/html

COPY --chown=www-data:www-data . .
COPY --from=dependencies --chown=www-data:www-data /app/vendor ./vendor

USER www-data

RUN rm -f ./bootstrap/cache/*.php

HEALTHCHECK --interval=30s --timeout=5s --start-period=20s --retries=3 \
    CMD curl -f http://localhost:8000/up || exit 1

EXPOSE 8000

CMD ["php", "artisan", "octane:start", "--server=frankenphp", "--host=0.0.0.0", "--port=8000", "--max-requests=500"]

# Development stage
FROM dunglas/frankenphp:php8.3 AS development

ENV COMPOSER_ALLOW_SUPERUSER=1

# Install PHP extensions required by dependencies
RUN install-php-extensions exif pdo_mysql gd pcntl zip redis

# Install development tools (fswatch for file watching, git for composer source downloads, unzip for archives)
RUN apt-get update && apt-get install -y --no-install-recommends \
    fswatch \
    git \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Install composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

RUN chown -R www-data:www-data /var/www/html && \
    mkdir -p storage/logs storage/framework/cache storage/framework/views bootstrap/cache && \
    chown -R www-data:www-data storage bootstrap && \
    chmod -R 775 storage bootstrap

USER www-data

HEALTHCHECK --interval=30s --timeout=5s --start-period=20s --retries=3 \
    CMD curl -f http://localhost:8000/up || exit 1

EXPOSE 8000

CMD ["php", "artisan", "octane:start", "--server=frankenphp", "--host=0.0.0.0", "--port=8000", "--watch", "--max-requests=500"]
