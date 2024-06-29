FROM php:8.3-cli

COPY  ./opcache.ini /usr/local/etc/php/conf.d/opcache.ini
COPY  ./xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

RUN apt-get update && \
    apt-get install --yes \
        libzip-dev \
        git \
        curl \
        zip \
        libicu-dev \
    && docker-php-ext-configure pcntl --enable-pcntl \
    && docker-php-ext-install \
        opcache \
        zip \
        mysqli \
        pdo_mysql \
        intl \
        bcmath \
        pcntl \
    && pecl install \
        xdebug \
        redis \
    && docker-php-ext-enable \
        xdebug \
        redis \
    && curl -sLS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*