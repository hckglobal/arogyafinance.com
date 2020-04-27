<?php

/*
|--------------------------------------------------------------------------
| Repayment Cheque Routes
|--------------------------------------------------------------------------
|
| Repayment Cheque routes are defined here
|
*/
Route::group(['prefix'=>'admin/application','namespace'=>'Admin\Application','middleware'=>['auth']], function () {
    Route::post('collection/import','CollectionController@importCollectionData');
    Route::post('collection/add','CollectionController@saveCollection');
    Route::get('collection-delete/{id}','CollectionController@deleteCollection');
    /*Route::post('collection/add-principal-adjustment','CollectionController@addPrincipalAdjustmentToCollection');*/
    Route::post('collection/edit/{id}','CollectionController@updateCollection');
    Route::get('collection/import-error',
    	'CollectionController@collectionImportError');
    Route::get('collection-mark-bounce/{id}','CollectionController@markBounce');
    Route::post('collection-mark-bounce/{id}','CollectionController@collectionBounce');
    Route::get('collection-view-bounce/{id}','CollectionController@viewCollectionBounce');
    Route::get('collection-bounce-delete/{id}','CollectionController@deleteBouncedCollection');
    Route::post('collection-add-bounce/{id}','CollectionController@addNoOfChequeBounce');
    Route::get('view-cheque-bounce-schedule/{id}','CollectionController@viewAllChequeBounce');

    Route::post('collection/add-closure-amount','CollectionController@saveClosureCollection');

});