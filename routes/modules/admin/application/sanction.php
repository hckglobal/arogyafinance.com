<?php

/*
|--------------------------------------------------------------------------
| Sanction Letters  Routes
|--------------------------------------------------------------------------
|
| Sanction Letters  routes are defined here
|
*/
Route::group(['prefix'=>'sanction-letter','namespace'=>'Admin\Application',
	'middleware'=>['auth']], function () {

		Route::get('mantri/{id}', 'SanctionController@downloadMantri');
		Route::get('{id}', 'SanctionController@downloadSanctionLetter');
		Route::get('medtronic/{id}', 'SanctionController@downloadMedtronic');
		Route::get('mid/{id}','SanctionController@downloadMID');
		Route::get('dpn/{id}','SanctionController@downloadDPN');
		Route::get('loan-against-card/{id}','SanctionController@downloadLAC');
		Route::get('repayment-cheque/{id}','SanctionController@downloadRepaymentCheque');
		Route::get('ach/{id}','SanctionController@downloadACH');
		Route::get('first-letter/{id}','SanctionController@downloadFirstLetter');
			
});
