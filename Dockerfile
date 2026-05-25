# Gunakan image PHP 8.3
FROM php:8.3-cli

# Update dan instal dependensi sistem:
# - libpq-dev: Wajib untuk PostgreSQL
# - libzip-dev: Untuk kompresi zip
RUN apt-get update && apt-get install -y \
    git unzip zip curl libzip-dev nodejs npm \
    libpq-dev \
    && docker-php-ext-install zip pdo pdo_mysql pdo_pgsql pgsql

# Copy composer dari official image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy source code ke container
COPY . .

# Membuat direktori yang diperlukan dan memberikan permission
RUN mkdir -p storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Instal dependencies
RUN composer install --no-dev --optimize-autoloader
RUN npm install
RUN npm run build

# Menjalankan aplikasi
EXPOSE 10000

# Pastikan port menggunakan variabel lingkungan dari Render
CMD php artisan serve --host=0.0.0.0 --port=${PORT:-10000}