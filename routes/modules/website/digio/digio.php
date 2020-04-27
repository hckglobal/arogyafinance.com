<?php

/*
|--------------------------------------------------------------------------
| Digio Routes
|--------------------------------------------------------------------------
|
| Digio routes are defined here
|
*/
Route::group(['prefix'=>'user','namespace'=>'Website\Digio','middleware'=>['checkUserLogin']],  function () {
	Route::get('request/mandate/{id}','DigioController@requestMandate');
	Route::get('request/esign/{id}','DigioController@requestESign');
	
	}
);
Route::get('admin/application/request/mandate/status/{id}','Website\Digio\DigioController@getMandateFormMetaData');