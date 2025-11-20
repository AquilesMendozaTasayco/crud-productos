FROM php:8.2-apache

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    unzip zip git curl \
    nodejs npm \
    libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

# Instalar dependencias de PHP
RUN composer install --no-dev --optimize-autoloader

# Instalar dependencias de Vite
RUN npm install
RUN npm run build

# Permisos
RUN chmod -R 777 storage bootstrap/cache

# Activar mod_rewrite
RUN a2enmod rewrite

# Configurar Apache
RUN printf "<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
</VirtualHost>" \
    > /etc/apache2/sites-available/000-default.conf

EXPOSE 80
RUN php artisan config:clear && php artisan cache:clear && php artisan view:clear
