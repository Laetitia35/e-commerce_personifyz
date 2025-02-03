# Utiliser une image PHP 8.2 avec Apache
FROM php:8.2-apache

# Installer les extensions nécessaires
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libonig-dev \
    libzip-dev \
    zip \
    unzip \
    iputils-ping \
    && docker-php-ext-install intl opcache pdo pdo_mysql \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier le code source dans le conteneur
COPY . .

# Installer les dépendances Symfony
RUN composer install --no-interaction --optimize-autoloader

# Assurer les permissions correctes
RUN mkdir -p /var/www/html/var && \
    chown -R www-data:www-data /var/www/html/var

# Copier la configuration Apache
COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Exposer le port 80 pour le serveur web
EXPOSE 80

# Entrée de commande pour démarrer Apache
CMD ["apache2-foreground"]


