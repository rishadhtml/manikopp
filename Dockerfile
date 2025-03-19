# Use PHP 8.1 Apache as the base image
FROM php:8.1-apache

# Install necessary dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
