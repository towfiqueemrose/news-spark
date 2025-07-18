
#!/bin/bash

# Laravel Docker Deployment Script for Render
echo "🚀 Starting Laravel Docker deployment preparation..."

# Create necessary directories if they don't exist
mkdir -p storage/logs
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p bootstrap/cache

# Set proper permissions
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Create symbolic link for public storage (if needed)
if [ ! -L public/storage ]; then
    php artisan storage:link
fi

# Generate application key if not exists
if [ ! -f .env ]; then
    cp .env.example .env
    php artisan key:generate
fi

# Clear all cached files
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

echo "✅ Deployment preparation completed!"
echo "📝 Next steps:"
echo "1. Push your code to GitHub"
echo "2. Connect your GitHub repo to Render"
echo "3. Set environment variables in Render dashboard"
echo "4. Deploy!"
