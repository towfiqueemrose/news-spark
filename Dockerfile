FROM php:8.3-fpm

# সিস্টেম ডিপেন্ডেন্সি ইনস্টল করুন
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    zip unzip git curl \
    libpq-dev \
    nodejs npm \
    && docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd

# কম্পোজার ইনস্টল করুন
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ওয়ার্কিং ডিরেক্টরি সেট করুন
WORKDIR /var/www

# প্রজেক্ট ফাইল কপি করুন
COPY . .

# ডিপেন্ডেন্সি ইনস্টল করুন এবং অ্যাসেট বিল্ড করুন
RUN composer install --no-dev \
    && npm install \
    && npm run build \
    && php artisan config:cache \
    && php artisan view:cache

# পারমিশন সেট করুন
RUN chown -R www-data:www-data /var/www

EXPOSE 9000

CMD ["php-fpm"]
