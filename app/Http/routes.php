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

Route::get('alerts', 'AlertsController@index');
Route::delete('alerts', 'AlertsController@destroy');

Route::get('call-numbers/generate', 'CallNumbersController@generate');

Route::group(['prefix' => 'suggestions'], function () {
  Route::get('recording-locations', 'SuggestionsController@recordingLocations');
  Route::get('speeds', 'SuggestionsController@speeds');
  Route::get('track-configurations', 'SuggestionsController@trackConfigurations');
  Route::get('audio-bases', 'SuggestionsController@audioBases');
  Route::get('film-elements', 'SuggestionsController@filmElements');
  Route::get('film-bases', 'SuggestionsController@filmBases');
});

Route::get('items/resolve-range', 'ItemsController@resolveRange');

Route::post('items/batch/edit', [
    'as' => 'items.editBatch', 'uses' => 'ItemsController@editBatch'
]);

Route::put('items/batch', [
    'as' => 'items.updateBatch', 'uses' => 'ItemsController@updateBatch'
]);

Route::resource('items', 'ItemsController');

Route::get('masters/resolve-range', 'MastersController@resolveRange');

Route::resource('masters', 'MastersController');
Route::resource('masters.cuts', 'CutsController', ['except' => ['index']]);


// Display all SQL executed in Eloquent
// Event::listen('illuminate.query', function($query)
// {
//     var_dump($query);
// });

// Authentication Routes...
Route::get('login', 'Auth\AuthController@showLoginForm')->name('loginForm');
Route::post('login', 'Auth\AuthController@login')->name('login');
Route::get('logout', 'Auth\AuthController@logout')->name('logout');

Route::get('/home', 'HomeController@index');
