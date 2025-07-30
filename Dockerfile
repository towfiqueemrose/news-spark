FROM php:8.2-apache

# সিস্টেম প্যাকেজ এবং PHP এক্সটেনশন ইনস্টল
RUN apt-get update && apt-get install -y \
    zip unzip git curl libpng-dev libonig-dev libxml2-dev libzip-dev libpq-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd zip opcache

# Apache মডিউল এনাবল
RUN a2enmod rewrite

# ওয়ার্ক ডিরেক্টরি সেট
WORKDIR /var/www/html

# .env ফাইল কপি
COPY .env.example .env

# অ্যাপ্লিকেশন ফাইল কপি
COPY . .

# Apache কনফিগারেশন
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf \
    && echo '<Directory /var/www/html/public>\n  AllowOverride All\n  Require all granted\n</Directory>' > /etc/apache2/conf-available/laravel.conf \
    && a2enconf laravel

# স্ট্রেজ ফোল্ডার তৈরি
RUN mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache

# কম্পোজার ইনস্টল
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ডিপেন্ডেন্সি ইনস্টল
RUN composer install --no-dev --optimize-autoloader

# Laravel সেটআপ
RUN php artisan key:generate \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# পারমিশন সেট
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80
