<?php

/*
|--------------------------------------------------------------------------
| Psychometric Test Routes
|--------------------------------------------------------------------------
|
| Psychometric Test routes are defined here
|
*/
Route::group(['prefix'=>'api/mobile/lead','namespace'=>'Mobile\Application','middleware'=>['auth.api']], function () {
	Route::post('{id}/check-psychometric','LeadController@checkPsychometric');
	Route::get('{id}/check-test-eligibility','LeadController@checkPsychometricEligibility');
	Route::get('{id}/get-psychometric-detail','LeadController@psychometricTestDetail');
});