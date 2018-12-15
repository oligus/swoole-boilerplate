FROM alpine:edge

RUN set -xe && \
    apk update && \
    apk upgrade && \
    apk add --no-cache bash curl \
        build-base \
        php7 \
        php7-ctype \
        php7-dev \
        php7-ast \
        php7-dom \
        php7-xml \
        php7-curl \
        php7-json \
        php7-phar \
        php7-iconv \
        php7-common \
        php7-opcache \
        php7-openssl \
        php7-simplexml \
        php7-tokenizer \
        php7-mbstring \
        php7-xmlwriter \
        php7-sqlite3 \
        php7-pdo \
        php7-pdo_sqlite \
        php7-pdo_mysql \
        php7-xdebug \
        php7-phalcon \
        sqlite \
        mysql-client \
        git \
        openssh \
        emacs \
        --repository http://dl-cdn.alpinelinux.org/alpine/edge/main/ \
        --repository http://dl-cdn.alpinelinux.org/alpine/edge/community/ \
        --repository http://dl-cdn.alpinelinux.org/alpine/edge/testing/ && \
        git clone https://github.com/swoole/swoole-src.git && \
        cd swoole-src && phpize && ./configure && make && make install && \
    rm -rf /tmp/* /var/cache/apk/*

ENV COMPOSER_ALLOW_SUPERUSER 1
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer && \
    composer global require "hirak/prestissimo:^0.3" --prefer-dist --no-progress --no-suggest --optimize-autoloader --classmap-authoritative

## Enable swoole
RUN echo "extension=swoole.so" > /etc/php7/conf.d/swoole.ini

## Enable xdebug, makes phan/lint/phpunit slower
# RUN  /bin/sed -i "s|;zend_extension=xdebug.so|zend_extension=xdebug.so|g" /etc/php7/conf.d/xdebug.ini

WORKDIR /var/www/html

