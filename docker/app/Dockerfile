FROM ubuntu:24.04

# Build Arguments for matching host user permissions
ARG UID=1000
ARG GID=1000

ENV DEBIAN_FRONTEND=noninteractive
ENV COMPOSER_ALLOW_SUPERUSER=1

# Install dependencies in a single RUN command to minimize image layers.
# - Use --no-install-recommends to avoid bloat.
# - Clean apt caches in the same layer to reduce final image size.
# - Added intl, pcntl, and bcmath as they are often required by Laravel.
RUN apt-get update && apt-get install -y --no-install-recommends \
    software-properties-common \
    curl \
    unzip \
    git \
    supervisor \
    ca-certificates \
    && add-apt-repository ppa:ondrej/php -y \
    && apt-get update \
    && apt-get install -y --no-install-recommends \
    php8.3-cli \
    php8.3-fpm \
    php8.3-mysql \
    php8.3-xml \
    php8.3-mbstring \
    php8.3-curl \
    php8.3-zip \
    php8.3-gd \
    php8.3-redis \
    php8.3-swoole \
    php8.3-intl \
    php8.3-bcmath \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Copy Composer directly from the official image (Best Practice)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Security: Ubuntu 24.04 already has an 'ubuntu' user with UID 1000. 
# We will use that user. If we needed a different UID, we would modify it via usermod.
# RUN usermod -u ${UID} ubuntu && groupmod -g ${GID} ubuntu

WORKDIR /var/www/html

# Grant the non-root user ownership of the working directory
RUN chown -R ubuntu:ubuntu /var/www/html

USER ubuntu

# Add a HEALTHCHECK to let Docker know when Octane is ready and responsive.
# Laravel 11/12/13 includes a default /up route for health checks.
HEALTHCHECK --interval=30s --timeout=5s --start-period=10s --retries=3 \
    CMD curl -f http://localhost:8000/up || exit 1

EXPOSE 8000

# Start Octane with Swoole by default.
CMD ["php", "artisan", "octane:start", "--server=swoole", "--host=0.0.0.0", "--port=8000", "--watch"]
