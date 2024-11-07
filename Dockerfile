FROM php:8.2-apache

# Copy app files from the app directory.
COPY ./src /var/www/html

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

USER www-data
