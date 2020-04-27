<?php

/*
|--------------------------------------------------------------------------
| Ingenico Routes
|--------------------------------------------------------------------------
|
| Ingenico routes are defined here
|
*/
Route::group(['prefix'=>'user','namespace'=>'Website\Ingenico','middleware'=>['checkUserLogin']],  function () {

	Route::get('request/emandate/{id}','IngenicoController@requestMandate');
	
	Route::get('request/emandate-retry/{id}','IngenicoController@requestMandateAgain');

});

Route::post('user/process/emandate/{id}','Website\Ingenico\IngenicoController@checkMandateStatus');