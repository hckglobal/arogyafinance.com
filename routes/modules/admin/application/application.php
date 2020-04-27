<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Application routes are defined here
|
*/
Route::group(['prefix'=>'admin/application','namespace'=>'Admin\Application',
			  'middleware'=>['auth','verifyApplicationAccess']], function () {

	Route::get('{type}/detail/{id}', 'ApplicationController@show');  	

});

Route::group(['prefix'=>'admin/application','namespace'=>'Admin\Application','middleware'=>['auth']], function () {

	Route::get('{type}/{category}/{status}/index', 'ApplicationController@index');
	Route::get('{type}/delete/{id}', 'ApplicationController@destroy');
	Route::post('{type}/create/notes', 'ApplicationController@storeNotes');
	Route::get('summary/{id}','ApplicationController@summaryApplication');
	Route::get('update/status/{status}/{id}','ApplicationController@updateApplicationStatus');
	Route::get('send-arogya-card/{id}','ApplicationController@sendArogyaCard');
	Route::get('download-arogya-card/{id}','ApplicationController@downloadArogyaCard');
	Route::get('test-result/{id}', 'ApplicationController@showResult');
	Route::get('full/download-pdf/{id}', 'ApplicationController@downloadApplication');
	/*Route::get('{type}/detail/{id}', 'ApplicationController@show');*/
	Route::get('close-application/{id}', 'ApplicationController@closeApplication');
	Route::get('send-ndc/{id}', 'ApplicationController@sendNoDueCertificate');
	Route::get('revert-stage/{id}', 'ApplicationController@revertApplicationStatus');
	Route::get('bulk-close','ApplicationController@closeApplicationsInBulkForm');
	Route::post('bulk-close','ApplicationController@closeApplicationsInBulk');
	Route::get('send-to-poonawalla/{id}', 'ApplicationController@sendApplicationToPoonawala');

});
