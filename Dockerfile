FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

# Crear .env desde el ejemplo
RUN cp .env.example .env

# Instalar dependencias y permisos
RUN composer install --no-dev --optimize-autoloader \
 && chmod -R 775 storage bootstrap/cache

EXPOSE 10000
CMD php -S 0.0.0.0:10000 -t public