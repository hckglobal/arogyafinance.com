<?php

/*
|--------------------------------------------------------------------------
| Cibil Routes
|--------------------------------------------------------------------------
|
| Cibil routes are defined here
|
*/
Route::group(['prefix'=>'api','namespace'=>'Api'], 
	function () {
		Route::post('generate-cibil-report','CibilController@generateReport');
		Route::get('test','CibilController@generateReport');
	}
);
