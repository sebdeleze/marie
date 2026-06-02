#syntax=docker/dockerfile:1.4

ARG NODE_VERSION=18

FROM composer/composer:2-bin AS composer
FROM mlocati/php-extension-installer:latest AS php_extension_installer
FROM surnet/alpine-wkhtmltopdf:3.20.0-0.12.6-full as wkhtmltopdf
FROM node:${NODE_VERSION}-alpine AS node
FROM php:8.3.19-fpm-alpine3.20 as iomedia_php

ENV TZ=Europe/Zurich
ENV PNGOUT_VERSION=20150319
ENV OPTIPNG_VERSION=0.7.5
ENV GIFSICLE_VERSION=1.92
ENV IJG_VERSION=9a

WORKDIR /var/www

# php extensions installer: https://github.com/mlocati/docker-php-extension-installer
COPY --from=php_extension_installer /usr/bin/install-php-extensions /usr/local/bin/

RUN apk add --no-cache \
    mysql-client \
    git \
    openssh \
    icu-libs \
    zlib \
    jq \
    bash \
    nano \
    freetype \
    libpng \
    libjpeg-turbo \
    tzdata \
    imagemagick \
    file \
    parallel \
    jpegoptim \
    pngquant \
    libwebp \
    libwebp-tools \
    imagemagick \
    imagemagick-libs \
    imagemagick-dev \
    imap-dev \
    shadow \
    tar \
    pngcrush \
    openrc \
    at \
    rsync \
    sshpass \
    bind-tools \
    ffmpeg \
    ttf-dejavu \
    ttf-droid \
    ttf-freefont \
    ttf-liberation \
    make \
    ansible \
    gcc \
    make \
    g++ \
    zlib-dev \
    chromium \
    chromium-chromedriver \
    xvfb \
    $PHPIZE_DEPS \
    linux-headers

RUN set -eux; \
    install-php-extensions \
    intl \
    zip \
    apcu \
    opcache \
    imagick \
    xsl \
    soap \
    memcached \
    igbinary \
    ssh2 \
    pcntl \
    pdo_mysql \
    imap \
    gd \
    bcmath \
    mongodb \
    calendar \
    imagick \
    ftp \
    xdebug \
    ;

# jpegtran
RUN curl -L -O http://www.ijg.org/files/jpegsrc.v$IJG_VERSION.tar.gz \
    && tar zxf jpegsrc.v$IJG_VERSION.tar.gz \
    && cd jpeg-$IJG_VERSION \
    && ./configure && make && make install \
    && cd ..

# optipng
RUN curl -L -O http://downloads.sourceforge.net/project/optipng/OptiPNG/optipng-$OPTIPNG_VERSION/optipng-$OPTIPNG_VERSION.tar.gz \
    && tar zxf optipng-$OPTIPNG_VERSION.tar.gz \
    && cd optipng-$OPTIPNG_VERSION \
    && ./configure && make && make install \
    && cd ..

# pngout
RUN curl -L -O https://www.jonof.id.au/files/kenutils/pngout-$PNGOUT_VERSION-linux-static.tar.gz \
    && tar zxf pngout-$PNGOUT_VERSION-linux-static.tar.gz \
    && cd pngout-$PNGOUT_VERSION-linux-static \
    && cp -f x86_64/pngout-static /usr/local/bin/pngout \
    && cd ..

# gifsicle
RUN curl -L -O https://www.lcdf.org/gifsicle/gifsicle-$GIFSICLE_VERSION.tar.gz \
    && tar zxf gifsicle-$GIFSICLE_VERSION.tar.gz \
    && cd gifsicle-$GIFSICLE_VERSION \
    && ./configure && make && make install \
    && cd ..

COPY --from=wkhtmltopdf /bin/wkhtmltopdf /bin/wkhtmltopdf
COPY --from=wkhtmltopdf /bin/wkhtmltoimage /bin/wkhtmltoimage
COPY --from=wkhtmltopdf /bin/libwkhtmltox* /bin/

COPY --from=node /usr/lib /usr/lib
COPY --from=node /usr/local/share /usr/local/share
COPY --from=node /usr/local/lib /usr/local/lib
COPY --from=node /usr/local/include /usr/local/include
COPY --from=node /usr/local/bin /usr/local/bin
RUN rm /usr/local/bin/yarn && rm /usr/local/bin/yarnpkg
RUN npm install --global yarn nodemon svgo

RUN set -e \
    && ln -s $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini
COPY php.ini $PHP_INI_DIR/conf.d/symfony.ini

# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV PATH="${PATH}:/root/.composer/vendor/bin"

COPY --from=composer /composer /usr/bin/composer
ENV PATH="${PATH}:/root/.composer/vendor/bin"

# git subtree : used for be able to mono-repo split
RUN mkdir -p /tmp/git \
    && curl -A "Docker" -L https://github.com/git/git/archive/v2.38.4.tar.gz | tar zxp -C /tmp/git \
    && cd /tmp/git/git-2.38.4/contrib/subtree \
    && make \
    && install -m 755 git-subtree /usr/libexec/git-core \
    && rm -Rf /tmp/git

RUN git config --global user.email "github@iomedia.ch"
RUN git config --global user.name "iomedia bot"

ARG UID=1000
ARG GID=1000

RUN groupadd -g ${GID} app && useradd -u ${UID} -g app -m app

USER app

CMD ["php-fpm", "-F"]
