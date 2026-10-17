# Imagen: PHP con Apache, versión compatible con AWS (PHP 8.3)
ARG PHP_VERSION=8.3-apache
FROM php:${PHP_VERSION}

# Extensiones para conectar con MySQL (iguales a AWS)

RUN docker-php-ext-install pdo_mysql mysqli

#Extensiones necesarias para Laravel y WordPress
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libicu-dev \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mysqli mbstring zip gd intl \
    && apt-get clean && rm -rf /var/lib/apt/lists/* 

#Habilitar mod_rewrite de Apache
RUN a2enmod rewrite

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

#Directorio de trabajo
WORKDIR /var/www/html

