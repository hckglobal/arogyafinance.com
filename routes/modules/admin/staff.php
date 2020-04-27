<?php

/*
|--------------------------------------------------------------------------
| Staff Routes
|--------------------------------------------------------------------------
|
| Staff routes are defined here
|
*/
Route::group(['prefix'=>'admin/staff','namespace'=>'Admin\Staff','middleware'=>['auth']], function () {
	Route::get('all', 'StaffController@index');
	Route::get('create', 'StaffController@create');
	Route::post('create', 'StaffController@store');
	Route::get('edit/{id}', 'StaffController@edit');
	Route::get('delete/{id}', 'StaffController@destroy');
	Route::post('update/{id}', 'StaffController@update');
	Route::post('update/password/{id}', 'StaffController@updatePassword');
	Route::get('change/{status}/{id}', 'StaffController@updateStatus');
	Route::get('activity-logs', 'StaffController@getAccountActivityLogs');
	// API for create form
});

Route::get('admin/staff/fetch/{entity}', 'Admin\Staff\StaffController@fetchEntity');
