FROM php:8.1-fpm

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer


RUN apt-get update -y && apt-get install -y \
    libicu-dev \
    libmariadb-dev \
    unzip zip \
    zlib1g-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libzip-dev \
    git \
    curl \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \
    && apt-get clean

RUN docker-php-ext-install gettext intl pdo_mysql zip \
    && docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

RUN pecl install mongodb && docker-php-ext-enable mongodb

WORKDIR /var/www/html

COPY . /var/www/html

COPY --chown=www-data:www-data . .

# Copy Composer files first (for caching optimization)
COPY composer.json composer.lock /var/www/html/


RUN composer install --ignore-platform-reqs
RUN composer dump-autoload --ignore-platform-reqs
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap /var/www/html/bootstrap/cache
RUN chmod -R 777 /var/www/html/storage /var/www/html/bootstrap /var/www/html/bootstrap/cache

# Install Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Copy package.json and package-lock.json first to optimize Docker caching
COPY package.json package-lock.json /var/www/html/

# Install NPM dependencies
RUN npm install

# Copy the rest of the frontend files
COPY resources/ /var/www/html/resources/

# Build Vite assets
RUN npm run build

# Set final permissions
RUN chown -R www-data:www-data /var/www/html

# Start PHP-FPM instead of Vite dev server (for production)
CMD ["php-fpm"]