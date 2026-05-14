FROM composer:2 AS dependencies

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Production stage
FROM dunglas/frankenphp:php8.3 AS production

ENV COMPOSER_ALLOW_SUPERUSER=1

# Install PHP extensions required by dependencies
RUN install-php-extensions exif pdo_mysql gd

WORKDIR /var/www/html

COPY --chown=www-data:www-data . .
COPY --from=dependencies --chown=www-data:www-data /app/vendor ./vendor

USER www-data

RUN rm -f ./bootstrap/cache/*.php

HEALTHCHECK --interval=30s --timeout=5s --start-period=10s --retries=3 \
    CMD curl -f http://localhost:8000/up || exit 1

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]

# Development stage
FROM dunglas/frankenphp:php8.3 AS development

ENV COMPOSER_ALLOW_SUPERUSER=1

# Install PHP extensions required by dependencies
RUN install-php-extensions exif pdo_mysql gd

# Install composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

RUN chown -R www-data:www-data /var/www/html

USER www-data

HEALTHCHECK --interval=30s --timeout=5s --start-period=10s --retries=3 \
    CMD curl -f http://localhost:8000/up || exit 1

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
