FROM php:8.1-apache

RUN apt-get update && \
    apt-get -y install zip

# Change memory_limit
RUN cd /usr/local/etc/php/conf.d/ && \
    echo 'memory_limit = -1' >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer


