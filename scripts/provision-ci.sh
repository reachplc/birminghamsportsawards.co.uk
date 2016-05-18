#!/bin/sh
#
# Provision the vagrant environment


# Setup PHP
echo "Setup PHP"
phpenv local 5.5

# Install PHP dependancies
echo "# Install PHP dependancies"
composer install --no-interaction
./vendor/bin/phpcs --config-set installed_paths ./vendor/wp-coding-standards/wpcs/

# Setup Node
echo "Setup Node"
nvm install 0.12.7
nvm use 0.12.7

# Install dependancies for running your tests or other tasks
echo "Install dependancies for running your tests or other tasks"
npm install grunt-cli -g
npm install -g bower

# Setup Theme
echo "Setup Theme"
npm install --prefix ./html/app/themes/tm-events-2016/
cd ./html/app/themes/tm-events-2016/
bower install
grunt dev
cd ~/clone
#grunt --base ./html/app/themes/ctba-2016/ dev
