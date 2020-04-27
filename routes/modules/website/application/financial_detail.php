<?php

/*
|--------------------------------------------------------------------------
| Eligibility Test Routes
|--------------------------------------------------------------------------
|
| Eligibility Test routes are defined here
|
*/
Route::group(['prefix'=>'apply/{type}/','namespace'=>'Website\Application','middleware'=>['verifyApplication']], 
	function () {
    Route::get('financial-details/{id}', 'FinancialDetailController@showFinancialDetails');
    Route::post('financial-details/{id}', 'FinancialDetailController@postFinancialDetails');
});