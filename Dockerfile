FROM php:8.3-fpm

# Set working directory
WORKDIR /var/www

# Install system dependencies (Node via apt is OK for now)
RUN apt-get update && apt-get install -y \
    build-essential \
    locales \
    zip \
    unzip \
    git \
    curl \
    libonig-dev \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libgd-dev \
    nodejs \
    npm \
 && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-external-gd
RUN docker-php-ext-install gd

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
  --install-dir=/usr/local/bin --filename=composer

# Create user
RUN groupadd -g 1000 www && useradd -u 1000 -ms /bin/bash -g www www

# Copy app code with correct ownership
COPY --chown=www:www . /var/www

# Ensure writable dirs exist
RUN mkdir -p /var/www/vendor /var/www/storage /var/www/bootstrap/cache \
 && chown -R www:www /var/www

# Switch to non-root user
USER www

# Install dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader
RUN npm install
RUN npm run build

# PHP-FPM
# Railway will set $PORT automatically
EXPOSE 8080
CMD ["sh", "-c", "php artisan serve --host=0.0.0.0 --port=${PORT:-8080}"]

