<?php

/*
|--------------------------------------------------------------------------
| Report Routes
|--------------------------------------------------------------------------
|
| Report routes are defined here
|
*/
Route::group(['prefix'=>'admin/import','namespace'=>'Admin\Import','middleware'=>['auth']], function () {
	Route::get('/','ImportController@index');
});
