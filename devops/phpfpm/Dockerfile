# Sử dụng image php:8.0-fpm-alpine
FROM php:8.3-fpm-alpine

# Arguments defined in docker-compose.yml
ARG user
ARG uid


RUN apk --update add freetype-dev \
    oniguruma-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    shadow \
    libzip-dev \
    gettext \
    gettext-dev \
    icu-dev \
    git \
    wget \
    zip \
    unzip\
    curl\
    vim\
    nano

RUN docker-php-ext-install pdo_mysql mbstring zip gettext intl exif
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install -j$(nproc) gd

RUN apk add --update --no-cache linux-headers
RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
    && pecl install xdebug-3.3.1 \
    && docker-php-ext-enable xdebug \
    && apk del -f .build-deps

ARG PUID=1000
ENV PUID ${PUID}
ARG PGID=1000
ENV PGID ${PGID}


RUN groupadd -g ${PGID} www
RUN useradd -u ${PUID} -ms /bin/bash -g www www

COPY ./devops/phpfpm/custom-php.ini /usr/local/etc/php/conf.d/

# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Tạo thư mục /var/www
RUN mkdir -p /var/www

WORKDIR /var/www/

# Copy toàn bộ file trong thư mục ở máy local vào trong thư mục /var/www/html ở trong container
COPY . /var/www/

COPY --chown=www:www . /var/www

USER www
RUN composer install
RUN composer dump-autoload
EXPOSE 9000
