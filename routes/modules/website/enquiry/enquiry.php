<?php

/*
|--------------------------------------------------------------------------
| Enquiry Routes
|--------------------------------------------------------------------------
|
| Enquiry routes are defined here
|
*/
Route::group(['prefix'=>'','namespace'=>'Website\Enquiry'], function () {
	Route::post('/urgent-contact-mail', 'EnquiryController@enquiryMail');
});