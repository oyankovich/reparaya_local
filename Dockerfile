# Imagen: PHP con Apache, versión compatible con AWS (PHP 8.3)
ARG PHP_VERSION=8.3-apache
FROM php:${PHP_VERSION}

# Extensiones para conectar con MySQL (iguales a AWS)
RUN docker-php-ext-install pdo_mysql mysqli