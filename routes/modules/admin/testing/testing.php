<?php

/*
|--------------------------------------------------------------------------
| Testing Routes
|--------------------------------------------------------------------------
|
| Testing routes are defined here
|
*/
Route::group(['prefix'=>'testing','namespace'=>'Admin\Testing','middleware'=>['auth']], function () {
	
	Route::get('application/analysis/{id}','BackendController@applicationAnalysis');
	Route::get('non-pdc','BackendController@nonPDC');
	Route::get('mis','BackendController@exportMis');
	Route::get('disbursed-case-data','BackendController@exportDisbursedCaseData');
	Route::get('disbursed-case-cibil','BackendController@exportDisbursedCaseCIBIL');
	Route::get('disbursed-data','BackendController@exportDisbursedData');
	Route::get('disbursed-cases','BackendController@exportDisbursedCases');
	Route::get('dmi-tranch','BackendController@exportDMITranch');
	Route::get('disbursed-data-may','BackendController@exportDisbursedDataForMay');
	Route::get('export-applications','BackendController@exportAllApplications');
	Route::get('export-borrowers','BackendController@exportAllBorrowers');
	Route::get('export-patients','BackendController@exportAllPatients');
	Route::get('export-familymembers','BackendController@exportAllFamilyMember');
	Route::get('export-healthfin','BackendController@getHealthFinapplications');
	Route::get('update-psychometric-test','BackendController@updatePsychometricTest');
	Route::get('import-applications','BackendController@importApplicationsForm');
	Route::post('import-applications','BackendController@importApplications');
	Route::get('check-disbursed-duplication','BackendController@checkDisbursedDuplication');
	Route::get('reject-applications','BackendController@rejectApplications');
	Route::get('delete/applications','BackendController@deleteApplications');
	Route::get('trim/pin','BackendController@trimPIN');
	Route::get('remove/pin','BackendController@removePIN');
	Route::get('duplicates','BackendController@checkDuplicateApplications');
	Route::get('send/welcome-letter','BackendController@sendWelcomeLetter');	
	Route::get('generate/reference-code','BackendController@generateReferenceCode');
	Route::get('update/lac-reference-code','BackendController@updateLACReferenceCode');
	Route::get('generate-ideal-rep-report','BackendController@generateIdealRepaymentReport');
});

