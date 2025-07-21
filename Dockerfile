FROM php:8.2-apache

# Install system packages including PostgreSQL dev lib
RUN apt-get update && apt-get install -y \
    zip unzip git curl libpng-dev libonig-dev libxml2-dev libzip-dev libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd zip

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory (Laravel root)
WORKDIR /var/www/html

# Copy project files into container
COPY . .

# ✅ Set Apache DocumentRoot to /var/www/html/public
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# ✅ Also allow .htaccess overrides and rewrites
RUN echo '<Directory /var/www/html/public>\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' > /etc/apache2/conf-available/laravel.conf \
    && a2enconf laravel

# Copy composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create required Laravel directories with permissions
RUN mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

EXPOSE 80
