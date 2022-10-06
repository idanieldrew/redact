FROM php:8.1-fpm

# Copy composer.json & composer.lock
COPY composer.lock composer.json /var/www/

# Work directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
                build-essential \
                libpng-dev \
                libpq-dev \
                zlib1g-dev \
                libxml2-dev \
                libzip-dev \
                libonig-dev \
                zip \
                curl \
                unzip \
                git

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Install extensions
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql
RUN docker-php-ext-install pdo pdo_pgsql
RUN docker-php-ext-install gd

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Create group for laravel app id=1000 nameGp=www
RUN groupadd -g 1000 www

# Create user for laravel app id=1000 username=www spacificGp=www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy app content
COPY . /var/www

# Copy permission
COPY --chmod=777 . /var/www

# Change cuurent usert to www
USER www

CMD ["php-fpm"]
