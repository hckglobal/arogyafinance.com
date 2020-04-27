<?php

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
|
| Auth routes are defined here
|
*/
Route::group(['prefix'=>'','namespace'=>'Auth'],function () {
	
	/*===================================
	=            Auth Routes            =
	===================================*/

	Route::get('admin/login','AuthController@getLogin');
	Route::post('admin/login','AuthController@postLogin');
	Route::get('admin/logout','AuthController@getLogout');
	// Password reset link request routes...
	Route::get('password/email', 'PasswordController@getEmail');
	Route::post('password/email', 'PasswordController@postEmail');

	// Password reset routes...
	Route::get('password/reset/{token}', 'PasswordController@getReset');
	Route::post('password/reset', 'PasswordController@postReset');
	/*=====  End of Auth Routes  ======*/

});


