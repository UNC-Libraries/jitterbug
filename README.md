# Jitterbug
A Laravel / MySQL database management application to support large-scale description, digitization, preservation and access of archival audiovisual recordings in the Wilson Special Collections Library of UNC-Chapel Hill. Funded by an Andrew W. Mellon Foundation grant, "Extending the Reach of Southern Audiovisual Sources."


## Initial setup
1. Get a fresh Jitterbug MySQL production database dump (`$jitterbug-db-dump` refers to the name of this file) from a UNC library sysadmin.
2. Because the dump will contain views, you will need to remove the SQL security definers in the dump file. Using sed (on Mac OS X):
```bash
$ sed -i '' 's/DEFINER=[^*]*\*/\*/g' $jitterbug-db-dump
```
---
## Vagrant Installation
If you would like to use a pre-configured Vagrant box, Laravel Homestead is available for use.

### Installation steps
1. Clone the jitterbug repository.
```bash
$ git clone https://github.com/UNC-Libraries/jitterbug.git
```
2. `$jitterbug-home` is the directory where you've cloned the jitterbug project. Navigate to it.
```bash
$ cd $jitterbug-home
```
3. Install composer by following directions at https://getcomposer.org/download/

4. Create a .env file and copy the contents of .env.example into it.
```bash
$ cp .env.example .env
```

   * Set the `ADMIN_USER_PASSWORD` in your `.env` file to the password you'd like to use for your dev admin user

5. Use Composer to update packages and install Homestead.
```bash
$ php composer.phar install
$ php vendor/bin/homestead make
```
6. Install Vagrant Host Updater plugin.
```bash
$ vagrant plugin install vagrant-hostsupdater
```
7. Start the Vagrant box.
```bash
$ vagrant up
```
8. When that finishes, go to http://homestead.test and see if the jitterbug login page loads.

### Populating the DB and Solr cores
1. Import the MySQL dump into your jitterbug DB.
```bash
$ vagrant ssh
$ mysql -u homestead jitterbug < $jitterbug-db-dump -psecret
```
2. Use the Solr web app to import data from MySQL to index each Jitterbug core. This will take about 25 minutes for all cores.
	1. Point your favorite web browser to http://homestead.test:8983/solr
	2. Use the Solr "Core Selector" menu to select the jitterbug-items core.
	3. Click the Dataimport button under the Core Selector menu.
	4. Underneath the Execute button, check the Auto-Refresh Status checkbox.
	5. Click Execute.
	6. When jitterbug-items is finished indexing, repeat these steps for each core.

### Seeding the DB with the non-LDAP admin user
1. To log in with the non-LDAP admin dev user, you'll need to seed the DB. Inside the vagrant machine:
```bash
$ cd /vagrant
$ php artisan db:seed --class=UsersTableSeeder
```
2. Try to log into Jitterbug with the username `dev-admin`
 and the admin user password you set in your `.env` file.
 ---
## Local Installation

### Requirements For Local Installation
* [MySQL](https://dev.mysql.com/downloads/mysql/) >= 5.1 (developed using the [Homebrew](http://brew.sh/) version, 5.7.10)
* [MySQL Connector/J](https://dev.mysql.com/downloads/connector/j/) (JDBC driver for MySQL, needed for initial Solr indexing)
* PHP 5.6 (developed using the Homebrew version, 5.6.20)
* [Composer](https://getcomposer.org/)
	* Add composer to your path in .bashrc (export PATH=$PATH:/usr/local/bin/composer:~/.composer/vendor/bin)
* [npm](https://www.npmjs.com/) (developed using 2.15.1)
* [Solr 6.0](http://archive.apache.org/dist/lucene/solr/6.0.0/) (developed using 6.0)
* [Java 8](http://www.oracle.com/technetwork/java/javase/downloads/index.html) (for Solr)

If you are not a member of the Jitterbug LDAP group, submit a ticket and request access. You must be a member of the group in order to log into Jitterbug.

### Local Installation Steps
1. Create an empty MySQL database locally.
```bash
$ mysql -u username -p
mysql> create database jitterbug
```

2. Import the MySQL dump.
```bash
$ mysql -u username jitterbug < $jitterbug-db-dump -p
```

3. Clone the repo to your local machine ($JITTERBUG_HOME).
```bash
$ git clone git@github.com:UNC-Libraries/jitterbug.git jitterbug
```

4. If you have not already, unzip the MySQL Connector/J archive, then copy the jar file (mysql-connector-java-5.1.38-bin.jar) into $SOLR_HOME/contrib/dataimporthandler-extras/lib

5. Create the Solr core directories.
```bash
$ cd $SOLR_HOME/server/solr
$ mkdir jitterbug-items
$ mkdir jitterbug-masters
$ mkdir jitterbug-transfers
```

6. Symlink core conf directories to those in the git repo.
```bash
$ ln -s $JITTERBUG_HOME/solrconfig/jitterbug-items/conf jitterbug-items/conf
$ ln -s $JITTERBUG_HOME/solrconfig/jitterbug-masters/conf jitterbug-masters/conf
$ ln -s $JITTERBUG_HOME/solrconfig/jitterbug-transfers/conf jitterbug-transfers/conf
```

7. Create a core.properties file in each core directory.
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

8. Start Solr. It might be helpful to run it in the foreground when developing, hence the -f flag.
```bash
$ $SOLR_HOME/bin/solr start -f
```

9. Create the new cores in Solr.
```bash
$ $SOLR_HOME/bin/solr create -c jitterbug-items
$ $SOLR_HOME/bin/solr create -c jitterbug-masters
$ $SOLR_HOME/bin/solr create -c jitterbug-transfers
```

10. Use the Solr web app to import data from MySQL to index each Jitterbug core. This will take about 25 minutes for all cores. The import configuration (including the SQL Solr will use for querying MySQL) for each core can be found in the respective conf directory, in the solr-data-config.xml file.
	1. Point your favorite web browser to http://localhost:8983/solr.
	2. Use the Solr "Core Selector" menu to select the jitterbug-items core.
	3. Click the Dataimport button under the Core Selector menu.
	4. Underneath the Execute button, check the Auto-Refresh Status checkbox.
	5. Click Execute.
	6. When jitterbug-items is finished indexing, repeat these steps for each core.

11. Add a crontab entry for the Jitterbug (Laravel) [scheduler](https://laravel.com/docs/5.2/scheduling). This job will run every minute and will create the activity stream when there have been new transactions.
```bash
$ crontab -e
```
   Paste the following into the crontab editor (vi) (where $JITTERBUG_HOME is the absolute path to your Jitterbug repo) then save:
```bash
   * * * * * php $JITTERBUG_HOME/artisan schedule:run >> /dev/null 2>&1  
```

12. Install Jitterbug dependencies.
```bash
$ cd $JITTERBUG_HOME
$ composer update #PHP dependencies
$ npm install
```

13. Create a new application key.
```bash
$ php artisan key:generate
```

### Configuration
1. Copy ```$JITTERBUG_HOME/.env.example``` to ```$JITTERBUG_HOME/.env```.
2. Edit the DB_\* and ADLDAP_\* properties in ```$JITTERBUG_HOME/.env```. The DB_\* properties will be determined by you, the developer, based on your database configuration. The ADLDAP_\* properites you should get from a UNC sysadmin or another Jitterbug developer. Specifically, you will need the credentials for the LDAP admin user, and the LDAP group search string to put in the limitation filter after the = sign. The SOLR_\* properties will likely be the same as what is in the .env.example file.

### Asset Compilation
1. Run Gulp

```bash
$ cd $JITTERBUG_HOME
$ gulp
$ gulp watch
```

### Running
1. Start the local PHP web server.

```bash
$ cd $JITTERBUG_HOME
$ php artisan serve
```
   In your favorite web browser, go to http://localhost:8000/

---

## Revisionable
A key feature of Jitterbug is how it maintains a detailed paper trail of all changes to the four object types (items, masters, cuts, and transfers). Jitterbug leverages [a fork](https://gitlab.lib.unc.edu/cappdev/revisionable) of a 3rd party package for Laravel, called Revisionable, that hooks into the lifecycle of Eloquent models to maintain revision histories. Revisionable preserves the fields that are modified, what their old value was, and what their new value is. Revisionable writes to a single table, “revisions” which implements [Laravel poloymorphic relations](https://laravel.com/docs/5.2/eloquent-relationships#polymorphic-relations). By merely adding a single trait (RevisionableTrait) to your model class, revision histories can be tracked and will be saved to the revisions table.

Forking Revisionable was necessary to add several important features needed for Jitterbug. Using Revisionable out of the box, there is no way to determine which revisions happened in the same atomic database transaction, critical information for retrospective analyses of revision histories, such as those performed by the code that generates the Dashboard activity stream. The revision timestamp cannot be used as a unique identifier because long running transactions will be made up of revisions with different timestamps. To implement this feature, a ['transaction_id' field was added](https://gitlab.lib.unc.edu/cappdev/revisionable/commit/753a3e959205375ba51933f92f3bd0afd738a0b4) to the revisions table, and code was added to persist the transaction id when creating, updating, or deleting models. The transaction id itself is a UUID4 generated key that is passed down from application code to Revisionable via a database connection variable. Look in any of the controller classes and you will see this code just after the beginning of a transaction block: `DB::statement("set @transaction_id = '$transactionId';");`. That code is Jitterbug setting the connection variable which is picked up by Revisionable when revisions are saved.

In addition to the transaction_id mechanics, several other small features were added to Revisionable. An IP address field was added to track user locations. Support for soft deleted foreign keys was added (used when displaying revision histories). And storing the fully qualified namespace of models was changed to storing only the base class name.

## Recent Activity
The Recenty Activity module in the Dashboard uses transactional information in the revisions table to generate a representation of recent activity in the system. A simple cron job, which runs every minute, is used to generate the activity stream when new revisionable transactions have occurred. You can run this job yourself on demand by navigating to the root of your Jitterbug repository and running ```php artisan schedule:run```, which is precisely what the cron job does every minute. This command instructs Laravel to run any pending jobs defined in the ```schedule()``` method of [```Jitterbug\Console\Kernel```](https://github.com/UNC-Libraries/jitterbug/blob/master/app/Console/Kernel.php). More information about Laravel task scheduling can be found in the [documentation](https://laravel.com/docs/5.2/scheduling).

The scheduled job in turn calls ```Junebug\Presenters\ActivityStream->generate()``` which generates the stream if new transactions have occurred. The ActivityStream class instantiates ```Junebug\Presenters\TransactionDigest``` classes to summarize the revisions in the transaction and create individual ```Junebug\Models\Activity``` instances for display in the Dashboard.

Although Jitterbug relies almost exclusively on revision records to determine what action took place during a transaction, Jitterbug does look at another table, import_transactions, to determine what kind of import the transaction relates to, if it is an import. The records in this table are created when an import transaction begins. Some import types proved impossible to distinguish from batch creates, so an import_transactions table was added to record at the time of import what kind of import it was and the related transaction id.

## Adding an Items, Masters, or Transfers Field
1. Determine what object type the field is related to (audio visual items, preservation masters, or transfers).
2. Determine if the field is specific to a certain media type (i.e. audio only) or if it is common to all media types for the object type.
3. Create a migration to add the field to the appropriate database table. For example, if the field is common to all types of audio visual items, the field would go on the audio_visual_items table. If the field is specific to film items only, it would go on the film_items table. Do not name the column with a trailing ‘_id’ unless it’s actually a foreign key.
5. Run the migration.
6. Add the field to the show page corresponding to the object type (items, masters, or transfers). Ask the project director in what order it should be placed (before or after a certain field).
7. Add the field to the form partial corresponding to the object and media type (e.g. _form-audio.blade.php).
8. Add validation rules and messages to the form request class corresponding to the object type.
9. In the model that corresponds to the object and media type (e.g. AudioTransfer, or just Transfer if the field is common to all transfer types) add an appropriate element to the $revisionFormattedFields array. This array is used by the ‘revisionable’ package to determine how to format field values in revision histories. For more information on the syntax, see [https://github.com/VentureCraft/revisionable](https://github.com/VentureCraft/revisionable).
10. If the field name contains multiple words, in the model that corresponds to the object and media type (e.g. AudioTransfer, or just Transfer if the field is common to all transfer types) add an appropriate element to the $revisionFormattedFieldNames array. This array is used by the ‘revisionable’ package to determine how to render the field name in revision histories.
11. In the model that corresponds to the object and media type (e.g. AudioTransfer, or just Transfer if the field is common to all transfer types) add an element to the $fillable array so that Laravel can mass assign field values to the field.
12. Add the field to the Export class corresponding to the object type so the field will be made available in the user interface for exporting to .csv format.

## Adding a New Suggested Form Field
Jitterbug uses the [devbridge autocomplete plugin](https://github.com/devbridge/jQuery-Autocomplete) for jQuery to implement suggested form field values. In order to add a new suggested form field value, do the following:

1. Define a controller method in the SuggestionsController class for the field using plural naming conventions. You only need to copy and paste one of the exsiting methods and change the parameters for the ```getAutocompleteSuggestions()``` method call to correspond to the model you want the suggestions for, and then the field name.
2. Add a route to routes.php in the 'suggestions' group that references the controller method that was defined in step 1.
3. Go to the form where you want the suggestions to appear, and give the input element a css id name. e.g. #speed, or #recording-location, etc.
4. In app.js, add a jQuery selector using the id you created in step 3, then call autocomplete. The serviceUrl should correspond to the route you created in step 2. For example:

```javascript
$('#speed').autocomplete({
  serviceUrl: '/suggestions/speeds',
  deferRequestBy: 100
});
```

   


