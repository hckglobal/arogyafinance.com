<?php

/*
|--------------------------------------------------------------------------
| Treatment Type Routes
|--------------------------------------------------------------------------
|
| Treatment Type routes are defined here
|
*/
Route::group(['prefix'=>'admin/treatment-type/','namespace'=>'Admin\TreatmentType','middleware'=>['auth']], function () {
	Route::get('all','TreatmentTypeController@index');
	Route::get('create','TreatmentTypeController@create');
	Route::post('create','TreatmentTypeController@store');
	Route::get('edit/{id}','TreatmentTypeController@edit');
	Route::post('edit/{id}','TreatmentTypeController@update');
	Route::get('delete/{id}','TreatmentTypeController@destroy');
});



