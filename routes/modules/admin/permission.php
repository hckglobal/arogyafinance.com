<?php

/*
|--------------------------------------------------------------------------
| Permission Routes
|--------------------------------------------------------------------------
|
| Permission routes are defined here
|
*/
Route::group(['prefix'=>'admin/manage-permission','namespace'=>'Admin\Permission','middleware'=>['auth']], 
	function () {
		Route::get('{id}', 'PermissionController@index');
		Route::post('{id}', 'PermissionController@update');
	}
);


