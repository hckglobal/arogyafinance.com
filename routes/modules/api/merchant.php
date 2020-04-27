<?php

/*
|--------------------------------------------------------------------------
| Merchant API Routes
|--------------------------------------------------------------------------
|
| Merchant API routes are defined here
|
*/
Route::group(['prefix'=>'api/v1','namespace'=>'Api\Merchant'], 
	function () {
		Route::post('merchant/application/create','MerchantController@storeApplication');
		Route::post('merchant/application/update/{reference_code}',
					'MerchantController@updateApplication');
		Route::get('merchant/application/get/{reference_code}','MerchantController@getApplicationDetail');
		Route::get('merchant/applications/{partner_reference_code}','MerchantController@getMerchantApplicationsDetail');
		Route::get('merchant/applications/query/{partner_reference_code}','MerchantController@getMerchantQueryApplicationsDetail');
		Route::post('merchant/hospital/create','MerchantController@storeHospital');
		Route::get('merchant/hospitals/{hospital_referrer}','MerchantController@getMerchantseHospital');
	}
);
