FROM php:7.3-fpm

RUN apt-get update && apt-get install -y \
    openssl \
    libssl-dev \
    libxml2-dev \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libjpeg-dev \
    && docker-php-ext-install -j$(nproc) openssl pdo_mysql mbstring zip tokenizer xml ctype json

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

COPY .env.example .env
RUN php artisan key:generate

COPY . /var/www/html

RUN composer install --no-dev --optimize-autoloader

RUN php artisan migrate --force

CMD ["php-fpm"]
