FROM php:8.1-fpm

# Install system dependencies
RUN apt-get update -y && apt-get install -y \
    libicu-dev libmariadb-dev unzip zip zlib1g-dev libpng-dev \
    libjpeg-dev libfreetype6-dev libjpeg62-turbo-dev libzip-dev \
    git curl libcurl4-openssl-dev pkg-config libssl-dev \
    nodejs npm && \
    apt-get clean

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install PHP extensions
RUN docker-php-ext-install gettext intl pdo_mysql zip \
    && docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

# Install MongoDB extension
RUN pecl install mongodb && docker-php-ext-enable mongodb

# Set working directory
WORKDIR /var/www/html

# Copy Laravel project files
COPY . .

# Install Composer dependencies
RUN composer install \
    --no-dev \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist \
    --optimize-autoloader 

# Generate Laravel key
RUN php artisan key:generate

# Regenerate autoload files (critical step)
RUN composer dump-autoload -v

# Install Node.js dependencies
RUN npm install && npm run build 

# Set correct permissions
RUN chown -R www-data:www-data /var/www/html/storage \
                                /var/www/html/bootstrap/cache \
                                /var/www/html/vendor \
    && chmod -R 775 /var/www/html/storage \
                    /var/www/html/bootstrap/cache

# Expose port
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]

