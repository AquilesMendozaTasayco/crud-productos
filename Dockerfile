FROM php:8.2-fpm

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl \
    libzip-dev \
    libonig-dev \
    libxml2-dev

RUN docker-php-ext-install pdo pdo_mysql zip

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar el proyecto
WORKDIR /var/www/html
COPY . .

# Instalar dependencias PHP
RUN composer install --no-dev --optimize-autoloader

# Instalar Node 20 (solo para build de Vite)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Construir assets
RUN npm install && npm run build

# Permisos
RUN chmod -R 777 storage bootstrap/cache

# Exponer puerto
EXPOSE 8000

# Ejecutar Laravel (modo producción)
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
