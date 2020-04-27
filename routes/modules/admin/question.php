<?php

/*
|--------------------------------------------------------------------------
| Questions Routes
|--------------------------------------------------------------------------
|
| Questions routes are defined here
|
*/
Route::group(['prefix'=>'admin/question','namespace'=>'Admin\Question','middleware'=>['auth']], function () {
	Route::get('all','QuestionController@index');
	Route::get('create','QuestionController@create');
	Route::post('create','QuestionController@store');
	Route::get('edit/{id}','QuestionController@edit');
	Route::post('edit/{id}','QuestionController@update');
	Route::get('delete/{id}','QuestionController@destroy');
});
