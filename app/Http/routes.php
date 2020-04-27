<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/




/**
 * This file: app/routes.php
 *
 * 1. Create a 'routes' folder under 'app/'.
 * 2. Create a route partial file for each
 *    route group; store in 'routes' folder.
 * 3. Add the partial file basename to the
 *    partial map.
 */

/** Route Partial Map
 ** ================================================= */

// ORDER MATTERS!
$route_partials = [
    //website Routes
    'website/payment/payment',
    'website/eligibility/test',
    'website/application/application',
    'website/application/personal_detail',
    'website/application/financial_detail',
    'website/application/document',
    'website/dashboard/dashboard',
    'website/dmi/dmi',
    'website/static/page',
    'website/static/contact',
    'website/enquiry/enquiry',
    'website/blog/blog',
    //Admin Routes
    
    'admin/admin',
    'admin/backend',
    'admin/dashboard',
    'admin/staff',
    'admin/location',
    'admin/question',
    'admin/hospital',
    'admin/psychometric',
    'admin/mis',
    'admin/treatment',
    'admin/permission',
    'admin/product',
    'admin/dmi',
    'admin/report',
    'admin/application/application',
    'admin/application/inline_edit',
    'admin/application/tat',
    'admin/application/document',    
    'admin/application/update',
    'admin/application/repayment',
    'admin/application/log',
    'admin/application/sanction',
    'admin/analytics',
    'admin/application/account_repayment',
    'admin/charges',
    'admin/blog',
    //API Routes
    'api/dmi',
    'api/api',
    'api/cibil',
    'api/merchant',
    
    // Auth Routes
    'admin/auth',

    //Backend Testing Routes
    'admin/testing/testing',
    //Import routes
    'admin/import',
    'admin/application/collection',
    //'website/digio/digio',
    'website/ingenico/ingenico',

    'mobile/application/lead',
    'mobile/application/borrower',
    'mobile/location',
    'mobile/hospital',
    'mobile/treatment_type',
    'mobile/hospital_director',
    'mobile/login',
    'mobile/application/psychometric_test',

   

];

/** Route Partial Loadup
 ** =================================================== */

foreach ($route_partials as $partial) {  
    $file = base_path().'/routes/modules/'.$partial.'.php';

    if ( ! file_exists($file)) {
        $msg = "Route partial [{$partial}] not found.";
        throw new \Illuminate\Filesystem\FileNotFoundException($msg);
    }

    require_once $file;
}

/*=====  End of Route Partial Loadup  ======*/

Route::get('/update-location',function(){
 
    $admins = App\Admin::all();

    foreach ($admins as $admin) {
            //locations
            $location = $admin->locations()->first();
   			//cities
            $cities = $admin->cities->pluck('name');
            //states
            $states = $admin->states->pluck('name');
            $ids = App\Borrower::whereIn('state',$states)->orWhereIn('city',$cities)->get()->pluck('application_id');
            //get primary borrower
            $applications = App\Application::whereIn('id', $ids)->get();

            foreach ($applications as $application) {

                if ( $location ) {
                    $application->location_id = $location->id; 
                    $application->save();
                }
            }
	}
});


Route::get('/reports/', function() {
    $bs= App\Borrower::all();
    $params = ['integrity','ability','risk','intention'];
    echo "<table>"; 
    echo "<style type='text/css'>
        .failed {
            background: red;
            color: #fff;
        }
        .passed {
            background: green;
            color: #fff;
        }

        </style>"; 
    echo "<tr> <th>Application Id</th> <th> Borrower Name </th> <th> Integrity Score (4.5) </th> <th> Ability Score (4.5) </th> <th> Risk Taking (5.5) </th> <th> Intention Score (5) </th> </tr>";
    
    foreach ($bs as $b) {

        if ($b->result('total')=='reject' && !$b->answers->isEmpty()) {
            echo "<tr>";
            echo "<td>".$b->application_id."</td>";
            echo "<td>".$b->first_name." ".$b->last_name."</td>";

            foreach ($params as $param) {
                $class = $b->result($param)=='reject'? 'failed' : 'passed';
            	echo "<td class='$class'>";
                echo $b->score($param);
            	echo "</td>";
            }

            echo "</tr>"; 	
        }
    }
    echo "</table>";
});

Route::get('/test', 'Admin\ApplicationController@downloadCibil');





Route::group(['prefix'=>'admin','middleware' =>['auth']],function(){




/*=============================================
=            Admin section           =
=============================================*/


Route::get('test-update','AdminController@testUpdate');
Route::get('sample-test', 'AdminController@testIndex');




Route::get('sanction/{id}', 'AdminController@sanctionForm');
Route::get('disburse/{id}', 'AdminController@disburseForm');
Route::get('validate/{id}' , 'AdminController@validateForm');
Route::post('form/update/{id}', 'AdminController@updateForm');
/*=====  End of Admin section ======*/


/*============================================
=            Pdf Generation Route            =
============================================*/
Route::get('application/pdfcard/{id}','AdminController@applicationPdfCard');
Route::get('application/pdfloan/{id}','AdminController@applicationPdfLoan');
/*=====  End of Pdf Generation Route  ======*/

});





/*==========================
=            Auth            =
============================*/

// // Authentication routes...
// Route::get('login', 'Auth\AuthController@getLogin');
// Route::post('login', 'Auth\AuthController@postLogin');
// Route::get('logout', 'Auth\AuthController@getLogout');

// // Registration routes...
// Route::get('register', 'Auth\AuthController@getRegister');
// Route::post('register', 'Auth\AuthController@postRegister');
/*=====  End of Auth  ======*/

Route::post('api/verify-otp','ApplicationController@verifyOTP');

?>
