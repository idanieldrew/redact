FROM php:8.1-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

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
RUN docker-php-ext-install sockets
# add pcntl
RUN docker-php-ext-install pcntl

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Set working directory
WORKDIR /var/www

USER $user
