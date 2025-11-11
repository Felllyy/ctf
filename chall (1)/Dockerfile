FROM php:8.2-apache

COPY flag.txt /flag.txt

COPY php-custom.ini /usr/local/etc/php/conf.d/zz-upload-limit.ini

RUN apt-get update && apt-get install -y yara && \
    mv /usr/bin/yara /usr/local/bin/yara-bin && \
    rm -rf /var/lib/apt/lists/*

RUN echo '#!/bin/bash' > /usr/bin/yara && \
    echo 'sleep 0.5' >> /usr/bin/yara && \
    echo '/usr/local/bin/yara-bin "$@"' >> /usr/bin/yara && \
    chmod +x /usr/bin/yara

RUN mkdir -p /etc/yara/rules

COPY rules/virus_rules.yar /etc/yara/rules/virus_rules.yar

COPY src/ /var/www/html

WORKDIR /var/www/html

RUN mkdir -p uploads && \
    chown -R www-data:www-data uploads && \
    chmod -R 775 uploads