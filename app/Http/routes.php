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
  Route::get('track-configurations', 'SuggestionsController@trackConfigurations');
  Route::get('audio-bases', 'SuggestionsController@audioBases');
  Route::get('film-elements', 'SuggestionsController@filmElements');
  Route::get('film-bases', 'SuggestionsController@filmBases');
});

Route::get('items/batch/edit', [
    'as' => 'items.editBatch', 'uses' => 'ItemsController@editBatch'
]);

Route::put('items/batch', [
    'as' => 'items.updateBatch', 'uses' => 'ItemsController@updateBatch'
]);

Route::resource('items', 'ItemsController');

Route::resource('masters', 'MastersController');




// Display all SQL executed in Eloquent
// Event::listen('illuminate.query', function($query)
// {
//     var_dump($query);
// });