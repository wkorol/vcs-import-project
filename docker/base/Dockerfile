FROM php:8.1.0-apache-buster as vcs-import-api-base

RUN apt-get -y update && apt-get -y upgrade && apt-get -y install git bash libpq-dev libzip-dev unzip
RUN docker-php-ext-install pdo pdo_pgsql
RUN groupadd --gid 1000 vcs-import \
  && useradd --uid 1000 --gid vcs-import-project --shell /bin/bash --create-home vcs-import-project

RUN docker-php-ext-install opcache zip

COPY --from=composer:2.1.14 /usr/bin/composer /usr/bin/composer

WORKDIR /home/vcs-import-project