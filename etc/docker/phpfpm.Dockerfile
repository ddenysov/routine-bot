# syntax = docker/dockerfile:1.0-experimental

FROM php:8.0.10-fpm-alpine3.13

ARG DA_DEBUG

RUN apk add --no-cache unzip libxml2 libxml2-dev libpng-dev libzip-dev readline-dev gettext-dev oniguruma-dev \
    mediainfo ffmpeg groff py-pip freetype-dev libpng-dev libjpeg-turbo-dev git icu-dev php8-pecl-apcu bash \
    gifsicle jpegoptim optipng pngquant \
    && docker-php-ext-install -j$(nproc) bcmath calendar exif gd gettext opcache pcntl pdo_mysql mysqli soap zip \
    && docker-php-ext-configure gd --with-jpeg --with-freetype \
    && docker-php-ext-install gd \
    && pip install awscli \
    && apk add --no-cache --repository http://dl-cdn.alpinelinux.org/alpine/edge/community/ --allow-untrusted gnu-libiconv \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=2.1.5 \
    && if [ "$DA_DEBUG" = "true" ]; then apk add --no-cache $PHPIZE_DEPS && pecl install xdebug-3.0.4 \
    && docker-php-ext-enable xdebug; fi

RUN apk update && apk add --no-cache libv8-alpine && pecl install v8js  \
    && docker-php-ext-enable v8js

ENV LD_PRELOAD /usr/lib/preloadable_libiconv.so php
ENV GIT_SSL_NO_VERIFY=true
