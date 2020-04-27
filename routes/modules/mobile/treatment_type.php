<?php
Use App\TreatmentType;

/*
|--------------------------------------------------------------------------
| TreatmentType Routes
|--------------------------------------------------------------------------
|
| TreatmentType routes are defined here
|
*/
Route::group(['prefix'=>'api/mobile/treatment-type','namespace'=>'Mobile','middleware'=>['auth.api']], function (){
	Route::get('index','TreatmentTypeController@index');	
});