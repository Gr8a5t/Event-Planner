#!/bin/bash
set -e

echo "🚀 Starting Event Planner deployment..."

# Ensure .env file exists with the APP_KEY placeholder so artisan key:generate works
if [ ! -f /var/www/html/.env ]; then
    echo "APP_KEY=" > /var/www/html/.env
fi

# ------------------------------------
# APP_KEY: Generate if not set
# ------------------------------------
if [ -z "$APP_KEY" ] || [[ "$APP_KEY" != base64:* ]]; then
    echo "🔑 Generating application key..."
    php artisan key:generate --force
fi

# ------------------------------------
# SQLite: Use persistent disk at /data
# ------------------------------------
DB_PATH="/data/database.sqlite"

if [ ! -f "$DB_PATH" ]; then
    echo "📦 Creating SQLite database..."
    touch "$DB_PATH"
fi

chown www-data:www-data "$DB_PATH"
chmod 664 "$DB_PATH"

# Symlink so Laravel finds it at the expected path
ln -sf "$DB_PATH" /var/www/html/database/database.sqlite

# ------------------------------------
# Storage: Link public storage
# ------------------------------------
echo "🔗 Creating storage link..."
php artisan storage:link --force 2>/dev/null || true

# ------------------------------------
# Laravel: Cache config, routes, views
# ------------------------------------
echo "⚡ Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# ------------------------------------
# Database: Run migrations
# ------------------------------------
echo "🗃️  Running migrations..."
php artisan migrate --force

# ------------------------------------
# Permissions
# ------------------------------------
echo "🔐 Setting permissions..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# ------------------------------------
# Create supervisor log directory
# ------------------------------------
mkdir -p /var/log/supervisor

echo "✅ Deployment ready! Starting services..."

# Start supervisord (runs both nginx + php-fpm)
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
