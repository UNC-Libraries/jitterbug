<?php

Route::get('/', function () {
    return redirect()->route('items.index');
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
| Audio Visual Items
|--------------------------------------------------------------------------
*/

Route::get('call-numbers/generate', 'CallNumbersController@generate');
Route::get('items/resolve-range', 'ItemsController@resolveRange');
Route::match(['post', 'get'], 'items/batch/edit',
  'ItemsController@batchEdit')->name('items.batch.edit');
Route::put('items/batch',
  'ItemsController@batchUpdate')->name('items.batch.update');
Route::delete('items/batch', 
  'ItemsController@batchDestroy')->name('items.batch.destroy');
Route::resource('items', 'ItemsController');

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
Route::resource('masters', 'MastersController');
Route::resource('masters.cuts', 'CutsController', ['except' => ['index']]);

/*
|--------------------------------------------------------------------------
| Transfers
|--------------------------------------------------------------------------
*/

Route::get('transfers/resolve-range', 'TransfersController@resolveRange');
Route::post('transfers/audio-import-upload', 
	'TransfersController@audioImportUpload')->name('transfers.audio.import.upload');
Route::post('transfers/audio-import-execute', 
  'TransfersController@audioImportExecute')->name('transfers.audio.import.execute');
Route::resource('transfers', 'TransfersController');

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::get('login', 'Auth\AuthController@showLoginForm')->name('loginForm');
Route::post('login', 'Auth\AuthController@login')->name('login');
Route::get('logout', 'Auth\AuthController@logout')->name('logout');

Route::get('/home', 'HomeController@index');
