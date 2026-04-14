web: bash -c "php artisan migrate --force && php artisan queue:work --daemon --tries=3 --timeout=90 --sleep=10 & php artisan serve --host=0.0.0.0 --port=${PORT:-8000}"
