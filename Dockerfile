# -------- builder: composer stage (install PHP dependencies) ----------
FROM composer:2 AS vendor
WORKDIR /app

# Copy only composer files to leverage docker cache
COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader --no-scripts --no-progress

# Copy full source for vendor autoload optimization
COPY . /app
RUN composer dump-autoload --optimize --no-dev --classmap-authoritative

# -------- assets build stage (node) ----------
FROM node:18 AS assets
WORKDIR /app
COPY package*.json ./
RUN npm ci --silent
COPY . /app
RUN npm run build || true

# -------- final image: php + apache ----------
FROM php:8.1-apache

# System deps
RUN apt-get update && DEBIAN_FRONTEND=noninteractive apt-get install -y \
    libzip-dev zip unzip git libpng-dev libonig-dev libxml2-dev libonig5 zlib1g-dev \
  && docker-php-ext-install pdo_mysql zip gd bcmath sockets \
  && a2enmod rewrite headers

# Install supervisor for process control if needed
RUN apt-get install -y supervisor && rm -rf /var/lib/apt/lists/*

# Set working dir
WORKDIR /var/www/html

# Copy application files
COPY --from=vendor /app /var/www/html
COPY --from=assets /app/public /var/www/html/public

# Ensure permissions (best-effort; adjust as needed for your host)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache || true
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache || true

ENV PATH="/var/www/html/vendor/bin:${PATH}"

EXPOSE 80

# Default command
CMD ["apache2-foreground"]
