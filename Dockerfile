# Stage 1: dependencies & build
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

# Set working directory
WORKDIR /var/www/html

# Copy composer files first (for better cache)
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Copy app
COPY . .

# Generate optimized autoload (if not via composer scripts)
RUN composer dump-autoload -o

# Clear & cache config (will run during container start if needed)
# Permissions (if you need)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port if needed (Render handles routing, so not strictly required)
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
