FROM php:8.2-apache

# -------------------------
# 1. Instalar dependencias del sistema
# -------------------------
RUN apt-get update && apt-get install -y \
    unzip zip git curl \
    libonig-dev libxml2-dev libzip-dev

# -------------------------
# 2. Instalar Node.js 20 (LTS) - IMPORTANTE
# -------------------------
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs

# -------------------------
# 3. Instalar extensiones PHP
# -------------------------
RUN docker-php-ext-install pdo pdo_mysql zip

# -------------------------
# 4. Instalar Composer
# -------------------------
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# -------------------------
# 5. Copiar el proyecto
# -------------------------
WORKDIR /var/www/html
COPY . .

# -------------------------
# 6. Instalar dependencias de Laravel
# -------------------------
RUN composer install --no-dev --optimize-autoloader

# -------------------------
# 7. Instalar dependencias JS y compilar Vite
# -------------------------
RUN npm install
RUN npm run build

# -------------------------
# 8. Permisos necesarios
# -------------------------
RUN chmod -R 777 storage bootstrap/cache

# -------------------------
# 9. Habilitar mod_rewrite
# -------------------------
RUN a2enmod rewrite

# -------------------------
# 10. Configurar Apache para usar /public
# -------------------------
RUN printf "<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
</VirtualHost>" \
    > /etc/apache2/sites-available/000-default.conf

EXPOSE 80
