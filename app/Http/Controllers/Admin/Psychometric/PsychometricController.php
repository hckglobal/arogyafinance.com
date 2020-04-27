<?php

namespace App\Http\Controllers\Admin\Psychometric;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;
use Redirect;
use App\User;
use App\Application;
use App\Helpers\SMSProvider;
use App\Helpers\Alerts;


class PsychometricController extends Controller
{


    /**
     * show page new Psychometric
     *
     * @return view
     */
    public function createNewPsychometric() {
      $title = 'Create Reference Code';
      return view ('admin.pages.new-psychomertic-test')->with(['title'=>$title]);
    }
    

    /**
     * create psychometric test
     *
     * @return \Illuminate\Http\Response
     */
    public function storeNewPsychometric(Request $input) {
      //create application
      $application = Application::create($input->all());
      //refrence hode
      $application->reference_code= $application->id.str_random(6);
      //save reference code
      $application->save();
      //create borrower
      $borrower = $application->borrowers()->create($input->all());
      //set borrower as primary borrower
      $borrower->type ='primary';  

      $borrower->save();

      Session::flash('reference_code',$application->reference_code);


      //send sms
      SMSProvider::send($borrower->mobile_number,"Dear ".$borrower->first_name.". Your Reference Code is ".$application->reference_code.".");
      //return to create page
      return redirect('/admin/new-psychometric-test/create');
    }}
