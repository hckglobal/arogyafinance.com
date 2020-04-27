<?php

/*
|--------------------------------------------------------------------------
| Lead Routes
|--------------------------------------------------------------------------
|
| Lead routes are defined here
|
*/
Route::group(['prefix'=>'api/mobile/lead','namespace'=>'Mobile\Application','middleware'=>['auth.api']], function () {
	Route::get('index','LeadController@index');
	Route::post('create','LeadController@store');
	Route::post('{id}/update-details','LeadController@updateDetail');
	Route::post('{id}/financial-details','LeadController@saveFinancialDetail');
	Route::post('{id}/upload-documents','LeadController@saveDocumentDetail');
	Route::get('{id}/thank-you','LeadController@thankYou');
});