#!/usr/bin/env bash

# Create and populate the jitterbug DB
vagrant ssh
cd /vagrant
mysql -u homestead -psecret -e "CREATE DATABASE IF NOT EXISTS jitterbug;"

# Download java 8
cd /
sudo apt-get update -y
sudo apt-get install openjdk-8-jdk -y

# Install PHP 5.6
sudo apt-get install php5.6 php5.6-ldap php5.6-fpm php5.6-mbstring php5.6-dom -y

# set the php symlink to point to the 5.6 version (for cli)
sudo update-alternatives --set php /usr/bin/php5.6

# Download Solr
cd ~
# get the latest 7.x release via https://lucene.apache.org/solr/mirrors-solr-latest-redir.html
sudo wget http://archive.apache.org/dist/lucene/solr/7.2.1/solr-7.2.1.tgz
# extract the service installation file
sudo tar xzf solr-7.2.1.tgz solr-7.2.1/bin/install_solr_service.sh --strip-components=2
# install Solr as a service
sudo ./install_solr_service.sh solr-7.2.1.tgz

# Get the MySQL connector file and unzip it if needed
cd /vagrant
sudo wget -nc http://www.mirrorservice.org/sites/ftp.mysql.com/Downloads/Connector-J/mysql-connector-java-8.0.15.zip
sudo unzip -n mysql-connector-java-8.0.15.zip

# Copy the MySQL connector file to the right place
cd /
sudo cp /vagrant/mysql-connector-java-8.0.15/mysql-connector-java-8.0.15.jar /opt/solr/contrib/dataimporthandler-extras/lib/.

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
mkdir jitterbug-masters
mkdir jitterbug-transfers

# configure the core properties and symlink the
# core conf directories to the ones in the jitterbug repo

# jitterbug-items
cd jitterbug-items
cat /vagrant/dev_files/jitterbug-items.core.properties.example > core.properties
ln -s /vagrant/solrconfig/jitterbug-items/conf conf
cd ..

# jitterbug-masters
cd jitterbug-masters
cat /vagrant/dev_files/jitterbug-masters.core.properties.example > core.properties
ln -s /vagrant/solrconfig/jitterbug-masters/conf conf
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
npm install
php artisan key:generate
gulp
