<?php

/*
|--------------------------------------------------------------------------
| Hospital Routes
|--------------------------------------------------------------------------
|
| Hospital routes are defined here
|
*/
Route::group(['prefix'=>'admin/hospital','namespace'=>'Admin\Hospital','middleware'=>['auth']], function () {
	Route::get('all','HospitalController@index');
	Route::get('create','HospitalController@create');
	Route::post('create','HospitalController@store');
	Route::get('edit/{id}','HospitalController@edit');
	Route::post('edit/{id}','HospitalController@update');
	Route::get('delete/{id}','HospitalController@destroy');
	Route::get('{id}','HospitalController@show');
	Route::get('import/{id}','HospitalController@addSubHospitals');
	Route::post('import/{id}','HospitalController@storeSubHospitals');
	Route::get('update/detail','HospitalController@updateHospitalDetailForm');
	Route::post('update/detail','HospitalController@updateHospitalDetail');
	Route::get('import/parent/hospitals','HospitalController@importHospitalsForm');
	Route::post('import/parent/hospitals','HospitalController@importHospitals');
});
