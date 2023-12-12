# Use the official PHP image with Nginx
FROM php:8.1-fpm

# Set the working directory
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    nginx

# Install PHP extensions
RUN docker-php-ext-install zip pdo_mysql

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Remove the default Nginx index.html
RUN rm /var/www/html/index.nginx-debian.html

# Copy the Nginx configuration
COPY nginx.conf /etc/nginx/sites-available/default

# Copy the composer.json and composer.lock
COPY composer.json composer.lock ./

# Install Composer dependencies
RUN composer install --optimize-autoloader --no-dev
RUN composer update

# Copy the application code
COPY . .

# Make sure the "artisan" file is present
COPY artisan ./

# Set the correct permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html

# Expose port 80
EXPOSE 80

# Start Nginx and PHP-FPM
CMD ["nginx", "-g", "daemon off;"]
