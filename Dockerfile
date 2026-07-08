FROM dunglas/frankenphp:1-php8.4-bookworm

# Install system dependencies & PHP extensions yang dibutuhkan Laravel
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -y pdo_mysql gd zip pcntl bcmath opcache

# Set working directory
WORKDIR /app

# Copy seluruh source code project
COPY . .

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-dev --optimize-autoloader

# Jalankan optimasi internal Laravel
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

# Set permission agar web server bisa menulis file (storage & cache)
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

EXPOSE 80
EXPOSE 443

CMD ["frankenphp", "run", "--config", "/etc/caddy/Caddyfile"]