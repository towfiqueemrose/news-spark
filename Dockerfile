FROM php:8.2-apache

# সিস্টেম ডিপেন্ডেন্সি ইনস্টল
RUN apt-get update && apt-get install -y \
    git unzip libpng-dev libonig-dev libxml2-dev libzip-dev libpq-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd zip opcache

# Apache কনফিগারেশন
RUN a2enmod rewrite
COPY docker/000-default.conf /etc/apache2/sites-available/000-default.conf

# কম্পোজার ইনস্টল
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# অ্যাপ্লিকেশন সেটআপ
WORKDIR /var/www/html
COPY . .

# Laravel স্ট্রাকচার তৈরি
RUN mkdir -p storage/framework/{cache,sessions,views} storage/logs bootstrap/cache

# ডিপেন্ডেন্সি ইনস্টল
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Laravel কনফিগারেশন
RUN php artisan key:generate --force \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# পারমিশন সেট
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80
