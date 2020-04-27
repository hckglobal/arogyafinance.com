<?php

/*
|--------------------------------------------------------------------------
| Product Routes
|--------------------------------------------------------------------------
|
| Product routes are defined here
|
*/
Route::group(['prefix'=>'admin/product','namespace'=>'Admin\Product','middleware'=>['auth']], 
	function () {
		Route::get('all','ProductController@index');
		Route::get('create','ProductController@create');
		Route::post('create','ProductController@store');
		Route::get('edit/{id}','ProductController@edit');
		Route::post('edit/{id}','ProductController@update');
		Route::get('delete/{id}','ProductController@destroy');
	}
);


