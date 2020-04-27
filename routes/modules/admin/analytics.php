<?php

/*
|--------------------------------------------------------------------------
| Analytics Routes
|--------------------------------------------------------------------------
|
| Analytics routes are defined here
|
*/
Route::group(['prefix'=>'admin/analytics','namespace'=>'Admin\Analytics','middleware'=>['auth']], function () {
	Route::get('summary','AnalyticsController@summary');
	Route::get('summary/filter','AnalyticsController@summaryFilter');
	Route::get('summary/export','AnalyticsController@summaryExport');
	Route::get('mis/summary','AnalyticsController@misSummary');
	Route::get('mis/summary/filter','AnalyticsController@misSummaryFilter');
	Route::get('mis/summary/export','AnalyticsController@misSummaryExport');

	// Route::get('summary/filter/application','AnalyticsController@summaryFilter');
	// Route::get('applications','AnalyticsController@getApplications');
	// Route::get('applications/filter','AnalyticsController@filter');
	// Route::get('applications/filter/{status}','AnalyticsController@filterByStatus');

	// Route::get('card/applications','AnalyticsController@getCardApplications');
	// Route::get('card/applications/filter','AnalyticsController@filterCard');
	// Route::get('card/applications/filter/{status}','AnalyticsController@filterByStatusCard');
	//Route::get('applications/filtered/{status}/filter','AnalyticsController@filteredStatus');
	//Route::get('applications/filter/{status}','AnalyticsController@filteredStatus');
	/*Route::get('index','AnalyticsController@allApplications');
	Route::get('{year}','AnalyticsController@yearly');
	Route::get('{year}/{status}','AnalyticsController@monthly');
	Route::get('{month_year}/location/{status}','AnalyticsController@location');
	Route::get('{month}/{location}/{status}/index','AnalyticsController@index');*/
	
});