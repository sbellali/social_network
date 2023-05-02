# Base image
FROM php:8.1-fpm

# Set working directory
WORKDIR /var/www/html

RUN if [ ! -z "$http_proxy" ]; then pear config-set http_proxy ${http_proxy};fi

# Install dependencies
RUN apt-get update \
    && apt-get install -y \
    curl \
    git \
    unzip \
    libicu-dev \
    libzip-dev \
    && docker-php-ext-install \
    mysqli pdo_mysql \
    intl \
    zip \
    && pecl install xdebug-3.2.1 \
    && docker-php-ext-enable xdebug

ARG DATABASE_URL

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . .

ENV COMPOSER_ALLOW_SUPERUSER=1

# Install project dependencies
RUN composer install

# Start server
CMD ["php", "-S", "0.0.0.0:80", "-t", "public/"]