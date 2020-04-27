<?php 

namespace App\Http\Controllers\Api\Merchant;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Application;
use App\Merchant;
use App\MerchantDocument;
use App\Http\Controllers\Website\Application\PersonalDetailController;
use App\Http\Controllers\Website\Application\FinancialDetailController;
use Helpers\CibilAPI;
use App\Borrower;
use App\Hospital;
use App\Admin;

class MerchantController extends Controller
{
    /**
     * [requetHasToken check if token is present in request]
     * @param  [type] $input [description]
     * @return [string]        [success/error]
     */
    public function requetHasToken($input)
    {
        if (!$input->has('api_token')) return ['error'=>'Authentication Failed'];
    }

    /**
     * [checkAPIToken check if token is present in database]
     * @param  [type] $input [description]
     * @return [string]        [success/error]
     */
    public function checkAPIToken($input)
    {
        $token = $input->api_token;
        $admin = Admin::where('merchant_api_token',$token)->first();
        if (isset($admin)) {
            return $admin;
        } else {
            return false;
        }        
    }

    /**
     * [storeApplication store the Ablepay data to our system]
     * @param  Request $input [get the input data from ablepay]
     * @return [array]         [return success / error message]
     */
    public function storeApplication(Request $input)
    {
        
        $check_token_exist = $this->requetHasToken($input);
        $check_api_token_exist = $this->checkAPIToken($input);
        if($check_api_token_exist) {
            $data = json_decode($input->getContent());
            
            $application = $data->application;
            
            $borrower = $data->borrower;
            $borrower_date_of_birth = $borrower->birthday_year;
            $borrower_date_of_birth.= "-" . $borrower->birthday_month;
            $borrower_date_of_birth.= "-" . $borrower->birthday_day;
            
            $patient = $data->patient;
            $patient_date_of_birth = $patient->birthday_year;
            $patient_date_of_birth.= "-" . $patient->birthday_month;
            $patient_date_of_birth.= "-" . $patient->birthday_day;
            
            $borrower_bank_detail = $data->borrower_bank_detail;
            $borrower_documents = $data->documents;

            // check CIBIL Dedup
            //create borrower_data for checking CIBIL dedup
            $cibil_dedup_data['borrower_first_name']=$borrower->first_name;
            $cibil_dedup_data['borrower_last_name']=$borrower->last_name;
            $cibil_dedup_data['borrower_date_of_birth']=$borrower_date_of_birth;
            $cibil_dedup_data['id_proof_number']=$borrower->id_proof_number;
            $personal_detail_object = new PersonalDetailController();
            $input_object = Request();
            $input_object->merge($cibil_dedup_data);
            //run Calculation for this application
            $existing_borrower = $personal_detail_object->checkDedup($input_object);
            
            if (isset($existing_borrower)) {
                return ['error'=>'Existing Application Found in System.'];
            } else {
                $application_data = Application::create([
                    'type' => "loan",
                    'estimated_cost' =>$application->estimated_cost,
                    'loan_required' =>$application->loan_required,
                    'requested_emi' => $application->requested_emi,
                    'requested_tenure' => $application->requested_tenure,
                    'hospital_name' => $application->hospital_name,
                    'treatment_type' => $application->treatment_type,
                    'interest_rate' => $application->interest_rate,
                    'status' => 'new',
                    'location_id'=>13,
                    'partner_reference_code'=> $application->partner_reference_code     
                   ]);
                
                //save borrower info
                $borrower = $application_data->borrower()->create([
                    'application_id' => $application_data->id,
                    'type' => 'primary',
                    'first_name' => $borrower->first_name,
                    'middle_name' => $borrower->middle_name,
                    'last_name' => $borrower->last_name,
                    'date_of_birth' => $borrower_date_of_birth,
                    'gender' => $borrower->gender,
                    'mobile_number' => $borrower->mobile_number,
                    'email' => $borrower->email,
                    'city' => $borrower->city,
                    'state' => $borrower->state,
                    'pincode' => $borrower->pincode,
                    'address_line_1' => $borrower->address_line_1,
                    'address_line_2' => $borrower->address_line_2,
                    'borrowers_income' => $borrower->borrowers_income,
                    'income_itr' => $borrower->income_itr,
                    'current_loan_emi' =>$borrower->current_loan_emi,
                    'education_expenses' =>$borrower->education_expenses,
                    'house_rent' => $borrower->house_rent,
                    'other_expenses' => $borrower->other_expenses,
                    'other_earnings' => $borrower->other_earnings,
                    'earning_since' => $borrower->earning_since,
                    'nature_of_income' => $borrower->nature_of_income,
                    'monthly_income' => $borrower->monthly_income,
                    'name_of_firm' => $borrower->name_of_firm,
                    'number_of_dependants' => $borrower->number_of_dependants,
                    'id_proof_type' => $borrower->id_proof_type,
                    'id_proof_number' => $borrower->id_proof_number,
                    'pan_card_number' => $borrower->pan_card_number,
                    'aadhar_card_number' => $borrower->aadhar_card_number,
                    'residence_type' => $borrower->residence_type
                    ]);
                // get personaldetail controller object to run getCibilScore()
                $cibil_object = new CibilAPI();
                //create cibil_data for obtaining the cibil score
                $cibil_data['borrower_birthday_year']=$data->borrower->birthday_year;
                $cibil_data['borrower_birthday_month']=$data->borrower->birthday_month;
                $cibil_data['borrower_birthday_day']=$data->borrower->birthday_day;
                $cibil_data['borrower_gender']=ucfirst($data->borrower->gender);
                $cibil_data['id_proof_type']=$data->borrower->id_proof_type;
                $cibil_data['residence_type']=$data->borrower->residence_type;
                $cibil_data['borrower_first_name']=$data->borrower->first_name;
                $cibil_data['borrower_last_name']=$data->borrower->last_name;
                $cibil_data['borrower_mobile_number']=$data->borrower->mobile_number;
                $cibil_data['id_proof_number']=$data->borrower->id_proof_number;
                $cibil_data['address_line_1']=$data->borrower->address_line_1;
                $cibil_data['address_line_2']=$data->borrower->address_line_2;
                $cibil_data['borrower_state']=$data->borrower->pincode;
                $cibil_data['borrower_pincode']=$data->borrower->state;
                //run CIBIL for this application
                $request_object1 = Request();
                $request_object1->merge($cibil_data);
                //dd($request_object1->all());
                $cibil_response = $cibil_object->getScore($request_object1,$application_data->id);
                $application_data->cibil_score = $cibil_response;
                $application_data->save();
                //$this->getCibilScore($application_data,$cibil_data);
                
                //create calculation_data for obtaining the calculation
                $calculation_data['estimated_cost']=$application->estimated_cost;
                $calculation_data['loan_required']=$application->loan_required;
                $calculation_data['borrowers_income']=$borrower->borrowers_income;
                $calculation_data['income_itr']=$borrower->income_itr;
                $calculation_data['current_loan_emi']=$borrower->current_loan_emi;
                $calculation_data['house_rent']=$borrower->house_rent;
                $calculation_data['other_expenses']=$borrower->other_expenses;
                $calculation_data['number_of_dependants']=$borrower->number_of_dependants;
                $calculation_data['other_earnings']=$borrower->other_earnings;
                $calculation_data['requested_emi']=$application->requested_emi;
                $calculation_data['requested_tenure']=$application->requested_tenure;
                
                // get financialdetail controller object to run saveCalulations()
                $financial_detail_object = new FinancialDetailController();
                $request_object2 = Request();
                $request_object2->merge($calculation_data);
                //run Calculation for this application
                $financial_detail_object->saveCalulations($application_data,$request_object2);
                
                // store patient detail
                $patient = $application_data->patient()->create([
                            'application_id' => $application_data->id,
                            'first_name' => $patient->first_name, 
                            'middle_name' => $patient->middle_name, 
                            'last_name' => $patient->last_name, 
                            'date_of_birth' => $patient_date_of_birth, 
                            'gender' => $patient->gender, 
                            'mobile_number' => $patient->mobile_number, 
                            'address_line_1' => $patient->address_line_1, 
                            'address_line_2' => $patient->address_line_2, 
                            'city' => $patient->city, 
                            'state' => $patient->state, 
                            'pincode' => $patient->pincode 
                            ]);
                
                //save borrower bank detail
                $application_data->bank_customer_name = $borrower_bank_detail->bank_customer_name;
                $application_data->bank_name = $borrower_bank_detail->bank_name;
                $application_data->bank_account_number = $borrower_bank_detail->bank_account_number;
                $application_data->bank_ifsc_code = $borrower_bank_detail->bank_ifsc_code;
                $application_data->bank_account_type = $borrower_bank_detail->bank_account_type;
                $application_data->save();

                //save borrower documents
                foreach ($borrower_documents as $document) {
                    $merchant_document = $application_data->documents()->create(
                        ['application_id'=> $application_data->id, 'name'=> $document->name,
                         'type'=> $document->type, 'file'=> $document->link
                        ]
                    );
                }                
                
                return ['success'=>'Application saved successfully.',
                        'application_id' => $application_data->id,
                        'type' => $application_data->type,
                        'status' => $application_data->status,
                        'cibil_score' => $application_data->cibil_score,
                        'reference_code'=> $application_data->reference_code,
                        'hospital_name' => $application_data->hospital_name,
                        'treatment_type' => $application_data->treatment_type,
                        'estimated_cost' =>$application_data->estimated_cost,
                        'loan_required' =>$application_data->loan_required,
                        'requested_emi' => $application_data->requested_emi,
                        'requested_tenure' => $application_data->requested_tenure,
                        'approved_hospital_name' => $application_data->approved_hospital_name,
                        'approved_loan_amount' => $application_data->approved_loan_amount,
                        'approved_loan_emi' => $application_data->approved_loan_emi,
                        'approved_loan_tenure' => $application_data->approved_loan_tenure,
                        'interest_rate' => $application_data->interest_rate
                    ];
            }
        } else {
            return ['error'=>'Authentication failed.'];
        }       
    }

    public function updateApplication($reference_code, Request $input)
    {
        $check_token_exist = $this->requetHasToken($input);
        $check_api_token_exist = $this->checkAPIToken($input);
        if($check_api_token_exist) {
            $data = json_decode($input->getContent());
            //$incoming_application = (array) $data->application;
            //$incoming_borrower = (array) $data->borrower;
            //$incoming_patient = (array) $data->patient;
            //$incoming_borrower_bank_detail = (array) $data->borrower_bank_detail;
            if(isset($data->documents)) {
                $incoming_borrower_document = (array) $data->documents;
                $admin = $check_api_token_exist;
                $application = $admin->applications()->where('reference_code', $reference_code)->first();
                if (isset($application)) {
                    if($application->status!='disbursed') {
                        foreach ($incoming_borrower_document as $document) {
                            $application->documents()->create(
                                [
                                    'application_id'=> $application->id,
                                    'name'=> $document->name,
                                    'type'=> $document->type,
                                    'file'=> $document->link
                                ]);
                        }
                        
                        return ['success'=>'Application documents updated successfully',
                            'application_id' => $application->id,
                            'application_status' => $application->status
                           ];

                    } else {
                        return ['error'=>'Application documents cannot be updated.'];
                    }
                    //$borrower = $application->borrower;
                   // $patient = $application->patient;
                    //$update_borrower_bank_detail = $application->update($incoming_borrower_bank_detail);
                    //$update_application = $application->update($incoming_application);
                   // $update_borrower = $borrower->update($incoming_borrower);
                    //$update_patient = $patient->update($incoming_patient);
                    
                    
                } else {
                    return ['error'=>'Application not available.'];
                }
            } else {
                return ['error'=>'Please check the body parameters.'];
            }    
        } else {
            return ['error'=>'Authentication failed.'];
        }       
    }

    public function getApplicationDetail($reference_code, Request $input)
    {
        $check_token_exist = $this->requetHasToken($input);
        $check_api_token_exist = $this->checkAPIToken($input);
        if($check_api_token_exist) {
            $admin = $check_api_token_exist;
            $application = $admin->applications()->where('reference_code', $reference_code)->first();
            if ($application) {
                return [                           
                        'application_id' => $application->id,
                        'type' => $application->type,
                        'status' => $application->status,
                        'cibil_score' => $application->cibil_score,
                        'psychometric_test_result' => $application->psychometric_test_result,
                        'reference_code'=> $application->reference_code,
                        'hospital_name' => $application->hospital_name,
                        'treatment_type' => $application->treatment_type,
                        'estimated_cost' =>$application->estimated_cost,
                        'loan_required' =>$application->loan_required,
                        'requested_emi' => $application->requested_emi,
                        'requested_tenure' => $application->requested_tenure,
                        'approved_hospital_name' => $application->approved_hospital_name,
                        'approved_loan_amount' => $application->approved_loan_amount,
                        'approved_loan_emi' => $application->approved_loan_emi,
                        'approved_loan_tenure' => $application->approved_loan_tenure,
                        'interest_rate' => $application->interest_rate];
                //return $application;
            } else {
                return ['error'=>'Application not available.'];
            }
        } else {
            return ['error'=>'Authentication failed.'];
        }       
    }

    /**
     * [getMerchantApplicationsDetail - Fetch Applications, Borrowers & Patients detail from database]
     * @param  Request $input          [Input data]
     * @return [array]                 [applications,borrowers & patients detail]
     */
    public function getMerchantApplicationsDetail($partner_reference_code, Request $input)
    {
        $check_token_exist = $this->requetHasToken($input);
        $check_api_token_exist = $this->checkAPIToken($input);
        if($check_api_token_exist) {
         $admin = $check_api_token_exist;
            $applications = $admin->applications()->latest()->get();
            $data = array();
            if ($applications->count()>0) {
                foreach ($applications as $application) {
                    /*$application = $application->append('psychometric_result');
                    $application['psychometric_result']=$application->getPsychometricResultAttribute();*/
                    $data[$application->id] = $application;
                }                
                return $data;
            } else {
                return ['error'=>'Application not available.'];
            }
        } else {
            return ['error'=>'Authentication failed.'];
        }       
    }

    /**
     * [getMerchantQueryApplicationsDetail - Query Applications, Borrowers & Patients detail from database]
     * @param  Request $input          [Input data]
     * @return [array]                 [applications,borrowers & patients detail]
     */
    public function getMerchantQueryApplicationsDetail($partner_reference_code, Request $input)
    {
        $check_token_exist = $this->requetHasToken($input);
        $check_api_token_exist = $this->checkAPIToken($input);
        if($check_api_token_exist) {
            $admin = $check_api_token_exist;
            $applications = $admin->applications();
            //dd($applications);            
            if ($applications->count()>0) {
                if ($input->has('status')) {
                    $status = $input->get('status');
                    $applications = $applications->where('status',$status);
                }
                if ($input->has('start-date')) {
                    $start_date = $input->get('start-date');
                    $applications = $applications->whereDate('created_at','>=',$start_date);
                }
                if ($input->has('end-date')) {
                    $end_date = $input->get('end-date');
                    $applications = $applications->whereDate('created_at','<=',$end_date);
                }
                $applications = $applications->latest()->get();                
                $data = array();
                //dd($application->borrower);
                foreach ($applications as $application) {
                    /*$application = $application->append('psychometric_result');
                    $application['psychometric_result']=$application->getPsychometricResultAttribute();*/
                    $data[$application->id] = $application;
                }                
                return $data;               
            } else {
                return ['error'=>'Application not available.'];
            }
        } else {
            return ['error'=>'Authentication failed.'];
        }
    }

    /**
     * [storeHospital store the Merchant hospital  data into our system]
     * @param  Request $input [get the input data from merchant]
     * @return [array]         [return success / error message]
     */
    public function storeHospital(Request $input)
    {
        return ['error'=>'API access denied'];
        $check_token_exist = $this->requetHasToken($input);
        //dd($input->all());
        $check_api_token_exist = $this->checkAPIToken($input);
        if($check_api_token_exist) {
            $data = json_decode($input->getContent());
            //dd($data);
            if (isset($data->hospital)) {
                $hospital = $data->hospital;
                $hospital_exist = Hospital::where('name','like',$data->hospital->name)->first();
                //dd($borrower);
                if (isset($hospital_exist)) {
                    return ['error'=>'Hospital already exist.'];
                } else {
                    $hospital_data = Hospital::create([
                        'name' => $hospital->name,
                        'url' => $hospital->hospital_website,
                        'location' => $hospital->location,
                        'branches' => $hospital->no_of_branch,
                        'acc_name' => $hospital->acc_name,
                        'acc_number' => $hospital->acc_number,
                        'bank_name' => $hospital->bank_name,
                        'bank_branch' => $hospital->bank_branch,
                        'ifsc_code' => $hospital->ifsc_code,
                        'acc_type' => $hospital->acc_type,
                        'hospital_referrer' => 'sistema' // tobe replaced based on api_token user name  
                    ]);
                    return ['success'=>'Hospital saved successfully.',
                            'hospital_detail' => $hospital_data
                        ];
                }
            } else {
                return ['error'=>'Please check the body parameters.'];
            }                  
        } else {
            return ['error'=>'Authentication failed.'];
        }
    }

    public function getMerchantseHospital($hospital_referrer, Request $input)
    {
        $check_token_exist = $this->requetHasToken($input);
        $check_api_token_exist = $this->checkAPIToken($input);
        if($check_api_token_exist) {
            $hospitals = Hospital::where('hospital_referrer', $hospital_referrer)->latest()->get();
            if (isset($hospitals)) {                
                $data = array();
                //dd($application->borrower);
                foreach ($hospitals as $hospital) {
                    $data[$hospital->id] = $hospital;
                }                
                return $data; 
            } else {
                return ['error'=>'Hospital not available.'];
            }
        } else {
            return ['error'=>'Authentication failed.'];
        }       
    }
}
