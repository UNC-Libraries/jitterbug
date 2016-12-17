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
Route::get('call-numbers/for-pm', 'CallNumbersController@forPreservationMaster');
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
Route::resource('items', 'ItemsController');
Route::get('cuts/{id}', 'CutsController@get');

/*
|--------------------------------------------------------------------------
| Preservation Masters
|--------------------------------------------------------------------------
*/

Route::get('masters/resolve-range', 'MastersController@resolveRange');
Route::match(['post', 'get'], 'masters/batch/edit',
  'MastersController@batchEdit')->name('masters.batch.edit');
Route::put('masters/batch',
  'MastersController@batchUpdate')->name('masters.batch.update');
Route::delete('masters/batch', 
  'MastersController@batchDestroy')->name('masters.batch.destroy');
Route::post('masters/batch/export-fields', 
  'MastersController@batchExportFields')->name('masters.batch.export.fields');
Route::post('masters/batch/export-build', 
  'MastersController@batchExportBuild')->name('masters.batch.export.build');
Route::post('masters/batch/export-download',
  'MastersController@batchExportDownload')->name('masters.batch.export.download'); 
Route::resource('masters', 'MastersController');
Route::resource('masters.cuts', 'CutsController', ['except' => ['index']]);

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
Route::post('transfers/audio-import-upload', 
	'TransfersController@audioImportUpload')->name('transfers.audio.import.upload');
Route::post('transfers/audio-import-execute', 
  'TransfersController@audioImportExecute')->name('transfers.audio.import.execute');
Route::post('transfers/video-import-upload', 
  'TransfersController@videoImportUpload')->name('transfers.video.import.upload');
Route::post('transfers/video-import-execute', 
  'TransfersController@videoImportExecute')->name('transfers.video.import.execute');
Route::resource('transfers', 'TransfersController');

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::get('login', 'Auth\AuthController@showLoginForm')->name('loginForm');
Route::post('login', 'Auth\AuthController@login')->name('login');
Route::get('logout', 'Auth\AuthController@logout')->name('logout');
