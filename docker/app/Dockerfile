FROM dunglas/frankenphp:php8.3

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

# Copy the entire project for production builds.
# Using --chown optimizes the Docker image layers by preventing double storage of the files.
COPY --chown=www-data:www-data . /var/www/html

USER www-data

# Install Composer dependencies for production
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts || true

# Add a HEALTHCHECK to let Docker know when Octane is ready and responsive.
HEALTHCHECK --interval=30s --timeout=5s --start-period=10s --retries=3 \
    CMD curl -f http://localhost:8000/up || exit 1

EXPOSE 8000

# Start Octane with FrankenPHP by default (for production).
CMD ["php", "artisan", "octane:start", "--server=frankenphp", "--host=0.0.0.0", "--port=8000"]
