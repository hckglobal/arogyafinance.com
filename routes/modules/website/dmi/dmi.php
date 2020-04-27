<?php

/*
|--------------------------------------------------------------------------
| Payment Routes
|--------------------------------------------------------------------------
|
| Paymentent routes are defined here
|
*/
Route::group(['prefix'=>'dmi','namespace'=>'Admin\DMI'], function () {
    Route::get('send-to-dmi/{id}','PartnerController@sendToDmi');
});
