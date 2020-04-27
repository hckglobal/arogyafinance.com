<?php

/*
|--------------------------------------------------------------------------
| Updates Routes
|--------------------------------------------------------------------------
|
| Updates routes are defined here
|
*/
Route::group(['prefix'=>'admin/application','namespace'=>'Admin\Application','middleware'=>['auth']], function () {

	Route::post('{type}/update/{id}','UpdateController@updateInternalDetails');
	Route::post('nominee','UpdateController@submitNominee');
	Route::get('switch-enable-pyschometric-test/{application_id}','UpdateController@switchEnablePsychometricTest');
	Route::post('save-reference/{application_id}','UpdateController@saveReference');
	Route::post('save-family-member/{application_id}','UpdateController@saveFamilyMember');
	Route::get('{id}/update/merchant','UpdateController@updateMerchantStatus');
	Route::get('import/file','UpdateController@importForm');
	Route::post('import','UpdateController@import');
	Route::get('update/validupto','UpdateController@updateValidUpto');
});