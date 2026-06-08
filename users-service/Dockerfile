FROM php:8.3-fpm-alpine

# Install system dependencies
RUN apk add --no-cache nginx curl mysql-client

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql opcache

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# Copy config files
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/php.ini /usr/local/etc/php/conf.d/custom.ini

EXPOSE 80

CMD sh -c "php-fpm -D && nginx -g 'daemon off;'"