# Dockerfile
FROM php:8.3 as php

# Install system dependencies
RUN apt-get update -y && apt-get install -y \
    gnupg2 \
    curl \
    unzip \
    libpq-dev \
    libcurl4-gnutls-dev \
    git \
    nodejs \
    npm \
    && docker-php-ext-install pdo_pgsql pdo_mysql bcmath \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www

# Copy application files
COPY . .

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install PHP dependencies
RUN composer install --no-interaction --prefer-dist

# Install Node.js dependencies
RUN npm install

# Expose port for PHP server
ENV PORT=8000

# Entry point
ENTRYPOINT [ "./docker/entrypoint.sh" ]
