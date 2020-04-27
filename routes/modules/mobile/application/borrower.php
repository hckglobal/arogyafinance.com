<?php

/*
|--------------------------------------------------------------------------
| Lead Routes
|--------------------------------------------------------------------------
|
| Lead routes are defined here
|
*/
Route::group(['prefix'=>'api/mobile/lead','namespace'=>'Mobile\Application','middleware'=>['auth.api']], function () {
	Route::post('{id}/borrower-details','BorrowerController@saveBorrowerDetail');
});