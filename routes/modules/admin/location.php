<?php

/*
|--------------------------------------------------------------------------
| Location Routes
|--------------------------------------------------------------------------
|
| Location routes are defined here
|
*/

Route::group(['prefix'=>'admin/location','namespace'=>'Admin\Location','middleware'=>['auth']], function () {
	Route::get('all','LocationController@index');
	Route::get('create','LocationController@create');
	Route::post('create','LocationController@store');
	Route::get('edit/{id}','LocationController@edit');
	Route::post('edit/{id}','LocationController@update');
	Route::get('delete/{id}','LocationController@destroy');
});
/*=====  End of Location Routes ======*/
