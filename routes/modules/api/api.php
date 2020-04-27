<?php
/*
|--------------------------------------------------------------------------
| DMI Routes
|--------------------------------------------------------------------------
|
| DMI routes are defined here
|
*/
Route::group(['prefix'=>'api/v1','namespace'=>'Api'], 
	function () {
		Route::get('applications','ApiController@index');
		/*Route::get('apply/{$type}','ApplicationController@postApplicationForm'); function name not found */
		Route::get('ucb/cases','ApiController@ucb');
		Route::get('ucb/case/{id}','ApiController@show');
		
	}
);

Route::get('applications/chart/yearly/{type}', 'Api\ApiController@getYearlyData');

