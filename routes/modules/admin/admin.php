<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Admin routes are defined here
|
*/
Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=>['auth']], function () {
	
	Route::get('search','SearchController@search');

});

