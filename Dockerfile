# Use the official PHP-Apache image
FROM php:8.2-apache

# Install MySQL-related extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy project files to the container
COPY . /var/www/html/

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose port 80 for web access
EXPOSE 80
