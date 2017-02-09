# Jitterbug
A Laravel / MySQL database management application for the Southern Folklife Collection in the Wilson Special Collections Library of UNC-Chapel Hill. Funded by an Andrew W. Mellon Foundation grant, "Extending the Reach of Southern Audiovisual Sources."

## Requirements
* [MySQL](https://dev.mysql.com/downloads/mysql/) >= 5.1 (developed using [Homebrew](http://brew.sh/) 5.7.10)
* [MySQL Connector/J](https://dev.mysql.com/downloads/connector/j/) (JDBC driver for MySQL, needed for initial Solr indexing)
* PHP 5.6 (developed using Homebrew 5.6.20)
* [Composer](https://getcomposer.org/)
	* Add composer to your path in .bashrc (export PATH=$PATH:/usr/local/bin/composer:~/.composer/vendor/bin)
* [npm](https://www.npmjs.com/) (developed using 2.15.1)
* [Solr 6.0](http://archive.apache.org/dist/lucene/solr/6.0.0/) (developed using 6.0)
* [Java 8](http://www.oracle.com/technetwork/java/javase/downloads/index.html) (for Solr)
* [Capistrano](http://capistranorb.com/) (developed using 3.6)
* [Ruby](https://www.ruby-lang.org/en/) (for Capistrano)

## Installation
1. If you are not a member of the Jitterbug LDAP group, submit a ticket and request access. You must be a member of the group in order to log into Jitterbug.
2. Get a fresh Jitterbug MySQL production database dump from a UNC library sysadmin.
3. Because the dump will contain views, you will need to remove the SQL security definers in the dump file. Using sed (on Mac OSX):
```bash
$ sed -i '' 's/DEFINER=[^*]*\*/\*/g' jitterbug-20170206.sql
```
4. Create an empty MySQL database locally.
```bash
$ mysql -u username -p
mysql> create database jitterbug
```
5. Import the MySQL dump.
```bash
$ mysql -u username jitterbug < jitterbug-20170206.sql -p
```
6. Clone the repo to your local machine ($JITTERBUG_HOME).
```bash
$ git clone git@github.com:UNC-Libraries/jitterbug.git jitterbug
```
7. If you have not already, unzip the MySQL Connector/J archive, then copy the jar file (mysql-connector-java-5.1.38-bin.jar) into $SOLR_HOME/contrib/dataimporthandler-extras/lib

8. Create the Solr core directories.
```bash
$ cd $SOLR_HOME/server/solr
$ mkdir jitterbug-items
$ mkdir jitterbug-masters
$ mkdir jitterbug-transfers
```
9. Symlink core conf directories to those in the git repo.
```bash
$ ln -s $JITTERBUG_HOME/solrconfig/jitterbug-items/conf jitterbug-items/conf
$ ln -s $JITTERBUG_HOME/solrconfig/jitterbug-masters/conf jitterbug-masters/conf
$ ln -s $JITTERBUG_HOME/solrconfig/jitterbug-transfers/conf jitterbug-transfers/conf
```
10. Create a core.properties file in each core directory.
```bash
$ cd jitterbug-items
$ nano core.properties
```
   Paste the following into the editor (where the name property is the name of the core, and the username and password correspond to your local MySQL instance) and save. Repeat for each core:
```  
   #Written by CorePropertiesLocator  
   #Tue Feb 7 14:29:29 UTC 2017  
   name=jitterbug-items  
   config=solrconfig.xml  
   schema=managed-schema  
   dataDir=data  
   importDataSourceUrl=jdbc:mysql://localhost:3306/jitterbug  
   importDataSourceUser=username  
   importDataSourcePassword=password  
```
11. Start Solr. It might be helpful to run it in the foreground when developing, hence the -f flag.
```bash
$ $SOLR_HOME/bin/solr start -f
```
12. Create the new cores in Solr.
```bash
$ $SOLR_HOME/bin/solr create -c jitterbug-items
$ $SOLR_HOME/bin/solr create -c jitterbug-masters
$ $SOLR_HOME/bin/solr create -c jitterbug-transfers
```
13. Use the Solr web app to import data from MySQL to index each Jitterbug core. This will take about 25 minutes for all cores.
	1. Point your favorite web browser to http://localhost:8983/solr.
	2. Use the Solr "Core Selector" menu to select the jitterbug-items core.
	3. Click the Dataimport button under the Core Selector menu.
	4. Underneath the Execute button, check the Auto-Refresh Status checkbox.
	5. Click Execute.
	6. When jitterbug-items is finished indexing, repeat these steps for each core.

14. Add a crontab entry for the Jitterbug (Laravel) [scheduler](https://laravel.com/docs/5.2/scheduling). This job will run every minute and will create the activity stream when there have been new transactions.
```bash
$ crontab -e
```
   Paste the following into the editor (where $JITTERBUG_HOME is the absolute path to your Jitterbug repo) then save:
```  
   * * * * * php $JITTERBUG_HOME/artisan schedule:run >> /dev/null 2>&1  
```
15. Install Jitterbug dependencies.
```bash
$ cd $JITTERBUG_HOME
$ composer update #PHP dependencies
$ npm install 
```
16. Create a new application key.
```bash
$ php artisan key:generate
```

## Configuration
1. Copy ```$JITTERBUG_HOME/.env.example``` to ```$JITTERBUG_HOME/.env```.
2. Edit the DB_\* and ADLDAP_\* properties in ```$JITTERBUG_HOME/.env```. The DB_\* properties will be determined by you, the developer, based on your database configuration. The ADLDAP_\* properites you should get from a UNC sysadmin or another Jitterbug developer. The SOLR_\* properties will likely be the same as what is in the .env.example file.

## Asset Compilation
1. Run Gulp
```bash
$ cd $JITTERBUG_HOME
$ gulp watch
```

## Running
1. Start the local PHP web server.
```bash
$ cd $JITTERBUG_HOME
$ php artisan serve
```
   In your favorite web browser, go to http://localhost:8000/

