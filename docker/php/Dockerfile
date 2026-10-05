FROM php:8.1-fpm-alpine

RUN cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini

RUN apk add tzdata && \
    cp /usr/share/zoneinfo/Europe/Minsk /etc/localtime && \
    apk add ${PHPIZE_DEPS} linux-headers --virtual .ext-deps && \
    docker-php-ext-install pdo_mysql && \
    pecl install xdebug && \
    docker-php-ext-enable xdebug && \
    apk del .ext-deps tzdata && \
    rm -rf /var/cache/apk/*

RUN curl -o composer-setup.php https://getcomposer.org/installer && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    rm composer-setup.php

ENV PS1='\u@\h:\w\$ '

ARG USER_UID
ARG USER_GID

RUN deluser www-data && \
    addgroup www-data --gid ${USER_GID} && \
    adduser www-data --uid ${USER_UID} --ingroup www-data --disabled-password
