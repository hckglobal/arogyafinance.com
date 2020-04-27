<?php

/*
|--------------------------------------------------------------------------
| Eligibility Test Routes
|--------------------------------------------------------------------------
|
| Eligibility Test routes are defined here
|
*/
Route::group(['prefix'=>'apply/{type}','namespace'=>'Website\Application'], function () {
    Route::get('personal-details', 'PersonalDetailController@showPersonalDetails');
    Route::post('personal-details', 'PersonalDetailController@postPersonalDetails');
});
