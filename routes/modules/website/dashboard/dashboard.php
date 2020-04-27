<?php

/*
|--------------------------------------------------------------------------
| Test Routes
|--------------------------------------------------------------------------
|
| Test routes are defined here
|
*/
Route::group(['prefix'=>'user', 'namespace'=>'Website\Dashboard'], function () {
	Route::get('dashboard', 'DashboardController@userDashboard');
	Route::get('documents', 'DashboardController@userDocuments');
	Route::get('apply-for-loan', 'DashboardController@applyForLoan');
	Route::get('payment-status', 'DashboardController@userPaymentStatus');
	Route::get('apply-for-topup', 'DashboardController@chooseTopup');
	Route::get('apply-for-topup/{type}', 'DashboardController@applyForTopup');
	
});
Route::group(['prefix'=>'', 'namespace'=>'Website\Dashboard'], function () {
	Route::get('login', 'DashboardController@getLogin');
	Route::post('login', 'DashboardController@postLogin');
	Route::get('logout', 'DashboardController@logout');
	Route::get('dashboard', 'DashboardController@dashboard');
});

