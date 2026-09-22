FROM php:8.2-apache

# System packages - unzip is required for composer to extract downloaded packages
RUN apt-get update && apt-get install -y --no-install-recommends \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy Composer files first
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction

# Copy application files
COPY . .

# Enable Apache rewrite
RUN a2enmod rewrite

RUN cp /var/www/html/env.example.php /var/www/html/env.php

# Set permissions
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

CMD ["apache2-foreground"]