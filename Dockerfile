# Use official PHP image
FROM php:8.1-apache

# Enable required modules
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Set working directory
WORKDIR /var/www/html

# Copy files
COPY . .

# Expose port 80
EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"]
