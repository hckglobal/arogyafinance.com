<?php

/*
|--------------------------------------------------------------------------
| DMI Routes
|--------------------------------------------------------------------------
|
| DMI routes are defined here
|
*/
Route::group(['prefix'=>'api/v1','namespace'=>'Api\DMI'], 
	function () {
		Route::get('{company}/cases','PartnerController@index');
		Route::get('{company}/case/{id}','PartnerController@show');
		Route::get('credit-partner/dmi','PartnerController@index');  
		Route::post('credit-partner/dmi/{id}','PartnerController@dmiStatusUpdate');
	}
);


