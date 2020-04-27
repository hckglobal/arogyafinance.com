<?php

/*
|--------------------------------------------------------------------------
| DMI Routes
|--------------------------------------------------------------------------
|
| DMI routes are defined here
|
*/
Route::group(['prefix'=>'admin/application','namespace'=>'Admin\DMI','middleware'=>['auth']], 
	function () {
		Route::get('send-to-dmi/{id}','PartnerController@sendToDmi');
		Route::get('convert-to-lead/{id}','PartnerController@convertLead');
		Route::get('post-send-to-dmi/{id}','PartnerController@postSendToDmi');
		Route::get('dmi/{status}','PartnerController@getDmi');		
		
	}
);
Route::get('admin/partner/myapplication','Admin\DMI\PartnerController@myapplication');
Route::get('admin/application/send-bulk-pin','Admin\DMI\PartnerController@sendBulkPIN');
//send applications documents to dmi
Route::get('admin/send-dmi' , 'Admin\DMI\PartnerController@sendDmi');
