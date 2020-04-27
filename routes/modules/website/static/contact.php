<?php

/*
|--------------------------------------------------------------------------
| Eligibility Test Routes
|--------------------------------------------------------------------------
|
| Eligibility Test routes are defined here
|
*/
Route::group(['prefix'=>'','namespace'=>'Website\StaticPage'], function () {
	Route::get('careers', 'ContactController@getCareers');
	Route::post('careers', 'ContactController@postCareers');
	Route::get('contact', 'ContactController@getContact');
	Route::post('contact', 'ContactController@postContact');
});