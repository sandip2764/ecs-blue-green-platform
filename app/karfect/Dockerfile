# ============================================================
# Stage 1: Composer dependencies
# ============================================================
FROM composer:2 AS composer

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --no-progress


# ============================================================
# Stage 2: Production application
# ============================================================
FROM php:8.2-apache

RUN docker-php-ext-install \
    pdo_mysql \
    mysqli

RUN printf "log_errors=On\nerror_log=/proc/self/fd/2\n" \
    > /usr/local/etc/php/conf.d/production-logging.ini

WORKDIR /var/www/html

COPY --from=composer /app/vendor ./vendor

COPY --chown=www-data:www-data . .

RUN a2enmod rewrite

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

RUN cp env.example.php env.php

EXPOSE 80

CMD ["apache2-foreground"]