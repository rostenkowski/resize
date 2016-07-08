#!/usr/bin/env bash

# add repository
sudo add-apt-repository ppa:ondrej/php

# install php
sudo apt-get update && \
sudo apt-get install \
	php-cli \
	php-cgi \
	php-curl \
	php-gd \
	php-imagick \
	php-mbstring

# composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

composer update -o --prefer-dist
