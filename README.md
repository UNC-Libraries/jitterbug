# Jitterbug
A Laravel / MySQL database management application to support large-scale description, digitization, preservation and access of archival audiovisual recordings in the Wilson Special Collections Library of UNC-Chapel Hill. Funded by an Andrew W. Mellon Foundation grant, "Extending the Reach of Southern Audiovisual Sources."

## Vagrant Installation
Local development uses a pre-configured Vagrant box, Laravel Homestead.

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
If you would prefer not to install the vagrant-hostupdater plugin, you can edit your `/etc/hosts` file yourself:
```bash
192.168.10.10   homestead.test
```
7. Start the Vagrant box.
```bash
$ vagrant up
```
8. When that finishes, go to http://homestead.test and see if the jitterbug login page loads.

#### Log in with the non-LDAP admin user
 Try to log into Jitterbug with the username `dev-admin` 
 and the admin user password you set in your `.env` file.
 ---
## Populating the DB and Solr cores (optional)
If you have data that you'd like to populate the DB with, export it as a SQL dump without views or 
create/drop statements.
1. Import the MySQL dump into your jitterbug DB. `$jitterbug-db-dump` is the path and 
filename of your dump file

In Vagrant VM:
```bash
$ vagrant ssh
$ mysql -u homestead jitterbug < $jitterbug-db-dump -psecret
```

2. Use the Solr web app to import data from MySQL to index each Jitterbug core. 
This will take about 25 minutes for all cores.
	1. Point your favorite web browser to http://homestead.test:8983/solr (vagrant) or 
	http://localhost:8983/solr (local)
	2. Use the Solr "Core Selector" menu to select the jitterbug-items core.
	3. Click the Dataimport button under the Core Selector menu.
	4. Underneath the Execute button, check the Auto-Refresh Status checkbox.
	5. Click Execute.
	6. When jitterbug-items is finished indexing, repeat these steps for each core.

---
## Revisionable
A key feature of Jitterbug is how it maintains a detailed paper trail of all changes to the 
four object types (items, masters, cuts, and transfers). Jitterbug leverages 
[a fork](https://github.com/UNC-Libraries/revisionable-1) of a 3rd party package for Laravel, 
called Revisionable, that hooks into the lifecycle of Eloquent models to maintain revision histories. 
Revisionable preserves the fields that are modified, what their old value was, and what their new 
value is. Revisionable writes to a single table, “revisions” which implements 
[Laravel poloymorphic relations](https://laravel.com/docs/5.2/eloquent-relationships#polymorphic-relations). 
By merely adding a single trait (RevisionableTrait) to your model class, revision histories can be 
tracked and will be saved to the revisions table.

Forking Revisionable was necessary to add several important features needed for Jitterbug. Using 
Revisionable out of the box, there is no way to determine which revisions happened in the same atomic 
database transaction, critical information for retrospective analyses of revision histories, such as those 
performed by the code that generates the Dashboard activity stream. The revision timestamp cannot be used as 
a unique identifier because long running transactions will be made up of revisions with different timestamps. 
To implement this feature, a ['transaction_id' field was added](https://github.com/UNC-Libraries/revisionable-1/commit/1fe065280c6911091d13e182004947a9b73fdc14) 
to the revisions table, and code was added to persist the transaction id when creating, updating, or deleting 
models. The transaction id itself is a UUID4 generated key that is passed down from application code to 
Revisionable via a database connection variable. Look in any of the controller classes and you will see 
this code just after the beginning of a transaction block: 
```DB::statement("set @transaction_id = '$transactionId';");```. That code is Jitterbug setting the connection 
variable which is picked up by Revisionable when revisions are saved.

In addition to the transaction_id mechanics, several other small features were added to Revisionable. 
An IP address field was added to track user locations. Support for soft deleted foreign keys was added 
(used when displaying revision histories). And storing the fully qualified namespace of models was changed 
to storing only the base class name.

## Recent Activity
The Recenty Activity module in the Dashboard uses transactional information in the revisions table to 
generate a representation of recent activity in the system. A simple cron job, which runs every minute, 
is used to generate the activity stream when new revisionable transactions have occurred. You can run 
this job yourself on demand by navigating to the root of your Jitterbug repository and running `php artisan schedule:run`, 
which is precisely what the cron job does every minute. This command instructs Laravel to run any pending 
jobs defined in the ```schedule()``` method of [```Jitterbug\Console\Kernel```](https://github.com/UNC-Libraries/jitterbug/blob/master/app/Console/Kernel.php). 
More information about Laravel task scheduling can be found in the [documentation](https://laravel.com/docs/5.2/scheduling).

The scheduled job in turn calls ```Junebug\Presenters\ActivityStream->generate()``` which generates the 
stream if new transactions have occurred. The ActivityStream class instantiates 
```Junebug\Presenters\TransactionDigest``` classes to summarize the revisions in the transaction and 
create individual ```Junebug\Models\Activity``` instances for display in the Dashboard.

Although Jitterbug relies almost exclusively on revision records to determine what action took place 
during a transaction, Jitterbug does look at another table, import_transactions, to determine what kind 
of import the transaction relates to, if it is an import. The records in this table are created when an 
import transaction begins. Some import types proved impossible to distinguish from batch creates, so an 
import_transactions table was added to record at the time of import what kind of import it was and the 
related transaction id.

## Adding an Items, Masters, or Transfers Field
1. Determine what object type the field is related to (audio visual items, preservation masters, or transfers).
2. Determine if the field is specific to a certain media type (i.e. audio only) or if it is common to all media types for the object type.
3. Create a migration to add the field to the appropriate database table. For example, if the field is common to all types of audio visual items, the field would go on the audio_visual_items table. If the field is specific to film items only, it would go on the film_items table. Do not name the column with a trailing ‘_id’ unless it’s actually a foreign key.
5. Run the migration.
6. Add the field to the show page corresponding to the object type (items, masters, or transfers). Ask the project director in what order it should be placed (before or after a certain field).
7. Add the field to the form partial corresponding to the object and media type (e.g. _form-audio.blade.php).
8. Add validation rules and messages to the form request class corresponding to the object type.
9. In the model that corresponds to the object and media type (e.g. AudioTransfer, or just Transfer if the field is common to all transfer types) add an appropriate element to the $revisionFormattedFields array. This array is used by the ‘revisionable’ package to determine how to format field values in revision histories. For more information on the syntax, see 
[https://github.com/VentureCraft/revisionable](https://github.com/VentureCraft/revisionable).
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

## Compiling Assets
Jitterbug uses [Laravel Mix](https://laravel.com/docs/8.x/mix) to compile its assets, including Sass for its css.
Add your css to `resources/assets/sass/app.scss` and then run `npm run dev` in the application terminal to compile the new changes.

For example, in the VM:
```bash
$ vagrant ssh
$ cd /vagrant
$ npm run dev
```

## Updating Homestead
1. Update the base box version specified in `Homestead.yaml.example`
2. Destroy the VM `vagrant destroy`
3. Delete `Homestead.yaml` and `Vagrantfile`
4. Use Composer to update packages and initialize Homestead.
   ```bash
   $ php composer.phar install
   $ php vendor/bin/homestead make
   ```
5. Update the Vagrantfile to use the Solr restart script

    After `aliasesPath = "aliases"`
    ```bash
    solrRestartScriptPath = "solr-restart.sh"
    ```
    After the customization script path part:
    ```bash
    if File.exist? customizationScriptPath then
      config.vm.provision "shell", path: customizationScriptPath, privileged: false, keep_color: true
    end
    
    if File.exist? solrRestartScriptPath then
      config.vm.provision "shell", path: solrRestartScriptPath, run: 'always', privileged: false, keep_color: true
    end
    ```
6. In your known_hosts file (on your host machine, not the VM) delete the entry for `192.168.10.10`
    ```bash
    $ cd ~/.ssh
    $ nano known_hosts
    ```
6. Navigate back to your Jitterbug repo folder and start the VM
    ```bash
    $ cd jitterbug
    $ vagrant up
    ```
7. Repopulate the DB and re-index Solr (instructions above).
   
## Running [Laravel Dusk](https://laravel.com/docs/8.x/dusk) tests (VM only)
1. Start up the vm and ssh into the VM
    ```bash
    vagrant up
    vagrant ssh
    ```
2. Navigate to the Jitterbug repo folder
    ```bash
    cd /vagrant
    ```
3. Run the Laravel Dusk tests
    ```bash
    php artisan dusk
    ```
4. Check screenshots folder when there's a failure in `tests/Browser/screenshots`

