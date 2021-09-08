FROM php:7.4-fpm

ENV NVM_DIR /root/.nvm
ENV NODE_VERSION 10.16.2

ENV YARN_VERSION 1.17.3

ENV COMPOSER_DIR /usr/local/bin

COPY docker/php/.bashrc /etc/bash.bashrc

# Change fpm port from 9000 to 9001. Beacause of collision with xdebug default port.
RUN sed -i 's/9000/9001/' /usr/local/etc/php-fpm.d/zz-docker.conf

RUN apt-get update && apt-get install -y --no-install-recommends \
    sudo \
    wget \
    openssl \
    git \
    zip \
    libzip-dev \
    gnupg2 \
    libicu-dev \
    libpng-dev \
    libc-client-dev \
    libkrb5-dev \
    libjpeg-dev \
    libcurl4-gnutls-dev \
    libgnutls28-dev \
    ca-certificates \
    libzip-dev \
    cron \
    libpq-dev \
    openssh-client

RUN apt-get install -y --no-install-recommends \
    imagemagick \
    libmagickwand-dev \
    && rm -r /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer \
    | php -- --install-dir=$COMPOSER_DIR --filename=composer \
    && composer --version

# Install NVM and Yarn
RUN curl -sL https://raw.githubusercontent.com/creationix/nvm/v0.38.0/install.sh | bash \
    && . $NVM_DIR/nvm.sh \
    && nvm install $NODE_VERSION \
    && npm install -g yarn \
    && yarn set version $YARN_VERSION

# Install PHP extentions
RUN docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && docker-php-ext-install bcmath zip \
    && pecl install xdebug-2.9.8 \
    && docker-php-ext-enable xdebug

# PHP config
RUN echo 'memory_limit = -1' >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini

# Allow Composer to use all available RAM while installing packages
ENV COMPOSER_MEMORY_LIMIT="-1"

CMD ["php-fpm"]
