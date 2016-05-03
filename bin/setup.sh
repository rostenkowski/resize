#!/usr/bin/env bash

# add repository
sudo add-apt-repository ppa:ondrej/php5-5.6

# install php latest 5.6
sudo apt-get update && sudo apt-get install \
	python-software-properties \
	imagemagick \
	php5-cli \
	php5-cgi \
	php5-curl \
	php5-imagick \
	php5-gd

# composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
composer install -o --prefer-dist
