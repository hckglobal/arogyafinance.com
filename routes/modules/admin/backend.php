<?php

/*
|--------------------------------------------------------------------------
| Backend Routes
|--------------------------------------------------------------------------
|
| Backend routes are defined here
|
*/
Route::group(['namespace'=>'Admin\Testing','middleware'=>['auth']], function () {
	
	Route::get('/disbursedcase','BackendController@disbursedCase');
	Route::get('/reduplication','BackendController@reduplication');

});

