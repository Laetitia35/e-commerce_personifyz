# Utiliser PHP 8.2 avec Apache
FROM php:8.2-apache

# Installer les extensions PHP nécessaires
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libonig-dev \
    libzip-dev \
    zip \
    unzip \
    iputils-ping \
    curl \
    git \
    && docker-php-ext-install intl opcache pdo pdo_mysql \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# Installer Composer depuis l'image officielle
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

# Vérifier que Composer est bien installé
RUN composer --version

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier le code source dans le conteneur
COPY . .

# Assurer les permissions correctes
RUN chown -R www-data:www-data /var/www/html

RUN which composer
RUN composer --version


# Installer les dépendances Symfony
RUN composer install --no-interaction --optimize-autoloader --no-progress --no-scripts

# Ajuster les permissions pour Symfony
RUN mkdir -p var/cache var/logs && \
    chown -R www-data:www-data var/cache var/logs && \
    chmod -R 777 var/cache var/logs

# Copier la configuration Apache
COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Exposer le port 80 pour Apache
EXPOSE 80

# Démarrer Apache
CMD ["apache2-foreground"]
