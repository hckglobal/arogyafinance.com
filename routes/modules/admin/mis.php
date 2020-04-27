<?php

/*
|--------------------------------------------------------------------------
| MIS Routes
|--------------------------------------------------------------------------
|
| MIS routes are defined here
|
*/
Route::group(['prefix'=>'admin/lead','namespace'=>'Admin\Mis','middleware'=>['auth']], function () {
	Route::get('create','LeadController@create');
	Route::post('create','LeadController@store');
	Route::get('edit/{id}','LeadController@edit');
	Route::post('edit/{id}','LeadController@update');
	Route::post('reject/{id}','LeadController@reject');
	Route::get('{type}','LeadController@newLeads');
	Route::post('import','LeadController@import');
});






