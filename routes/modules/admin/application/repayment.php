<?php

/*
|--------------------------------------------------------------------------
| Repayment Cheque Routes
|--------------------------------------------------------------------------
|
| Repayment Cheque routes are defined here
|
*/
Route::group(['prefix'=>'admin/application','namespace'=>'Admin\Application','middleware'=>['auth']], function () {

	Route::post('save-repayment-cheque/{application_id}','RepaymentController@saveRepaymentCheque');
    Route::get('delete-repayment-cheque/{id}','RepaymentController@deleteRepaymentCheque');
    Route::get('view-repayment-schedule/{id}','RepaymentController@getRepaymentSchedule');
    Route::get('view-repayment-collections/{id}','RepaymentController@repaymentCollections');
    Route::get('view-account-repayment-schedule/{id}','RepaymentController@getAccountRepaymentSchedule');
    Route::get('export/collections/{id}','RepaymentController@exportCollections');
    Route::get('generate/old-overdues','RepaymentController@generateOutstandingPrincipalReport');
    Route::get('export/loan-closure/{id}','RepaymentController@exportClosure');
});

Route::group(['namespace'=>'Admin\Application','middleware'=>['auth']], function () {

	Route::get('admin/applications/pdcs','RepaymentController@pdcSummary');
	Route::get('admin/applications/emi','RepaymentController@currentMonthEMI');
	Route::post('admin/applications/emi-export','RepaymentController@exportCurrentMonthEMI');

	Route::get('admin/import-repayment-collections','RepaymentController@importRepaymentCollectionsForm');
	Route::post('admin/import-repayment-collections','RepaymentController@importRepaymentCollections');

	Route::get('check/emis','RepaymentController@checkEMIS');
	Route::get('update-repayment-cheques-dates',
		'RepaymentController@updateRepaymentChequesDate');

	Route::post('admin/applications/emi/import/ach-data','RepaymentController@importACHData');

});