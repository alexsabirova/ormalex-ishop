FROM php:8.3-fpm

#Arguments defined in docker-compose.yml
ARG user
ARG uid

#Install system dependencies
RUN apt-get update && apt-get install -y \
    build-essential zlib1g-dev default-mysql-client \
    curl npm gnupg procps vim git unzip libzip-dev libpq-dev \
  && docker-php-ext-install zip pdo_mysql pdo_pgsql pgsql

# intl
RUN apt-get install -y libicu-dev \
  && docker-php-ext-configure intl \
  && docker-php-ext-install intl

# gd
RUN apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev && \
docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ && \
docker-php-ext-install gd

#Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

#Get latest Composer \
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

#Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && chown -R $user:$user /home/$user

WORKDIR /var/www/html

USER $user
