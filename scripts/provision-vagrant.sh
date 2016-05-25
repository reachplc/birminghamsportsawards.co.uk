#!/bin/sh
#
# Setup the vagrant environment

# Copy site .conf file accross
sudo cp /vagrant/config/environments/development.conf /etc/apache2/sites-available/birminghamsportsawards.local.conf
sudo rm -rf /var/www
sudo mkdir -p /var/www
sudo ln -fs /vagrant /var/www/birminghamsportsawards.local

# Enable new virtual host
sudo ln -fs /etc/apache2/sites-available/birminghamsportsawards.local.conf /etc/apache2/sites-enabled/birminghamsportsawards.local.conf

# Restart Apache
sudo service apache2 restart

# Setup database
mysql -u root -proot -e "create database if not exists birminghamsportsawards"
#mysql -u root -proot birminghamsportsawards < /vagrant/config/bootstrap.sql

# Install Composer Dependencies
php /usr/local/bin/composer.phar update --working-dir="/var/www/birminghamsportsawards.local" --no-interaction --prefer-source

# Node
npm -v
npm install -g grunt-cli
npm install -g bower
