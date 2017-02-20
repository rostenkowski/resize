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

php composer.phar install -o --prefer-dist
