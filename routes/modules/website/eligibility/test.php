<?php

/*
|--------------------------------------------------------------------------
| Eligibility Test Routes
|--------------------------------------------------------------------------
|
| Eligibility Test routes are defined here
|
*/
Route::group(['prefix'=>'eligibility','namespace'=>'Website\Eligibility','middleware'=>['checkUserLogin']], 
	function () {
    Route::get('test/{locale}', 'EligibilityController@getTest');
    Route::post('test', 'EligibilityController@postTest');
    Route::post('screenshot/{id}', 'EligibilityController@screenshot');
    Route::get('select-language', 'EligibilityController@selectLanguage');
    Route::get('instruction/{locale}', 'EligibilityController@instruction');
    Route::get('self-psychometric/{id}', 'EligibilityController@checkSelfPsychometric');
    Route::post('self-psychometric/{id}', 'EligibilityController@checkPsychometric');
    Route::get('check-eligibility/{id}', 'EligibilityController@checkEligibility');
    Route::get('test-complete', 'EligibilityController@testComplete');

});
Route::get('eligibility/webcam-error', 'Website\Eligibility\EligibilityController@webcamError');
Route::get('eligibility/get-result/{user}', 'Website\Eligibility\EligibilityController@getResult');
//Route::get('update-result', 'Website\Eligibility\EligibilityController@getTestResultAPI');