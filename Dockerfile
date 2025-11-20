# Imagen base con Apache y PHP 8.2
FROM php:8.2-apache

# Instalar extensiones necesarias
RUN apt-get update && apt-get install -y \
    unzip \
    zip \
    curl \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Copiar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar el proyecto al servidor
WORKDIR /var/www/html
COPY . .

# Instalar dependencias Laravel
RUN composer install --no-dev --optimize-autoloader

# Crear carpetas necesarias
RUN mkdir -p storage/framework/sessions \
    storage/framework/views \
    storage/framework/cache \
    storage/logs

# Dar permisos
RUN chmod -R 777 storage bootstrap/cache

# Activar mod_rewrite (necesario para rutas de Laravel)
RUN a2enmod rewrite

# Configurar Apache para que use public/
RUN echo "<VirtualHost *:80>
    DocumentRoot /var/www/html/public
    <Directory /var/www/html/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>" > /etc/apache2/sites-available/000-default.conf

EXPOSE 80
