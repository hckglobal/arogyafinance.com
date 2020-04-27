<?php

/*
|--------------------------------------------------------------------------
| Tat Routes
|--------------------------------------------------------------------------
|
| Tat routes are defined here
|
*/
Route::group(['prefix'=>'admin/application','namespace'=>'Admin\Application','middleware'=>['auth']], function () {

	Route::get('tat/{id}','TatController@index');
	Route::get('staff/statistics','TatController@statistics');
});