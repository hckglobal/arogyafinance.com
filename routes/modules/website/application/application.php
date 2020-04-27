<?php

/*
|--------------------------------------------------------------------------
| Eligibility Test Routes
|--------------------------------------------------------------------------
|
| Eligibility Test routes are defined here
|
*/
Route::group(['prefix'=>'','namespace'=>'Website\Application'], function () {
	Route::get('thank-you/{id}', 'ApplicationController@thankYou');
	Route::get('redirect-page/{id}','ApplicationController@redirectPage');
	Route::post('update-patient','ApplicationController@updatePatient');
	Route::get('application-exist','ApplicationController@applicationExist');
	Route::get('request-callback','ApplicationController@requestCallback');  
});