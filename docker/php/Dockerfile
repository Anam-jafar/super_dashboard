FROM php:8.1-apache

# Install system dependencies
RUN apt-get update -y && apt-get install -y \
    libicu-dev libmariadb-dev unzip zip zlib1g-dev libpng-dev \
    libjpeg-dev libfreetype6-dev libjpeg62-turbo-dev libzip-dev \
    git curl libcurl4-openssl-dev pkg-config libssl-dev \
    nodejs npm sudo vim nano && \
    apt-get clean

# Add www-data to sudoers for container debugging
RUN echo "www-data ALL=(ALL) NOPASSWD: ALL" >> /etc/sudoers

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install PHP extensions
RUN docker-php-ext-install gettext intl pdo_mysql zip \
    && docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

# Install MongoDB extension
RUN pecl install mongodb-1.20.0 \
    && docker-php-ext-enable mongodb

# Enable Apache modules
RUN a2enmod rewrite expires headers

# Copy Apache configuration
COPY ./docker/apache/vhost.conf /etc/apache2/sites-available/000-default.conf
COPY ./docker/apache/start-apache.sh /usr/local/bin/start-apache.sh
RUN chmod +x /usr/local/bin/start-apache.sh

# Set working directory
WORKDIR /var/www/html

# Copy Laravel project files
COPY . .

# Install Composer dependencies
RUN composer install \
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

# Set correct permissions for all Laravel directories
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
                    /var/www/html/bootstrap/cache

# Switch to www-data user
USER www-data

# Expose port
EXPOSE 80

# Start Apache (runs as root, but PHP processes will run as www-data)
CMD ["/usr/local/bin/start-apache.sh"]