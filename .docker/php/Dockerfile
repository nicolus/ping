FROM php:8.3-apache

ARG UID=1002
ARG GID=1002

ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Copy PHP config files from the current directory
COPY  ./opcache.ini /usr/local/etc/php/conf.d/opcache.ini
COPY  ./xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
COPY  ./php.ini /usr/local/etc/php/conf.d/php-additional-config.ini

# Copy composer executable from the composer docker image
COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN apt-get update && \
    apt-get install --yes \
        libzip-dev \
        git \
        curl \
        zip \
        libicu-dev \
        libpng-dev \
        default-mysql-client \
    && docker-php-ext-configure pcntl --enable-pcntl \
    && docker-php-ext-install \
        opcache \
        zip \
        mysqli \
        pdo_mysql \
        intl \
        bcmath \
        pcntl \
        gd \
    && pecl install \
        xdebug \
        redis \
    && docker-php-ext-enable \
        xdebug \
        redis \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN a2enmod rewrite

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# set the www-data user and group id to 1000 the same as the host user (eg: 1000 or 1001)
RUN usermod -u ${UID} www-data
RUN groupmod -g ${GID} www-data

# Create the .composer dir that we'll mount to make www-data its owner
RUN mkdir /var/www/.composer
# Change the owner of the /var/www folder to www-data
RUN chown -R www-data:www-data /var/www

USER www-data