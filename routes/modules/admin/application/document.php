<?php

/*
|--------------------------------------------------------------------------
| Documents Routes
|--------------------------------------------------------------------------
|
| Documents routes are defined here
|
*/
Route::group(['prefix'=>'admin/application','namespace'=>'Admin\Application','middleware'=>['auth']], function () {

	Route::post('{id}/upload/photo','DocumentController@uploadApplicationPhoto');
	Route::get('download-documents/{id}', 'DocumentController@downloadZip');
});

Route::group(['namespace'=>'Admin\Application','middleware'=>['auth']], function () {
Route::post('/documents/delete-documents','DocumentController@deleteDocuments');
});