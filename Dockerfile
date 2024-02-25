FROM php:8.3-apache
RUN apt update -y
RUN apt install -y \ 
sudo \
build-essential \
g++ \
zip \
curl \
libzip-dev

RUN docker-php-ext-install pdo pdo_mysql

COPY . /var/www/html/
WORKDIR /var/www/html

ENV  COMPOSER_ALLOW_SUPERUSER=1

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install
RUN /etc/init.d/apache2 start