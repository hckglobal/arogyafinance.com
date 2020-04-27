<?php
Use App\Location;

/*
|--------------------------------------------------------------------------
| Location Routes
|--------------------------------------------------------------------------
|
| Location routes are defined here
|
*/
Route::group(['prefix'=>'api/mobile/location','namespace'=>'Mobile','middleware'=>['auth.api']], function (){
	Route::get('index','LocationController@index');	
});