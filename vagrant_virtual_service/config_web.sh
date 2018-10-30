#!/usr/bin/env bash

apt-get update
apt-get install -y apache2
if ! [ -L /var/www ]; then
  rm -rf /var/www
  ln -fs /vagrant /var/www

sudo apt-get install libapache2-mod-php7.0
#sudo a2enmod php5
sudo service apache2 reload

sudo apt-get install php-mysql

sudo service apache2 restart

fi



