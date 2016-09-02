<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

// Alerts

Route::get('alerts', 'AlertsController@index');
Route::delete('alerts', 'AlertsController@destroy');

// Suggestions

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

// Audio Visual Items

Route::get('call-numbers/generate', 'CallNumbersController@generate');
Route::get('items/resolve-range', 'ItemsController@resolveRange');
Route::post('items/batch/edit', [
    'as' => 'items.editBatch', 'uses' => 'ItemsController@editBatch'
]);
Route::put('items/batch', [
    'as' => 'items.updateBatch', 'uses' => 'ItemsController@updateBatch'
]);
Route::resource('items', 'ItemsController');

// Preservation Masters

Route::get('masters/resolve-range', 'MastersController@resolveRange');
Route::resource('masters', 'MastersController');
Route::resource('masters.cuts', 'CutsController', ['except' => ['index']]);

// Transfers

Route::get('transfers/resolve-range', 'TransfersController@resolveRange');
Route::post('transfers/audio-import-upload', 
	'TransfersController@audioImportUpload')->name('transfers.audio.import.upload');
Route::post('transfers/audio-import-execute', 
  'TransfersController@audioImportExecute')->name('transfers.audio.import.execute');
Route::resource('transfers', 'TransfersController');

// Authentication

Route::get('login', 'Auth\AuthController@showLoginForm')->name('loginForm');
Route::post('login', 'Auth\AuthController@login')->name('login');
Route::get('logout', 'Auth\AuthController@logout')->name('logout');

Route::get('/home', 'HomeController@index');
