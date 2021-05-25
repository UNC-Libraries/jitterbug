<?php

Route::get('/', function () {
    return redirect()->route('dashboard.index');
});

/*
|--------------------------------------------------------------------------
| Alerts
|--------------------------------------------------------------------------
*/

Route::get('alerts', 'AlertsController@index');
Route::delete('alerts', 'AlertsController@destroy');

/*
|--------------------------------------------------------------------------
| Suggestions
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'suggestions'], function () {
  Route::get('recording-locations',
  	'SuggestionsController@recordingLocations');
  Route::get('speeds', 'SuggestionsController@speeds');
  Route::get('track-configurations', 
    'SuggestionsController@trackConfigurations');
  Route::get('audio-bases', 'SuggestionsController@audioBases');
  Route::get('film-elements', 'SuggestionsController@filmElements');
  Route::get('film-bases', 'SuggestionsController@filmBases');
});

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/

Route::get('admin', 'Admin\AdminController@index')->name('admin.index');
Route::post('admin/make-admin', 'Admin\AdminController@makeAdmin');
Route::post('admin/remove-admin', 'Admin\AdminController@removeAdmin');
Route::get('users', 'Admin\UsersController@index');
Route::resource('collections', 
  'Admin\CollectionsController', ['except' => ['show', 'create', 'edit']]);
Route::resource('formats', 
  'Admin\FormatsController', ['except' => ['create', 'edit']]);
Route::resource('projects', 
  'Admin\ProjectsController', ['except' => ['show', 'create', 'edit']]);
Route::resource('vendors', 
  'Admin\VendorsController', ['except' => ['show', 'create', 'edit']]);
Route::resource('departments', 
  'Admin\DepartmentsController', ['except' => ['show', 'create', 'edit']]);
Route::resource('playback-machines', 
  'Admin\PlaybackMachinesController', ['except' => ['show', 'create', 'edit']]);
Route::resource('reproduction-machines', 
  'Admin\ReproductionMachinesController', ['except' => ['show', 'create', 'edit']]);
Route::resource('sampling-rates', 
  'Admin\SamplingRatesController', ['except' => ['show', 'create', 'edit']]);
Route::resource('pm-speeds', 
  'Admin\PmSpeedsController', ['except' => ['show', 'create', 'edit']]);
Route::resource('tape-brands', 
  'Admin\TapeBrandsController', ['except' => ['show', 'create', 'edit']]);
Route::resource('collection-types',
  'Admin\CollectionTypesController', ['except' => ['show', 'create', 'edit']]);
Route::resource('prefixes',
  'Admin\PrefixesController', ['except' => ['show', 'create', 'edit']]);
Route::post('prefixes/set-legacy-status', 'Admin\PrefixesController@setLegacyStatus');
Route::post('prefixes/remove-legacy-status', 'Admin\PrefixesController@removeLegacyStatus');
Route::post('formats/detach_prefixes', 'Admin\FormatsController@detachPrefixes');
Route::post('formats/attach_prefixes', 'Admin\FormatsController@attachPrefixes');
Route::post('users/inactivate', 'Admin\UsersController@inactivate');
Route::post('users/reactivate', 'Admin\UsersController@reactivate');

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('dashboard', 'DashboardController@index')->name('dashboard.index');
Route::get('dashboard/marks-for-user', 'DashboardController@marksForUser');

/*
|--------------------------------------------------------------------------
| Marks
|--------------------------------------------------------------------------
*/

Route::post('marks', 'MarksController@store')->name('marks.store');
Route::delete('marks', 'MarksController@destroy')->name('marks.destroy');

/*
|--------------------------------------------------------------------------
| Audio Visual Items
|--------------------------------------------------------------------------
*/

Route::get('call-numbers/generate', 'CallNumbersController@generate');
Route::get('call-numbers/for-pm', 'CallNumbersController@forPreservationInstance');
Route::get('items/resolve-range', 'ItemsController@resolveRange');
Route::match(['post', 'get'], 'items/batch/edit',
  'ItemsController@batchEdit')->name('items.batch.edit');
Route::put('items/batch',
  'ItemsController@batchUpdate')->name('items.batch.update');
Route::delete('items/batch', 
  'ItemsController@batchDestroy')->name('items.batch.destroy');
Route::post('items/batch/export-fields', 
  'ItemsController@batchExportFields')->name('items.batch.export.fields');
Route::post('items/batch/export-build', 
  'ItemsController@batchExportBuild')->name('items.batch.export.build');
Route::post('items/batch/export-download', 
  'ItemsController@batchExportDownload')->name('items.batch.export.download');
Route::post('items/batch/audio-import-upload', 
  'ItemsController@itemsImportUpload')->name('items.batch.items.import.upload');
Route::post('items/batch/audio-import-execute', 
  'ItemsController@itemsImportExecute')->name('items.batch.items.import.execute');
Route::resource('items', 'ItemsController');
Route::get('cuts/{id}', 'CutsController@get');

/*
|--------------------------------------------------------------------------
| Preservation Instances
|--------------------------------------------------------------------------
*/

Route::get('instance/resolve-range', 'InstancesController@resolveRange');
Route::match(['post', 'get'], 'instance/batch/edit',
  'InstancesController@batchEdit')->name('instances.batch.edit');
Route::put('instance/batch',
  'InstancesController@batchUpdate')->name('instances.batch.update');
Route::delete('instance/batch',
  'InstancesController@batchDestroy')->name('instances.batch.destroy');
Route::post('instance/batch/export-fields',
  'InstancesController@batchExportFields')->name('instances.batch.export.fields');
Route::post('instance/batch/export-build',
  'InstancesController@batchExportBuild')->name('instances.batch.export.build');
Route::post('instance/batch/export-download',
  'InstancesController@batchExportDownload')->name('instances.batch.export.download');
Route::resource('instances', 'InstancesController');
Route::resource('instance.cuts', 'CutsController', ['except' => ['index']]);

/*
|--------------------------------------------------------------------------
| Transfers
|--------------------------------------------------------------------------
*/

Route::get('transfers/resolve-range', 'TransfersController@resolveRange');
Route::match(['post', 'get'], 'transfers/batch/edit',
  'TransfersController@batchEdit')->name('transfers.batch.edit');
Route::put('transfers/batch',
  'TransfersController@batchUpdate')->name('transfers.batch.update');
Route::delete('transfers/batch', 
  'TransfersController@batchDestroy')->name('transfers.batch.destroy');
Route::post('transfers/batch/export-fields', 
  'TransfersController@batchExportFields')->name('transfers.batch.export.fields');
Route::post('transfers/batch/export-build', 
  'TransfersController@batchExportBuild')->name('transfers.batch.export.build');
Route::post('transfers/batch/export-download',
  'TransfersController@batchExportDownload')->name('transfers.batch.export.download'); 
Route::post('transfers/batch/audio-import-upload', 
	'TransfersController@audioImportUpload')->name('transfers.batch.audio.import.upload');
Route::post('transfers/batch/audio-import-execute', 
  'TransfersController@audioImportExecute')->name('transfers.batch.audio.import.execute');
Route::post('transfers/batch/video-import-upload', 
  'TransfersController@videoImportUpload')->name('transfers.batch.video.import.upload');
Route::post('transfers/batch/video-import-execute', 
  'TransfersController@videoImportExecute')->name('transfers.batch.video.import.execute');
Route::resource('transfers', 'TransfersController');

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::get('login', 'Auth\LoginController@showLoginForm')->name('loginForm');
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
