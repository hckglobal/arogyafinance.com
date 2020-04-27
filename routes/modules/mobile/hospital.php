<?php
Use App\Hospital;

/*
|--------------------------------------------------------------------------
| Hospitals Routes
|--------------------------------------------------------------------------
|
| Hospitals routes are defined here
|
*/
Route::group(['prefix'=>'api/mobile/hospital','namespace'=>'Mobile','middleware'=>['auth.api']], function (){
	Route::get('index','HospitalController@index');
	//Route::post('create','HospitalController@store');	
});