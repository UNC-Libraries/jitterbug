#!/usr/bin/env bash

# Create the jitterbug DB & jitterbug test DB
vagrant ssh
cd /vagrant
mysql -u homestead -psecret -e "CREATE DATABASE IF NOT EXISTS jitterbug; CREATE DATABASE IF NOT EXISTS jitterbug_testing;"

# Download java 8
cd /
sudo apt-get update -y
sudo apt-get install openjdk-8-jdk -y

# Install PHP 7.3
sudo DEBIAN_FRONTEND=noninteractive apt-get install php7.3 php7.3-ldap php7.3-fpm php7.3-mbstring php7.3-dom php7.3-mysql -y

# set the php symlink to point to the 7.3 version (for cli)
sudo update-alternatives --set php /usr/bin/php7.3

# Download Solr
cd ~
# get the latest 8.x release via https://solr.apache.org/downloads.html
sudo wget --no-verbose https://downloads.apache.org/lucene/solr/8.9.0/solr-8.9.0.tgz
# extract the service installation file
sudo tar xzf solr-8.9.0.tgz solr-8.9.0/bin/install_solr_service.sh --strip-components=2
# install Solr as a service
sudo ./install_solr_service.sh solr-8.9.0.tgz

# Get the MySQL connector file and unzip it if needed
cd /vagrant
sudo wget --no-verbose -nc http://www.mirrorservice.org/sites/ftp.mysql.com/Downloads/Connector-J/mysql-connector-java-8.0.24.zip
sudo unzip -n mysql-connector-java-8.0.24.zip

# Copy the MySQL connector file to the right place
cd /
sudo cp /vagrant/mysql-connector-java-8.0.24/mysql-connector-java-8.0.24.jar /opt/solr/contrib/dataimporthandler-extras/lib/.

# Change users/groups/permissions of Solr home directory files
cd /opt/solr
# change owner of all files here recursively to the solr user
sudo chown -R solr .
# change group of all files here recursively to the vagrant group
sudo chgrp -R vagrant .
# add write permissions to the vagrant group for these files
sudo chmod -R g+w .

#make folders for each of the cores needed for jitterbug
cd server/solr
mkdir jitterbug-items
mkdir jitterbug-instances
mkdir jitterbug-transfers

# configure the core properties and symlink the
# core conf directories to the ones in the jitterbug repo

# jitterbug-items
cd jitterbug-items
cat /vagrant/dev_files/jitterbug-items.core.properties.example > core.properties
ln -s /vagrant/solrconfig/jitterbug-items/conf conf
cd ..

# jitterbug-instances
cd jitterbug-instances
cat /vagrant/dev_files/jitterbug-instances.core.properties.example > core.properties
ln -s /vagrant/solrconfig/jitterbug-instances/conf conf
cd ..

# jitterbug-transfers
cd jitterbug-transfers
cat /vagrant/dev_files/jitterbug-transfers.core.properties.example > core.properties
ln -s /vagrant/solrconfig/jitterbug-transfers/conf conf
cd ..

cd /vagrant

# configure crontab
(crontab -l ; echo "* * * * * php /vagrant/artisan schedule:run >> /dev/null 2>&1") | crontab -

# install jitterbug dependencies
php /usr/local/bin/composer update
rm -rf node_modules/*
yarn install
php artisan key:generate
gulp

# run migrations on the DB and the testing DB
php artisan migrate
php artisan migrate --env=testing

# seed the Db with the non LDAP admin user
php artisan db:seed --class=UsersTableSeeder

# install chromium browser for Laravel Dusk browser tests
# and install ChromeDriver
sudo apt-get install chromium-browser
php artisan dusk:chrome-driver
