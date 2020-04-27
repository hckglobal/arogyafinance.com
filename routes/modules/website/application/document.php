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
    Route::get('documents/{id}', 'DocumentController@showDocuments');
    Route::post('documents/{id}', 'DocumentController@postDocuments');
    Route::get('ask-documents-upload/{id}','DocumentController@askDocumentsUpload');
    Route::post('ask-documents-upload/{id}','DocumentController@submitApplicationWithoutDocs');
});
Route::post('update-document', 'Website\Application\DocumentController@update');