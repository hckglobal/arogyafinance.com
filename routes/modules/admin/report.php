<?php

/*
|--------------------------------------------------------------------------
| Report Routes
|--------------------------------------------------------------------------
|
| Report routes are defined here
|
*/
Route::group(['prefix'=>'admin/report','namespace'=>'Admin\Report','middleware'=>['auth']], function () {
	Route::get('pshycometric','ReportController@pshycometricResult');
	Route::get('email-exceptions','ReportController@getIncompleteApplications');
	Route::get('email-exceptions/export','ReportController@exportIncompleteApplications');
	Route::get('lead','ReportController@leadResult');
	Route::get('lead/export','ReportController@exportLead');
	Route::get('disbursed','ReportController@disbursedResult');
	Route::get('disbursed/export','ReportController@exportDisbursed');
	Route::get('{status}','ReportController@index');
	Route::get('{status}/export','ReportController@export');
	Route::get('pshycometric/export','ReportController@exportPshycometric');
	Route::get('download/enach','ReportController@exportENACH');
	Route::get('get/overdues','ReportController@generateOverDues');
	Route::get('get/collection-data','ReportController@generateCollectionReport');
	Route::get('todays/disbursement', 'ReportController@getTodaysDisbursementApplications');
	Route::get('master/filter-od','ReportController@viewOdReportFilter');
	Route::get('master/filter-od-data','ReportController@odReport');
	Route::get('master/filter-closure','ReportController@viewClosureReportFilter');
	Route::get('master/filter-closure-data','ReportController@closureReportData');
	Route::get('master/filter-data-dump','ReportController@viewDataDumpReportFilter');
	Route::get('master/filter-data-dump-data','ReportController@dataDumpReport');
	Route::get('master/filter-cibil-dump','ReportController@viewCibilDumpReportFilter');
	Route::get('master/filter-cibil-dump-data','ReportController@cibilDumpReport');
	Route::get('master/filter-cibil-log','ReportController@viewCibilLogReportFilter');
	Route::get('master/filter-cibil-log-data','ReportController@cibilLogReport');
	Route::get('master/filter-income-computation', 'ReportController@viewIncomeComputationFilter');
	Route::get('master/income-computation-data','ReportController@incomeComputationReport');
	Route::get('master/filter-application-status-log', 'ReportController@viewApplicationStatusFilter');
	Route::get('master/filter-application-status-log-data', 'ReportController@applicationStatusReport');
	Route::get('master/filter-approval-log', 'ReportController@viewApprovalLogFilter');
	Route::get('master/filter-approval-log-data', 'ReportController@approvalLogReport');
	Route::get('download/closure-data','ReportController@closureReport');
	Route::get('master/filter-penalty', 'ReportController@viewPenaltyFilter');
	Route::get('master/filter-penalty-data', 'ReportController@penaltyReport');
});
