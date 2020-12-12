FROM phpswoole/swoole:4.5.9-php7.4

RUN apt-get update

RUN apt-get install openssl -y && \
    apt-get install libssl-dev -y && \
    apt-get install procps -y && \
    apt-get install net-tools -y && \
    apt-get install wget -y

RUN docker-php-ext-install pdo_mysql

WORKDIR /var/www/html

ENTRYPOINT ["/usr/local/bin/php", "/var/www/html/public/index.php"]
