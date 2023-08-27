# Use the official PHP image with Apache
FROM php:8.2-apache

# Install necessary extensions and SQLite
RUN apt-get update && apt-get install -y libsqlite3-dev && docker-php-ext-install pdo_sqlite

# Set the working directory
WORKDIR /var/www/html

# Copy source code to the container
COPY . .

# Install required tools
RUN apt-get update && apt-get install -y \
    unzip \
    zip

# Set the environment variable to allow Composer to run as superuser
ENV COMPOSER_ALLOW_SUPERUSER=1

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install dependencies with Composer
RUN composer install

# Custom Apache configuration to change the DocumentRoot
RUN echo '<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        AllowOverride All\n\
        Order Allow,Deny\n\
        Allow from All\n\
    </Directory>\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# Enable mod_rewrite for routing
RUN a2enmod rewrite

# Set permissions for SQLite database
RUN chmod 664 db.sqlite && \
    chown www-data:www-data db.sqlite
