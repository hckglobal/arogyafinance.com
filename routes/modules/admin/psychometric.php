<?php

/*
|--------------------------------------------------------------------------
| Psychometric Routes
|--------------------------------------------------------------------------
|
| Psychometric routes are defined here
|
*/
Route::group(['prefix'=>'admin/new-psychometric-test','namespace'=>'Admin\Psychometric','middleware'=>['auth']], function () {
	Route::get('create','PsychometricController@createNewPsychometric');
	Route::post('create','PsychometricController@storeNewPsychometric');
});

/*=====  End of New Psychometric Test  ======*/