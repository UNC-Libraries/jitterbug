#!/usr/bin/env bash

# Create and populate the jitterbug DB
vagrant ssh
cd /vagrant
mysql -u homestead -psecret -e "CREATE DATABASE IF NOT EXISTS jitterbug;"

# Download java 8
cd /
sudo apt-get update
sudo apt install openjdk-8-jdk -y

# Download Solr
cd ~
# get the latest 7.x release via https://lucene.apache.org/solr/mirrors-solr-latest-redir.html
sudo wget http://archive.apache.org/dist/lucene/solr/7.2.1/solr-7.2.1.tgz
# extract the service installation file
sudo tar xzf solr-7.2.1.tgz solr-7.2.1/bin/install_solr_service.sh --strip-components=2
# install Solr as a service
sudo ./install_solr_service.sh solr-7.2.1.tgz

# Move the MySQL connector file to the right place
cd /
sudo mv /vagrant/mysql-connector-java-8.0.15.jar /opt/solr/contrib/dataimporthandler-extras/lib/.

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
composer update -y
npm install
gulp
