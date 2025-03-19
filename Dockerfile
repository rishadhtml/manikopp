# Use the official PHP image with Apache
FROM php:8.2-apache

# Set the working directory
WORKDIR /var/www/html

# Copy the contents of the public folder to the web root
COPY public/ /var/www/html/

# Copy the config and other necessary files
COPY config/ /var/www/html/config/
COPY uploads/ /var/www/html/uploads/
COPY composer.json composer.lock /var/www/html/

# Install dependencies
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-install pdo_mysql mbstring zip

# Enable Apache mod_rewrite (if needed)
RUN a2enmod rewrite

# Expose port 80
EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"]
