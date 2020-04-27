<?php

namespace App\Http\Controllers\Mobile\Application;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Application;
use App\Helpers\Api;
use App\Http\Controllers\Website\Application\FinancialDetailController;
use Input;
use App\Helpers\Alerts;
use App\Http\Controllers\Website\Application\ApplicationController;
use App\Helpers\SMSProvider;
use App\Http\Controllers\Website\Application\DocumentController;
use App\Http\Controllers\Website\Application\PersonalDetailController;
use App\Traits\SelfPsychometric;

class LeadController extends Controller
{
    use SelfPsychometric;
    /**
     * Fetch all leads from database.
     */
    public function index(Request $input)
    {
        dd($input->all());
        $leads = Application::where('type',$input->type)->where('status','lead')->get(['id','status']); 
        if($leads->count()>0) {
            return Api::success($leads);
        } else {
            return Api::error('No leads available.');
        }        
    }

    /**
     * Store a  lead into database.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $input)
    {
        //check for dedup application
        $dedup_controller = new PersonalDetailController();
        $existing_borrower = $dedup_controller->checkDedup($input);
        if($existing_borrower) {
            return Api::success("Application already exists.",['id'=>$existing_borrower->application_id,'type'=>$existing_borrower->application->type,'status'=>$existing_borrower->application->status]);
        } else {
            // step-1 : save application info
            $application = $this->saveApplicationInfo($input);        
            // step-2 : save borrower detail
            $borrower = $this->saveBorrowerInfo($application, $input);     

            // step-3 : save patient detail
            $patient = $this->savePatientInfo($application, $input);
            
            if ($application) {
                //return Api::success("Lead created");
                return Api::success("Lead created!",['id'=>$application->id,'type'=>$application->type,'status'=>$application->status]);
            } else {
                return Api::error("Failed to create Lead");
            }
        }
    }

    /**
     * Processes the application form input and saves in the database
     *  @param  Request $input
     * @param  string $type The type of application
     * @return App\Application
     */
    public function saveApplicationInfo($input)
    {
        $lead_application = Application::create($input->all());
        return $lead_application;
    }

    /**
     * Save Borrower Info
     * @param  $application
     * @param  $input       
     * @return App/Borrower
     */
    public function saveBorrowerInfo($application, $input)
    {
        $data['type'] = 'primary';
        $data['first_name'] = $input->borrower_first_name;
        $data['middle_name'] = $input->borrower_middle_name;
        $data['last_name'] = $input->borrower_last_name;
        $data['mobile_number'] = $input->borrower_mobile_number;
        /*$data['email'] = $input->borrower_email;*/
        $data['email'] = $input->email; //changed for temp basis
        $data['date_of_birth'] = $input->borrower_birthday_year;
        $data['date_of_birth'].= "-" . $input->borrower_birthday_month;
        $data['date_of_birth'].= "-" . $input->borrower_birthday_day;
        $data['id_proof_type'] = $input->id_proof_type;
        $data['id_proof_number'] = $input->id_proof_number;
        if($data['id_proof_type']=='PAN Card') {
            $data['pan_card_number']=$input->id_proof_number;
        }
        if($data['id_proof_type']=='Aadhaar Card') {
            $data['aadhar_card_number']=$input->id_proof_number;
        }
        $borrower = $application->borrowers()->create($data);
        $borrower->save();        
        return $borrower;
    }

    /**
     * Save Patient Info
     * @param  $application
     * @param  $input       
     * @return App/Patient
     */
    public function savePatientInfo($application, $input)
    {
        $patient = $application->patient()->create([]);
        return $patient;
    }

    /**
     * Update Info
     * @param  $id       
     * @return App/Patient
     */
    public function updateDetail($id, Request $input)
    {
        $application = Application::find($id);

        if ($application) {
            $this->updateApplicationInfo($application, $input);
            if ($application->type == "loan") {
                $patient = $this->updatePatientInfo($application, $input);
            }

            if ($application->type == "card") {
                $patient = $this->saveFamilyMembers($application, $input);
            }
            return Api::success("Lead Updated!",['id'=>$application->id,'type'=>$application->type,'status'=>$application->status]);
        } else {
            return Api::error("Failed to Update Detail");
        }
    }

    /**
     * Update Application Info
     * @param  $application
     * @param  $input       
     * @return App/Application
     */
    public function updateApplicationInfo($application, $input)
    {
        $application->update(Input::only(["hospital_name","estimated_cost","treatment_type","self_patient"]));
    }

    /**
     * Update Patient Info
     * @param  $application
     * @param  $input       
     * @return App/Patient
     */
    public function updatePatientInfo($application, $input)
    {
        if ($input->self_patient==1) {
            $data['first_name'] = $application->borrower->first_name;
            $data['middle_name'] = $application->borrower->middle_name;
            $data['last_name'] = $application->borrower->last_name;
            $data['gender'] = $application->borrower->gender;
            $data['mobile_number'] = $application->borrower->mobile_number;
            $data['date_of_birth'] = $application->borrower->date_of_birth;
            $data['marital_status'] = $application->borrower->marital_status;
            if($application->borrower->id_proof_type=='PAN Card') {
                $data['pan_card']=$application->borrower->id_proof_number;
            }
            if($application->borrower->id_proof_type=='Aadhaar Card') {
                $data['aadhar_card']=$application->borrower->id_proof_number;
            }
            $data['address_line_1'] = $application->borrower->address_line_1;
            $data['address_line_2'] = $application->borrower->address_line_2;
            $data['state'] = $application->borrower->state;
            $data['city'] = $application->borrower->city;
            $data['pincode'] = $application->borrower->pincode;
        } else {
            $data['first_name'] = $input->patient_first_name;
            $data['middle_name'] = $input->patient_middle_name;
            $data['last_name'] = $input->patient_last_name;
            $data['mobile_number'] = $input->patient_mobile_number;   
        }      
        
        $patient = $application->patient->update($data);
        return $patient;
    }

    /**
     * Update Family Members Info
     * @param  $application
     * @param  $input       
     * @return App/FamilyMember
     */
    public function saveFamilyMembers($application, $input)
    {
        if ($input->has('family_members')) {
            foreach($input->get('family_members') as $family) {
                if (array_key_exists('relation', $family)) {
                    $application->familyMembers()->create(
                        ['first_name' => $family['first_name'],
                         'last_name' => $family['last_name'],
                         'relation' => $family['relation'],
                         'gender' => $family['gender'],
                         'date_of_birth' => $family['date_of_birth']
                         ]);
                }
            }
        }
    }

    public function saveFinancialDetail($id, Request $input)
    {
        $application = Application::find($id);
        if ($application) {
            $application->update($input->all());
            $application->borrower()->update(Input::only(["current_loan_emi","education_expenses","house_rent"]));
            $finance_obj = new FinancialDetailController;
            // step-1 : update application
            $finance_obj->updateApplicationStatus($application);            
            // step-2 : update borrower information
            $finance_obj->updateBorrowerInfo($application,$input);
            // step-3 : save financial details into application
            $finance_obj->saveCalulations($application, $input);
            return Api::success("Financial Detail Updated!",['id'=>$application->id,'type'=>$application->type,'status'=>$application->status]);
        } else {
            return Api::error("Failed to Update Financial Detail");
        }
    }

    public function saveDocumentDetail($id, Request $input)
    {
        $application = Application::find($id);
        if($application) {
            $finance_obj = new DocumentController;
            $finance_obj->saveDocuments($application,$input);
            return Api::success("Documents Uploaded!",['id'=>$application->id,'type'=>$application->type,'status'=>$application->status]);       
        } else {
            return Api::error("Failed to Upload Documents");
        }
    }

    /**
     * check if borrower is applying for psychometric test or not.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function checkPsychometric($id, Request $input)
    {
        $application = Application::find($id);
        $result = $this->checkIfBorrowerIsApplyingForPsychometricTest($id, $input);
        if($result==true) {
            $link = '/api/mobile/lead/'.$id.'/check-test-eligibility';
            return Api::success("Can Apply Psychometric Test",['id'=>$id,'link'=>$link]);
        } else {
            $message = Alerts::WELCOMEMESSAGEWITHOUTPSYCHOMETRICTESTFC($application);
            return Api::success("Thank You!",['id'=>$id,'message'=>$message]);
        }
    }

    public function checkPsychometricEligibility($id)
    {
        $application = Application::find($id);
        if($application) {
            if($application->category()=="One" || $application->category()=="Two") {
                $psychometric_test = 0;
            } else {
                $psychometric_test = 1;
            }
            return Api::success("Psychometric Test Eligibility",['id'=>$application->id,'psychometric_test'=>$psychometric_test]);       
        } else {
            return Api::error("Application Doesn't exist");
        }
    }

    public function psychometricTestDetail($id)
    {
        $application = Application::find($id);
        if($application) {
            //check if the borrower is salaried 
            if (strpos(strtolower($application->borrower->nature_of_income), 'salaried') !== false){
                $test_id = 4;
            } else {
                $test_id = 5;
            }

            $link = "https://test.arogyafinance.com/arogya/candidate/create/".$test_id;
            $api_token = env('PSYCHOMETRIC_TEST_API_TOKEN');
            $username = $application->reference_code;            

            return Api::success("Psychometric Test Detail",['id'=>$application->id,'link'=>$link,'api_token'=>$api_token,'username'=>$username]);
        } else {
            return Api::error("Application Doesn't exist");
        }  
    }

    public function thankYou($id)
    {
        $application = Application::find($id);
        if ($application) {
            $application_obj = new ApplicationController;
            $application_obj->sendSMSToBorrower($application);
            $application_obj->sendSMSToFCAndCreditManager($application);
            $message = $application_obj->checkApplication($application);
            return Api::success("Thank You!",['id'=>$application->id,'message'=>$message]);
        } else {
            return Api::error("Application Doesn't exist");
        }
    }
}
