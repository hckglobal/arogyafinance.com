<?php

/*
|--------------------------------------------------------------------------
| Login Routes
|--------------------------------------------------------------------------
|
| Login routes are defined here
|
*/
Route::group(['prefix'=>'api/mobile','namespace'=>'Mobile'], function () {
	Route::post('login','LoginController@login');
});