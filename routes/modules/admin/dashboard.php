<?php

/*
|--------------------------------------------------------------------------
| Admin Dashboard Routes
|--------------------------------------------------------------------------
|
| Admin Dashboard routes are defined here
|
*/
Route::group(['prefix'=>'admin','namespace'=>'Admin\Dashboard','middleware'=>['auth']], function () {
	
	Route::get('dashboard', 'DashboardController@show');
	Route::get('changelogs','DashboardController@changeLogs');
});


// dummy route for testing birthday card intervention image 
Route::get('/birthday-card', 'Admin\Dashboard\DashboardController@birthdayCard');



