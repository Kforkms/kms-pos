FROM dunglas/frankenphp:1-php8.4-bookworm

# Install PHP extensions menggunakan helper resmi dari FrankenPHP/docker-php-extension-installer
# Ini otomatis menginstall dependencies gd, zip, dll tanpa perlu apt-get install manual yang ribet
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN install-php-extensions pdo_mysql gd zip pcntl bcmath opcache intl

WORKDIR /app

# Copy source code
COPY . .

# Install Composer dependencies
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-dev --optimize-autoloader

# Optimasi Laravel
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

# Set permissions
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

EXPOSE 80
EXPOSE 443

CMD ["frankenphp", "run", "--config", "/etc/caddy/Caddyfile"]
