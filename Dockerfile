FROM php:8.1-fpm-alpine

RUN docker-php-ext-install pdo pdo_mysql

RUN apk --update upgrade \
    && apk add linux-headers autoconf automake make gcc g++ libtool pkgconfig libmcrypt-dev re2c git zlib-dev xdg-utils libpng-dev freetype-dev libjpeg-turbo-dev openssh-client libxslt-dev ca-certificates gmp-dev \
    && update-ca-certificates

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
