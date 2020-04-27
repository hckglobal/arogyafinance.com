<?php

/*
|--------------------------------------------------------------------------
| Payment Routes
|--------------------------------------------------------------------------
|
| Paymentent routes are defined here
|
*/
Route::group(['prefix'=>'payment','namespace'=>'Website\Payment'], function () {
    Route::get('ask-for-payment/{id}', 'PaymentController@askForPayment');
    Route::get('user/{type}', 'PaymentController@makePayment');
    Route::any('user/successful', 'PaymentController@getSuccessPage');
    Route::any('user/failed', 'PaymentController@getFailurePage');
    Route::post('successful/{id}', 'PaymentController@getPaymentSuccessful');
    Route::post('failed/{id}', 'PaymentController@getPaymentFailed');
});
