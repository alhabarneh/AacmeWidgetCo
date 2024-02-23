FROM php:8.3-apache
RUN apt update -y
RUN apt install -y build-essential

RUN docker-php-ext-install pdo pdo_mysql

COPY ./app /var/www/html/
WORKDIR /var/www/html

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install
RUN /etc/init.d/apache2 start