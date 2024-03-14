FROM php:8.2-fpm

ARG user=operations
ARG uid=1000

# Install system dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libzip-dev \
    git \
    curl  \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip


# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql zip mbstring exif pcntl bcmath gd xml

# Get latest Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user  $user

# Set working directory
WORKDIR /var/www/html

COPY ./prueba-api .

RUN composer update \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --no-dev \
    --prefer-dist

RUN chown -R $user:$user /var/www/html

USER $user
#RUN php artisan optimize:clear
#RUN php artisan migrate
EXPOSE 9000

CMD ["php-fpm"]