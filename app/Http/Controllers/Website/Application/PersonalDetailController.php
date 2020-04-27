<?php

namespace App\Http\Controllers\Website\Application;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Hospital;
use App\Application;
use Helpers\CibilAPI;
use Session;
use App\TreatmentType;
use App\Location;
use App\FamilyMember;
use App\Lead;
use Redirect;
use App\Borrower;


class PersonalDetailController extends Controller
{
    /**
     * Show form for personal details
     * @return
     */
    public function showPersonalDetails($type, Request $input)
    {   
        $locale = $this->checkLocal($input);
        app()->setLocale($locale);
        $lead = '';
        $lead_id=$input->get('lead_id');
        if ($input->has('lead_id')) {
            $lead = Lead::find($input->get('lead_id'));
        }

        //$hospitals = Hospital::all()->pluck('name');
        $hospitals = Hospital::all();
        $referrer_id = $input->get('referrer_id');
        $treatment_type = TreatmentType::all()->pluck('name');
        $locations = Location::all();

        return view('website.pages.application.personal_details')
                ->with(['type' => $type,'hospitals' => $hospitals,'referrer_id' => $referrer_id,
                        'lead' => $lead,'locations' => $locations,'treatment_type' => $treatment_type,
                        'lead_id'=>$lead_id, 'locale'=>$locale
                      ]);
    }

    /**
     * [postPersonalDetails description]
     * @param  [string]  $type  [type of application(loan/card)]
     * @param  Request $input [input fields]
     * @return [redirect route]         [redirects to financial details page]
     */
    public function postPersonalDetails($type, Request $input)
    {
        $has_topup = Session::has('top_up');
        $locale = $this->checkLocal($input);
        app()->setLocale($locale);
        $lead = '';
        $lead_id=$input->get('lead_id');
        if ($input->has('lead_id')) {
            $lead = Lead::find($input->get('lead_id'));
        }
        if(!$has_topup){
            $existing_borrower = $this->checkDedup($input);
        } else {
            Session::forget('top_up');
        }
        
        $redirect_url="";
        
        if(isset($existing_borrower)) {
            $application = $existing_borrower->application;
            //check status of application
            if($application->status=="lead") {
                $redirect_url = "/apply/$application->type/financial-details/$application->id?locale=$locale";
                $this->setApplicationSession($application);
                return redirect($redirect_url);
            }
            if($application->status=="new" || $application->status=="verified" || $application->status=="sanctioned" || $application->status=="disbursed" || $application->status=="closed") {
                $title = "You already have an application, \r\n please log into dashboard using reference code";
                Session::put('id',$application->id);
                return redirect('application-exist');
            }
        } else {
            // step-1 : save application info
            $application = $this->saveApplicationInfo($input, $type);

            // step-2 : save patient form if type is loan save patient info
            if ($type == "loan") {
                $patient = $this->savePatientInfo($application, $input);
            }

            if ($type == "card") {
                $patient = $this->saveFamilyMembers($application, $input);
            }

            // step-3 : save borrower info
            $borrower = $this->saveBorrowerInfo($application, $input);

            // step-4 : if application is from lead update lead status
            $this->changeLeadStatus($input, $type);

            // step-5 : get the cibil score for the application
            $cibil_access = env('ENABLE_CIBIL');
            if($cibil_access){
                $this->getCibilScore($application,$input);
            }

            // step-6 : check if application is eligible for psychometric test.
            $this->updatePsychometricStatus($application);

            $id = $application->id;

            //check if lead is present
            if ($lead) {
                $redirect_url = "/apply/$type/financial-details/$id?lead_id=$lead->id&locale=$locale";
            } else {
                $redirect_url = "/apply/$type/financial-details/$id?locale=$locale";
            }

            $this->setApplicationSession($application);
            
            return redirect($redirect_url);
        }
    }

    /**
     * Processes the application form input and saves in the database
     *  @param  Request $input
     * @param  string $type The type of application
     * @return App\Application
     */
    public function saveApplicationInfo(Request $input, $type)
    {
        //dd($input->all());
        $application = Application::create($input->all());
        $application->type = $type;
        $application->status = "lead";
        $application->save();
        return $application;
    }

    /**
     * Save Patient info
     * @param  Request $input
     * @param  string $application 
     * @return App\Patient
     */
    public function savePatientInfo($application, Request $input)
    {
        $patient = $application->patient()->create($input->all());
        $patient->first_name = $input->get('patient_first_name');
        $patient->middle_name = $input->get('patient_middle_name');
        $patient->last_name = $input->get('patient_last_name');
        $patient->gender = $input->get('patient_gender');
        $patient->mobile_number = $input->get('patient_mobile_number');
        $patient->date_of_birth = $input->get('patient_birthday_year');
        $patient->date_of_birth.= "-" . $input->get('patient_birthday_month');
        $patient->date_of_birth.= "-" . $input->get('patient_birthday_day');
        $patient->address_line_1 = $input->get('patient_address_line_1');
        $patient->state = $input->get('patient_state');
        $patient->city = $input->get('patient_city');
        $patient->pincode = $input->get('patient_pincode');
        $patient->save();
        return $patient;
    }

    /**
     * saves family member info for Card applications
     * @param  Request $input
     * @param  Application $application
     * @return
     */
    public function saveFamilyMembers($application, Request $input)
    {
        if ($input->has('family_members')) {
            foreach($input->get('family_members') as $family) {
                if (array_key_exists('relation', $family)) {
                     
                    $dob = $family['dob_year'];
                    $dob.= "-" . $family['dob_month'];
                    $dob.= "-" . $family['dob_day'];

                    $application->familyMembers()->create(
                        ['first_name' => $family['first_name'],
                         'last_name' => $family['last_name'],
                         'relation' => $family['relation'],
                         'gender' => $family['gender'],
                         'date_of_birth' => $dob
                         ]);
                }
            }
        }
    }

    /**
     * Save Borrower Info
     * @param  $application
     * @param  Request $input       
     * @return App/Borrower
     */
    public function saveBorrowerInfo($application, Request $input)
    {
        $borrower = $application->borrowers()->create($input->all());
        if($input->has('self_patient')){
           
           //dd($input->get('patient_state'),$input->get('patient_city'));
            // set borrower as primary borrower

            $borrower->type = 'primary';
            $borrower->first_name = $input->get('patient_first_name');
            $borrower->middle_name = $input->get('patient_middle_name');
            $borrower->last_name = $input->get('patient_last_name');
            $borrower->gender = $input->get('patient_gender');
            $borrower->mobile_number = $input->get('patient_mobile_number');
            $borrower->date_of_birth = $input->get('patient_birthday_year');
            $borrower->date_of_birth.= "-" . $input->get('patient_birthday_month');
            $borrower->date_of_birth.= "-" . $input->get('patient_birthday_day');
            $borrower->address_line_1 = $input->get('patient_address_line_1');
            $borrower->state = $input->get('patient_state');
            $borrower->city = $input->get('patient_city');
            $borrower->pincode = $input->get('patient_pincode');
            $borrower->application->update(['self_patient'=>1]);
        }
        else{

            // set borrower as primary borrower
            //dd($input->get('borrower_state'),$input->get('borrower_city'));
            $borrower->type = 'primary';
            $borrower->first_name = $input->get('borrower_first_name');
            $borrower->middle_name = $input->get('borrower_middle_name');
            $borrower->last_name = $input->get('borrower_last_name');
            $borrower->gender = $input->get('borrower_gender');
            $borrower->mobile_number = $input->get('borrower_mobile_number');
            $borrower->date_of_birth = $input->get('borrower_birthday_year');
            $borrower->date_of_birth.= "-" . $input->get('borrower_birthday_month');
            $borrower->date_of_birth.= "-" . $input->get('borrower_birthday_day');
            $borrower->state = $input->get('borrower_state');
            $borrower->city = $input->get('borrower_city');
            $borrower->pincode= $input->get('borrower_pincode');
            $borrower->application->update(['self_patient'=>0]);
        }
        $borrower->relation_with_patient=$input->get('relation_with_patient');
        $borrower->save();

        return $borrower;
        
    }

    /**
     * Get CibilScore for the application
     * @param  $application 
     * @param  Request $input       
     * @return CibilScore
     */
    public function getCibilScore($application, Request $input)
    {
        $application->cibil_score = CibilAPI::getScore($input, $application->id);
        $application->save();
    }

    /**
     * Update Psychometric Status 
     * @param  $application 
     * @return 
     */
    public function updatePsychometricStatus($application)
    {  
        $status = 0;
        if($application->category()=="One" || $application->category()=="Two") {
            $status = 1;
        }
        $application->enable_psychometric_test = $status;
        $application->save();
        
    }

    /**
     * Set Application Session 
     * @param $application 
     */
    public function setApplicationSession($application)
    {
        $application_id = $application->id;
        Session::put('borrower_id',$application->borrower->id);
    }

    /*
    * change the lead status if the form is being filled from lead
    */
    public function changeLeadStatus($input, $type)
    {
        if ($input->has('lead_id')) {
            $id = $input->get('lead_id');
            $lead = Lead::find($id);
            $lead->status = "converted-to-" . $type;
            $lead->save();
        }
    }

    /**
     * [checkLocal check if regional language is present]
     * @param  [type] $input [description]
     * @return [type]        [description]
     */
    public function checkLocal($input)
    {
        if ($input->has('locale')) {
            $locale = $input->locale;
        } else {
            $locale = 'en';
        }

        return $locale;
    }

    /**
     * [checkDedup check if requested application data already exist.]
     * @param  [array] $input [payload data]
     * @param  [string] $type  [type of application loan / card]
     * @return [boolean]        [return true if application exist else false]
     */
    public function checkDedup($input)
    {
        if ($input->has('self_patient')) {
            $borrower_first_name = $input->get('patient_first_name');
            $borrower_last_name = $input->get('patient_last_name');
            $borrower_date_of_birth = $input->get('patient_birthday_year');
            $borrower_date_of_birth.= "-" . $input->get('patient_birthday_month');
            $borrower_date_of_birth.= "-" . $input->get('patient_birthday_day');
        } else {
            $borrower_first_name = $input->get('borrower_first_name');
            $borrower_last_name = $input->get('borrower_last_name');
            $borrower_date_of_birth = $input->get('borrower_birthday_year');
            $borrower_date_of_birth.= "-" . $input->get('borrower_birthday_month');
            $borrower_date_of_birth.= "-" . $input->get('borrower_birthday_day');
        }
        $id_proof_number = $input->id_proof_number;
        
        switch ($input->id_proof_type) {
            case  "PAN Card" :
            $id_proof_type = 'pan_card_number';
            break;
            
            case  "Aadhaar Card" :
            $id_proof_type = 'aadhar_card_number';
            break;
            
            default:
            $id_proof_type = 'id_proof_number';
            break;
        }
        
        //dd($id_proof_type);
        //dd($borrower_first_name, $borrower_last_name, $borrower_date_of_birth, $id_proof_number);
        $borrower = Borrower::where('type','primary')
                    ->where(function ($query) use($borrower_first_name, $borrower_last_name, $borrower_date_of_birth) {
                        $query->where('first_name', 'like', '%'.$borrower_first_name.'%')
                            ->where('last_name', 'like', '%'.$borrower_last_name.'%')
                            ->where('date_of_birth', $borrower_date_of_birth);
                        }
                    )->orWhere(function($query) use($borrower_first_name, $id_proof_type, $id_proof_number) {
                        $query->where('first_name', 'like', '%'.$borrower_first_name.'%')
                            //->where('last_name', 'like', '%'.$borrower_last_name.'%')
                            //->where('date_of_birth', $borrower_date_of_birth)
                            ->where($id_proof_type, $id_proof_number);
                        }
                    )->orWhere(function($query) use($borrower_last_name, $id_proof_type, $id_proof_number) {
                        $query/*->where('first_name', 'like', '%'.$borrower_first_name.'%')*/
                            ->where('last_name', 'like', '%'.$borrower_last_name.'%')
                            //->where('date_of_birth', $borrower_date_of_birth)
                            ->where($id_proof_type, $id_proof_number);
                        }
                    )->orWhere(function($query) use($borrower_date_of_birth, $id_proof_type, $id_proof_number) {
                        $query/*->where('first_name', 'like', '%'.$borrower_first_name.'%')*/
                            //->where('last_name', 'like', '%'.$borrower_last_name.'%')
                            ->where('date_of_birth', $borrower_date_of_birth)
                            ->where($id_proof_type, $id_proof_number);
                        }
                    )->get()->first();
        return $borrower;
                    //dd($borrower);
        /*if(isset($borrower)){
            $application = $borrower->application;
            $id = $application->id;
            
            //check if status is lead
            if($application->status=="lead") {
                $redirect_url = "/apply/$application->type/financial-details/$id";
            }
            if($application->status=="new") {
                $redirect_url = "/login";
            }
            
            $this->setApplicationSession($application);
            
            return redirect($redirect_url);
            
            dd($application);
            return $borrower;
        }*/
    }
}
