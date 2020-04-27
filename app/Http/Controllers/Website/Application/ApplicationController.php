<?php

namespace App\Http\Controllers\Website\Application;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Application;
use App\Borrower;
use App\FamilyMember;
use Session;
use Redirect;
use App\Helpers\SMSProvider;
use App\Helpers\Alerts;
use Mail;
use App\Admin;
class ApplicationController extends Controller
{
    /**
     * Send Thank You message after successful submission of Test/Payment. 
     * @param  $id Application Id
     * @return View
     */
    public function thankYou($id)
    {   
        $application=Application::find($id);
        $borrower = $application->borrower;

        //send sms to borrower
        $this->sendSMSToBorrower($application);
        
        $message = $this->checkApplication($application);
        $next_url = '/';
        Session::forget('borrower_id');
        
        return view('website.pages.application.thank_you')
             ->with(['message'=>$message,'next_url'=>$next_url,'application'=>$application,'locale'=>'en']);    
    }

    /**
     * Redirect Page for Application Category 1.
     * @param  $id Application Id
     * @return View
     */
    public function redirectPage($id)
    {
        //category one message 
        $application = Application::find($id);

        //send sms to borrower
        $this->sendSMSToBorrower($application);
        
        $message = $this->checkApplication($application);        
        $next_url = '/';
        Session::forget('borrower_id');
        return view('website.pages.application.redirect-page')->with(['message'=>$message,'next_url'=>$next_url,'locale'=>'en']);
    }

    /**
     * Update Patient 
     * @param  $input 
     * @return Re-direct to dashbaord
     */
    public function updatePatient(Request $input)
    {

        // get family member

        $family_member = $input->get('family_member_id');
        if($family_member!='self') {
        $family = FamilyMember::find($family_member);
        // get first_name

        $first_name = $family->first_name;

        // get middle_name

        $middle_name = $family->middle_name;

        // get last_name

        $last_name = $family->last_name;

        $gender = $family->gender;

        $dob = $family->date_of_birth;

        // get application id

        $application_id = $family->application_id;

        } else {
            $borrower = Borrower::find($input->get('borrower_id'));
            $first_name = $borrower->first_name;
            $middle_name = $borrower->middle_name;
            $last_name = $borrower->last_name;
            $gender = $borrower->gender;
            $dob = $borrower->date_of_birth;
            $application_id = $borrower->application_id;
        }

        
        // find application

        $application = Application::find($application_id);

        if($input->get('estimated_cost') > $application->approved_loan_amount){
            Session::flash('danger','Estimated Cost is higher than Pre Approved Loan Amount');
            return Redirect::to('user/apply-for-loan');
        }
        else{
            // card id

        $arogya_card_id = $application->id;
        

        
        // create new application

        $application_new = $application->replicate();
        $application_new->hospital_name = $input->get('hospital_name_lac');
        $application_new->treatment_type = $input->get('treatment_type_lac');
        $application_new->estimated_cost = $input->get('estimated_cost');
        $application_new->approved_loan_amount = $input->get('estimated_cost');
        $application_new->requested_tenure = $input->get('requested_tenure');
        $application_new->type = "loan";
        $application_new->status='new';
        $application_new->arogya_card_id = $arogya_card_id;

        $application_new->save();
        $application_new->reference_code = $application_new->id . str_random(6);
        $application_new->save();
        // get application id

        $application_id = $application_new->id;

        // create borrower for new application

        $borrower = $application->borrower->replicate();

        // updating application_id

        $borrower->application_id = $application_id;
        $borrower->save();

        // create patient

        $patient = $application_new->patient()->create($input->all());
        $patient->first_name = $first_name;
        $patient->middle_name= $middle_name;
        $patient->last_name = $last_name;
        $patient->gender = $gender;
        $patient->mobile_number = $input->get('patient_mobile_number');
        $patient->date_of_birth =$dob;
        $patient->save();
        
        // create documents for new application
        foreach ($application->documents as $document) {
            $new_document = $document->replicate();
            // updating application_id
            $new_document->application_id = $application_new->id;
            $new_document->save();
        }

        foreach ($application->references as $reference) {
            $new_reference = $reference->replicate();
            // updating application_id
            $new_reference->application_id = $application_new->id;
            $new_reference->save();
        }

        //$this->sendOTP($application);

        Session::flash('success', true);
        //Session::flash('otp_verification',true);
        //Session::put('download_link', '/sanction-letter/loan-against-card/'.$borrower->id);
        return redirect('/user/dashboard');
        }   
    }

    /**
     * Send Sms to borrower
     * @param  App\Application $application 
     * @return 
     */
    public function sendSMSToBorrower($application) 
    {
        $borrower = $application->borrowers()->first();
        $phone_number = $borrower->mobile_number;
        $card_cat_1_sms = Alerts::WELCOMEMESSAGECAT1CARD($application);
        $loan_cat_1_sms = Alerts::WELCOMEMESSAGECAT1LOAN($application);
        $other_cat_sms = Alerts::WELCOMEMESSAGEALLOTHERCATEGORIES($application);
        $residence_type = explode(' ', $application->borrower->residence_type);
        if ($residence_type[0]=='Owned'|| $residence_type[0]=='Parental')
        {   
            if ($application->requireTest()=='No') {

                if ($application->type=='card') {
                    $message = $card_cat_1_sms;
                } else {
                    $message = $loan_cat_1_sms;
                }
                //send sms to FC & Credit Manager
                $this->sendSMSToFCAndCreditManager($application);
                //send sms to partner
                $this->sendSMSToPartner($application);

            } elseif ($application->requireTest()=='Yes' && $application->category()=='Two') {
                if($application->psychometricTest()->where('test_url','!=','')->count()>0) {
                    $test_result = $application->psychometricTest()->where('test_url','!=','')->latest()->first()->result;
                } else {
                    $test_result = 'Empty';
                }

                if ($test_result=='Accepted') {
                    if ($application->type=='card') {
                        $message = $card_cat_1_sms;
                    } else {
                        $message = $loan_cat_1_sms;
                    }
                    //send sms to FC & Credit Manager
                    $this->sendSMSToFCAndCreditManager($application);
                    //send sms to partner
                    $this->sendSMSToPartner($application);
                } else {
                    $message = $other_cat_sms;
                }
            } else {
                $message = $other_cat_sms;
            }
        } else {
            $message = $other_cat_sms;
        }

        SMSProvider::send($phone_number,$message);
    }

    /**
     * Send Sms to FC & Credit Manager
     * @param  App\Application $application 
     * @return 
     */
    public function sendSMSToFCAndCreditManager($application) 
    {
        $mobile_numbers = array();
        $fcs = $application->location->admins;
        foreach ($fcs as $fc) {
            array_push($mobile_numbers, $fc->mobile_number);
        }
        $credit_managers = Admin::whereHas('roles',function ($query) {
               $query->where('name','credit-manager');
            })->get();
        foreach ($credit_managers as $credit_manager) {
            array_push($mobile_numbers, $credit_manager->mobile_number);
        }
        
        foreach ($mobile_numbers as $mobile_number) {
            $message = Alerts::ApplicationNotificationToFCAndCM($application);
        
            SMSProvider::send($mobile_number,$message);
        }        
    }

    /**
     * Send Sms to Partner
     * @param  App\Application $application 
     * @return 
     */
    public function sendSMSToPartner($application) 
    {
        if(isset($application->partner_reference_code)){
            $partner_mobile_numbers = Admin::where('referrer_code',$application->partner_reference_code)->first()->mobile_number;
        
            $message = Alerts::ApplicationNotificationToPartner($application);
        
            SMSProvider::send($partner_mobile_numbers,$message);
        }        
    }


    public function message($application)
    {
        /*if($application->type=='card') {
            $message = "Congratulations, your Arogya Card with Pre-approved limit of ₹. ".$application->calculated_loan_amount." is Approved. A formal Sanction Letter will be sent after verifying the documents.";
        } else {
            $message = "Congratulations, your loan for ₹. ".$application->calculated_loan_amount." is Approved. A formal Sanction Letter will be sent after verifying the documents uploaded.";
        }*/
        return $message = "Congratulations! Arogya ".ucfirst($application->type)." application of ".ucfirst($application->borrower->first_name)." ".ucfirst($application->borrower->last_name)." for ₹ ".$application->calculated_loan_amount." is Approved, in principle. Our Finance Counsellor will call you for a personal discussion and a formal binding Sanction Letter will follow. You may login using reference code ".strtoupper($application->reference_code).".";
    }

    public function checkApplication($application)
    {
        $message = "Thank you for applying, our Finance Counselor will get in touch with you shortly. Kindly use '".$application->reference_code."' code for all further communication & to complete your application.";

        $residence_type = explode(' ', $application->borrower->residence_type);
        
        if($residence_type[0]=='Owned'|| $residence_type[0]=='Parental')
        {
            if ($application->requireTest()=='No') {
                $message = $this->message($application);
            } elseif ($application->requireTest()=='Yes' && $application->category()=='Two') {
                if($application->psychometricTest()->where('test_url','!=','')->count()>0) {
                    $test_result = $application->psychometricTest()->where('test_url','!=','')->latest()->first()->result;
                } else {
                    $test_result = 'Empty';
                }
                if($test_result=='Accepted') {
                    $message = $this->message($application);
                }    
            }
            else {
            $message = $message;
            }
        } else {
            $message = $message;
        }
        return $message;
    }

    public function sendEmail($application)
    {
        /*$message = "";
        $residence_type = explode(' ', $application->borrower->residence_type);
        Mail::send('emails.website.email_to_borrower', 
            ['residence_type'=>$residence_type,'application'=>$application], 
            function ($mail) use ($application) {
                $mail->to($application->borrower->email, 'Arogya Finance')
                     ->subject('Arogya Finance');
            }
        );*/
    }

    public function applicationExist()
    {
        $id = Session::get('id');
        $application = Application::find($id);
        $message = "You have an existing ".$application->type." application with us, kindly use your reference code to login to your dashboard.";
        $next_url = "/login";
        return view('website.pages.application.application_exist')
             ->with(['message'=>$message,'next_url'=>$next_url,'id'=>$id,'locale'=>'en']);
    }

    public function requestCallback()
    {
        $id = Session::get('id');
        $application = Application::find($id);
        if($application->pin_number!='') {
            $pin_number = $application->pin_number." - ";
        } else {
            $pin_number = "";
        }

        Mail::send('emails.website.application_exist', ['application'=>$application], 
            function ($mail) use ($application, $pin_number) {
                $mail->to('info@arogyafinance.com', 'Arogya Finance')
                     ->subject($pin_number.'Requesting a call back');
            }
        );
        Session::forget('id');
        Session::flash('info','Request sent successfully');
        return redirect('/');
    }
}
