FROM dunglas/frankenphp:1-php8.4-bookworm

# Install PHP extensions menggunakan helper resmi
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions pdo_mysql gd zip pcntl bcmath opcache intl

# Install Node.js 22 (LTS) secara eksplisit dari Nodesource
RUN apt-get update && apt-get install -y curl gnupg \
    && mkdir -p /etc/apt/keyrings \
    && curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg \
    && echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_22.x nodistro main" | tee /etc/apt/sources.list.get.d/nodesource.list \
    && apt-get update && apt-get install -y nodejs

WORKDIR /app

# Copy source code
COPY . .

# Install Composer dependencies
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-dev --optimize-autoloader

# Install NPM dependencies & Build Frontend Assets (Vite)
RUN npm install && npm run build

# Optimasi Laravel
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

# Set permissions
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

EXPOSE 80
EXPOSE 443

CMD ["frankenphp", "run", "--config", "/etc/caddy/Caddyfile"]