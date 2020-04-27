<?php

/*
|--------------------------------------------------------------------------
| Charges Routes
|--------------------------------------------------------------------------
|
| Charges routes are defined here
|
*/
Route::group(['prefix'=>'admin/manage-charges','namespace'=>'Admin\Charge','middleware'=>['auth']], 
	function () {
		Route::get('', 'ChargeController@index');
		Route::post('{id}', 'ChargeController@update');
	}
);


