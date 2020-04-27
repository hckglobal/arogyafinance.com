<?php

/*
|--------------------------------------------------------------------------
| Blog Routes
|--------------------------------------------------------------------------
|
| Blog routes are defined here
|
*/

Route::group(['prefix'=>'admin/blog','namespace'=>'Admin\Blog','middleware'=>['auth']], function () {
	Route::get('all','BlogController@index');
	Route::get('create','BlogController@create');
	Route::post('create','BlogController@store');
	Route::get('edit/{id}','BlogController@edit');
	Route::post('edit/{id}','BlogController@update');
	Route::get('delete/{id}','BlogController@destroy');
});
/*=====  End of Blog Routes ======*/
