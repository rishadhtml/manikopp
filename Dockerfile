FROM php:8.2-apache

# Enable required extensions
RUN docker-php-ext-install pdo pdo_sqlite

# Enable mod_rewrite for clean URLs
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Set permissions
RUN chmod -R 777 /uploads

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
