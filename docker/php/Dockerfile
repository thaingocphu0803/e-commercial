# Use the official PHP 8.2 FPM base image
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libwebp-dev \
    libfreetype6-dev \
    libicu-dev \
    libonig-dev \
    libxml2-dev

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp && \
    docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        zip \
        gd \
        intl \
        exif \
        pcntl \
        bcmath \
        opcache \
        mbstring \
        xml

# Install Composer (copy from official Composer image)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy the custom PHP configuration file into the container
# This file overrides the default PHP settings provided by the base image
COPY php.ini /usr/local/etc/php/conf.d/custom.ini

# Create directory for PHP logs
RUN mkdir -p /var/log/php && chmod -R 777 /var/log/php

# Set working directory
WORKDIR /var/www/html
