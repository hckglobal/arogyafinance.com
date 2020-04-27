<?php
Use App\HospitalDirector;

/*
|--------------------------------------------------------------------------
| Hospital Director Routes
|--------------------------------------------------------------------------
|
| Hospital Director routes are defined here
|
*/
Route::group(['prefix'=>'api/mobile/hospital-director','namespace'=>'Mobile','middleware'=>['auth.api']], function (){
	Route::get('index','HospitalDirectorController@index');
	//Route::post('create','HospitalDirectorController@store');	
});