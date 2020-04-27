<?php

/*
|--------------------------------------------------------------------------
| Application Log Routes
|--------------------------------------------------------------------------
|
| Application Log routes are defined here
|
*/
Route::group(['prefix'=>'admin/application','namespace'=>'Admin\Application','middleware'=>['auth']], function () {

	Route::get('log/{id}','LogController@index');

});