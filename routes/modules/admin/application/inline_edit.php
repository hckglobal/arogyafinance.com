<?php

/*
|--------------------------------------------------------------------------
| InlineEdit Routes
|--------------------------------------------------------------------------
|
| InlineEdit routes are defined here
|
*/
Route::group(['prefix'=>'admin/application','namespace'=>'Admin\Application','middleware'=>['auth']], function () {

	Route::post('borrower/edit/{id}','InlineEditController@updateBorrower');
	Route::get('borrower-delete/{id}','InlineEditController@deleteBorrower');
	Route::post('family-details/edit/{id}','InlineEditController@updateFamily');
	Route::post('patient/edit/{id}','InlineEditController@updatePatient');
	Route::post('repayment-cheque/edit/{id}','InlineEditController@updateRepaymentCheque');
	Route::post('{id}/update/self-patient','UpdateController@updateSelfPatient');
});