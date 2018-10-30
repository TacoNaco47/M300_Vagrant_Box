#!/usr/bin/env bash

apt-get update

sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password verySecure'
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password verySecure'

sudo apt-get -y install mysql-server mysql-client

mysql --user=root --password=verySecure -e "CREATE DATABASE if not exists db_nbs_bank"

mysql --user=root --password=verySecure -e "create user 'db_nbs_bank_root'@'localhost' identified by 'verySecure';"
#mysql --user=root --password=verySecure -e "create user 'db_nbs_bank_root'@'10.4.184.89' identified by 'verySecure';"
#mysql --user=root --password=verySecure -e "create user 'db_nbs_bank_root'@'10.4.184.72' identified by 'verySecure';"


mysql --user=root --password=verySecure -e "grant all on *.* to 'db_nbs_bank_root'@'localhost' identified by 'verySecure';"
#mysql --user=root --password=verySecure -e "grant all on *.* to 'db_nbs_bank_root'@'10.4.184.89' identified by 'verySecure';"
#mysql --user=root --password=verySecure -e "grant all on *.* to 'db_nbs_bank_root'@'10.4.184.72' identified by 'verySecure';"


mysql --user=root --password=verySecure db_nbs_bank< /vagrant/tbl_nbs_bank.sql

mysql --user=root --password=verySecure -e "grant all privileges on db_nbs_bank.* to 'db_nbs_bank_root'@'localhost';"
#mysql --user=root --password=verySecure -e "grant all privileges on db_nbs_bank.* to 'db_nbs_bank_root'@'10.4.184.89';"
#mysql --user=root --password=verySecure -e "grant all privileges on db_nbs_bank.* to 'db_nbs_bank_root'@'10.4.184.72';"


mysql --user=root --password=verySecure -e "flush privileges;"


#sudo nano /etc/mysql/mysql.conf.d/mysqld.cnf

#-->
    # [mysqld]
    #
    # * Basic Settings
    #
    #   user            = mysql
    #   pid-file        = /var/run/mysqld/mysqld.pid
    #   socket          = /var/run/mysqld/mysqld.sock
    #   port            = 3306
    #   basedir         = /usr
    #   datadir         = /var/lib/mysql
    #   tmpdir          = /tmp
    #   lc-messages-dir = /usr/share/mysql
    #   skip-external-locking

        # Instead of skip-networking the default is now to listen only on
        # localhost which is more compatible and is not less secure.
    #   bind-address            = 10.4.184.131

#sudo service mysql restart

