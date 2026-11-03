#!/bin/sh
set -e

cd /var/www/html

# Render injects the port to listen on; default to 10000 like Render does.
PORT="${PORT:-10000}"
sed -ri "s/^Listen .*/Listen ${PORT}/" /etc/apache2/ports.conf
sed -ri "s/<VirtualHost \*:[0-9]+>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf

# Aiven MySQL requires TLS: the CA certificate is passed as an env var.
if [ -n "$DB_SSL_CA_CERT" ]; then
    printf '%s\n' "$DB_SSL_CA_CERT" > storage/db-ca.pem
    export MYSQL_ATTR_SSL_CA=/var/www/html/storage/db-ca.pem
fi

php artisan storage:link --force >/dev/null 2>&1 || true
php artisan config:cache
php artisan view:cache

php artisan migrate --force

# Seed demo data only on an empty database.
if [ "$(php artisan tinker --execute='echo \App\Models\User::count();' 2>/dev/null | tail -n1)" = "0" ]; then
    php artisan db:seed --force
    php artisan db:seed --class=CustomerSeeder --force
fi

chown -R www-data:www-data storage bootstrap/cache

exec apache2-foreground
