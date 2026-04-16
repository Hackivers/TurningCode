#!/bin/bash

echo "Starting deployment script..."

# 1. Run migrations
echo "Running migrations..."
php artisan migrate --force

# 2. Clear caches to ensure Railway variables are loaded correctly
echo "Clearing config and caches..."
php artisan config:clear
php artisan cache:clear

# 3. Start the queue worker in a background loop
# If it crashes (e.g. DB connection dropped momentarily), it will auto-restart
echo "Starting queue worker in background..."
(
  while true; do
    php artisan queue:work --daemon --sleep=3 --tries=3 --timeout=90
    echo "Queue worker stopped or crashed! Restarting in 5 seconds..."
    sleep 5
  done
) &

# 4. Start the main web server in the foreground
echo "Starting web server on port ${PORT:-8000}..."
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
