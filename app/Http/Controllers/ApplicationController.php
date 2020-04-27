<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Input;
use App\Hospital;
use App\Patient;
use App\Borrower;
use App\Application;
use Helpers\CibilAPI;
use App\Helpers\SMSProvider;
use Session;
use App\Helpers\Alerts;
use App\Note;
use File;
use Mail;
use App\TreatmentType;
use App\Log;
use App\Location;
use App\FamilyMember;
use App\Lead;
use Redirect;
use Carbon\Carbon;
use PDF;

class ApplicationController extends Controller

{
    /**
     * Notify admins that new form has arrived.
     * @param Form $form
     */
    public function notifyAdmins($application)
    {
        foreach($application->admins() as $admin) {
            Mail::send('emails.admin.new-application', ['application' => $application],
            function ($mail) use($application)
            {
                $mail->to($admin->email, $admin->first_name . ' ' . $admin->last_name)->subject('New ' . $application->type . ' Application Recived From ' . $application->borrowe->city . ', ' . $application->borrower->state);
            });
        }
    }

    public function saveBorrowerInSession($borrower)
    {
        Session::put('borrower_id', $borrower->id);
    }
    
    public function test(Request $input)
    {
        $application = Application::find(1);

        // foreach ($applications as $application) {
        //    $application->save();
        // }
        // $this->saveFamilyMembers($application, $input);
        // return $application->admins();
        // $application->borrower->email = 'rahulwebtvurce@gmail.com';

        return $this->emailBorrower($application->borrower);

        // return view('partials.application.family_details');

    }

    

    

    


    

    

    /**
     * Send Sms to borrower
     * @param  App\Application $application 
     * @return 
     */
    public function sendSMSToBorrower($application) {
        $borrower = $application->borrowers()->first();
        $phone_number = $borrower->mobile_number;

        if($application->type == "loan") {
            if($application->category()=="One") {
                $message = Alerts::WELCOMEMESSAGECAT1LOAN($application);
            } else {
            $message = Alerts::WELCOMEMESSAGEALLCATEGORIESLOAN($application);
            }
            
        } else {
            if ($application->category()=="One") {
                $message = Alerts::WELCOMEMESSAGECAT1CARD($application);
            } else {
                $message = Alerts::WELCOMEMESSAGEFORALLCATEGORIESCARD($application);
            }
            
        }

         SMSProvider::send($phone_number,$message);
    }


    public function downloadSanctionLetter($id)
    {   
        $borrower = Borrower::find($id);
        $date = Carbon::now();
        $data = ['date'=>$date, 'borrower'=>$borrower];

        $pdf = PDF::loadView('pages.sanction_letters.sanction_letter_loan_against_card', $data)->setPaper('a4');
        
        return $pdf->download('loan.pdf');
            
    }


    public function sendOTP($application)
    {
      
      $mobile_number = $application->borrower->mobile_number;

      $otp = mt_rand(1000, 9999);
      
      SMSProvider::send($mobile_number,Alerts::SMSOTP($otp));

      Session::put('otp',$otp);

    }


    public function verifyOTP(Request $input)
    {
      if ($input->otp && Session::get('otp')) {

           return ["success"=>true,"link" => Session::get('download_link')];
           Session::forget('otp');
           Session::forget('download_link');
      } else {

          return ["success"=>false];
      }
      
    }

    
}