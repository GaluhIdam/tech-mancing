# Use the official PHP image with Apache
FROM php:8.1-apache

# Set the working directory
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git

# Install PHP extensions
RUN docker-php-ext-install zip pdo_mysql

# Enable Apache modules
RUN a2enmod rewrite

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy the custom Apache configuration
COPY apache-config.conf /etc/apache2/sites-available/000-default.conf

# Enable the custom Apache configuration
RUN a2ensite 000-default

# Copy the application code
COPY . .

# Install Composer dependencies
RUN composer install --optimize-autoloader --no-dev

# Set the correct permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
