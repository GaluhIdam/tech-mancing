FROM php:8.2-fpm

WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql

COPY . .

# Install project dependencies
RUN composer install --no-interaction --optimize-autoloader --no-suggest

CMD php artisan serve --host=0.0.0.0 --port=3005
