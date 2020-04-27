<?php

/*
|--------------------------------------------------------------------------
| Account Repayment Schedule Routes
|--------------------------------------------------------------------------
|
| Account Repayment Schedule routes are defined here
|
*/
Route::group(['prefix'=>'admin/application','namespace'=>'Admin\Application',
	'middleware'=>['auth']], function () {
    
    Route::post('add-principal-adjustment/{id}',
    	'AccountRepaymentController@addPrincipalAdjustment');
    Route::get('re-generate/account-repayment/{id}',
    	'AccountRepaymentController@regenerateAccountRepayment');
    Route::post('add-closure-charges/{id}',
    	'AccountRepaymentController@addLegalCharges');
    Route::get('closure-status/{id}',
	'AccountRepaymentController@getClosureStatus');

});