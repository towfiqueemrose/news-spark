FROM php:8.2-fpm

# system deps
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libonig-dev \
    libzip-dev \
    libpq-dev \
    zip \
    curl \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip opcache

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy entire app early so artisan exists for post scripts
COPY . .

# Allow composer to run as root without disabling plugins warning
ENV COMPOSER_ALLOW_SUPERUSER=1

# Install dependencies (excluded dev if you want)
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Generate optimized autoload
RUN composer dump-autoload -o

# Permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 9000

CMD ["php-fpm"]
