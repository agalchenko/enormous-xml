FROM php:7.1-fpm

RUN docker-php-ext-install pdo_mysql

RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

RUN apt-get update
RUN apt-get install -y git

RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/bin/composer

COPY conf/php.ini /etc/php/7.1/fpm/conf.d/40-custom.ini
