FROM dunglas/frankenphp:php8.3 AS base

ENV COMPOSER_ALLOW_SUPERUSER=1

# Install necessary PHP extensions using the provided helper script
RUN install-php-extensions \
    pcntl \
    pdo_mysql \
    mysqli \
    zip \
    gd \
    exif \
    redis \
    intl \
    bcmath \
    @composer

WORKDIR /var/www/html

# Development stage
FROM base AS development

RUN chown -R www-data:www-data /var/www/html

USER www-data

HEALTHCHECK --interval=30s --timeout=5s --start-period=10s --retries=3 \
    CMD curl -f http://localhost:8000/up || exit 1

EXPOSE 8000

CMD ["php", "artisan", "octane:start", "--server=frankenphp", "--host=0.0.0.0", "--port=8000"]

# Production stage
FROM base AS production

COPY --chown=www-data:www-data . /var/www/html

USER www-data

RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts || true
RUN rm -f /var/www/html/bootstrap/cache/*.php

HEALTHCHECK --interval=30s --timeout=5s --start-period=10s --retries=3 \
    CMD curl -f http://localhost:8000/up || exit 1

EXPOSE 8000

CMD ["php", "artisan", "octane:start", "--server=frankenphp", "--host=0.0.0.0", "--port=8000"]
