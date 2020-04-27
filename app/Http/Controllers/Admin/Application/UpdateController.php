<?php

namespace App\Http\Controllers\Admin\Application;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Note;
use Session;
use Redirect;
use Zipper;
use Carbon\Carbon;
use App\User;
use App\Application;
use PDF;
use Input;
use App\Borrower;
use App\Log;
use App\Location;
use App\Helpers\SMSProvider;
use App\Helpers\Alerts;
use Terbilang;
use App\RejectionReason;
use App\Product;
use App\Reference;
use App\Hospital;
use App\RepaymentCheque;
use App\FamilyMember;
use App\Document;
use File;

class UpdateController extends Controller
{
    /**
     * Update application internal details 
     * @param  [string]  $type  [loan/card]
     * @param  [int]  $id    [application id]
     * @param  Request $input [form data]
     * @return \Illuminate\Http\Response
     */
    public function updateInternalDetails($type,$id,Request $input)
    {
        $application = Application::find($id);
        $admin_id = Auth::user()->id;
        //destination path is a folder
        $basePath= public_path()."/documents/".$application->id; 
        //$basePath= public_path()."/documents/".$application->id; 
        $inputs = collect($input->all());

        /*if ($input->has('documents')) {

            $documents = $input->file('documents');
            $document_names= $input->get('documents');
            foreach ($documents as $key=>$document) {
                $documentName = array_key_exists("name", $document_names[$key]) ? $document_names[$key]["name"] : '';
                $documentType = array_key_exists("type", $document_names[$key]) ? $document_names[$key]["type"] : '';
                $file = $document["files"];
                
                if ($file) {
                    $fileName = str_random(5).str_slug($documentName).".".$file->getClientOriginalExtension();
                    //move file
                    $file->move($basePath, $fileName);
                    $application->documents()->create(["file"=>$fileName,"name"=>$documentName,
                                                       "type"=>$documentType]);
                }
            }
        }*/
        if ($input->has('documents')) {

            foreach($input->all() ['documents'] as $document) {

                if (array_key_exists("type", $document)) {
                    $type = $document["type"];
                }
                else {
                    $type = 'additional-documents';
                }

                if (array_key_exists("files", $document)) {

                    foreach($document['files'] as $file) {

                        if ($file != null) {
                            $documentName = $document["name"];
                            $type = $document["type"];
                            $fileName = str_slug($documentName) . "_" . str_random(5) . "." . $file->getClientOriginalExtension();
                            // move file
                            $file->move($basePath, $fileName);
                            $application->documents()->create(["file" => $fileName, "name" => $documentName, "type" => $type]);
                        }
                        
                    }
                }
            }
        }


        //skip documents & form token of uploading documents
        $inputs= $input->except(['documents','_token']);

        foreach ($inputs as $field_name=>$value) {
            $old_value = $application->{$field_name};

            if (!$old_value) $old_value="";
      
            //enter only if value has changed
            if($field_name=='valid_from' || $field_name=='valid_upto' || $field_name=='disbursement_date') {
                $old_value = Carbon::parse($application->getOriginal($field_name))->format('d-m-Y');
            }
            if ($old_value != $value) {
                Log::store($id,$admin_id,$field_name,$old_value,$value);
            }
        }
        //dd($inputs);
        //finally update the application
        $application->update($input->all());
        // validity detail
        if ($input->has('valid_from')) {

            $tenure = $application->type=="card" ? 12 :$application->approved_loan_tenure-1;
            $advance_emi = $application->advance_emi ?  $application->advance_emi : 0;
            $valid_from = Carbon::parse($input->get('valid_from'));

            if ($application->type=="card") {
                $application->valid_upto = $valid_from->addMonths($tenure)->subDay(1);                
                $application->valid_from = Carbon::parse($input->get('valid_from'))->format('d-m-Y');
            } else {
                $tenure = $tenure- $advance_emi;
                $application->valid_from = $valid_from;
                $application->valid_upto = $valid_from->addMonths($tenure);
            }
                   
            $application->approved_loan_emi=$application->flat_interest_rate;    
            $application->save();
        }
        if ($input->has('disbursement_date')) {

            $application->disbursement_date = Carbon::parse($input->get('disbursement_date'))->format('Y-m-d');
            $application->save();
        }      
        Session::flash('info','Application updated');
        
        return redirect()->back();
    }

    /**
     * Submit Nominee for this application
     * @param  Request $input [form data]
     * @return \Illuminate\Http\Response
     */
    public function submitNominee(Request $input)
    {
        $borrower = Borrower::create($input->all());
        $borrower->first_name = $input->get('borrower_first_name');
        $borrower->middle_name = $input->get('borrower_middle_name');
        $borrower->last_name = $input->get('borrower_last_name');
        $borrower->gender = $input->get('borrower_gender');
        $borrower->mobile_number = $input->get('borrower_mobile_number');
        $borrower->date_of_birth =  $input->get('borrower_birthday_year');
        $borrower->date_of_birth .= "-".$input->get('borrower_birthday_month');
        $borrower->date_of_birth .= "-".$input->get('borrower_birthday_day');
        $borrower->state = $input->get('borrower_state');
        $borrower->city = $input->get('borrower_city');
        $borrower->pincode= $input->get('borrower_pincode');
        $borrower->save();

        return redirect()->back();
    }

    /**
     * Enable Psychometric Test for this application 
     * @param  [int] $application_id 
     * @return \Illuminate\Http\Response
     */
    public function switchEnablePsychometricTest($application_id) 
    {
        $application = Application::find($application_id);
        $application->enable_psychometric_test = !$application->enable_psychometric_test;
        $application->save();
        
        return redirect()->back();
    }

    /**
     * Save Reference detail for this application
     * @param  [int]  $application_id
     * @param  Request $input  [form data]
     * @return \Illuminate\Http\Response
     */
    public function saveReference($application_id,Request $input) 
    {
        $reference_one = Reference::create([
                            'application_id'=>$application_id,'relation'=>$input->get('relation'),
                            'name'=>$input->get('name'),'mobile_number'=>$input->get('mobile_number'),
                            'address'=>$input->get('address')
                        ]);
      
        return redirect()->back();
    }

    /**
     * Save Family Member for this applicaiton
     * @param  [int]  $application_id 
     * @param  Request $input          [form data]
     * @return \Illuminate\Http\Response
     */
    public function saveFamilyMember($application_id,Request $input)
    {
        $application=Application::find($application_id);

        if ($input->has('family_members')) {

            foreach ($input->get('family_members') as $family) {

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
        Session::flash('info','Family Member added');
        
        return redirect()->back();
    }

    /**
     * [updateMerchantStatus send the application status to Ablepay update API]
     * @param  [int] $id [application id]
     * @return \Illuminate\Http\Response
     */
    public function updateMerchantStatus($id)
    {
        $application=Application::find($id);
        
        $old_value = $application->status;
        $new_value = $application->status='disbursed';
        $application->dmi_status='new';
        $application->dmi_sent=0;
        $date = Carbon::now();
        $application->dmi_issue_date=$date;
        $application->save();

        Log::store($application->id,Auth::user()->id,'status','sanctioned',$new_value);
        
        $authentication = new \GuzzleHttp\Client(
            ['headers' => ['Content-Type' => 'application/json','Accept' => 'application/json',
             'Authorization'=> 'Token 71159b5549b2608561c8c8f02d8fcdf536e5d790']
            ]);
        $body['applicationId'] = "adf513c5-ddcf-45f2-bf8d-344b57a910aa";
        //$body['applicationId'] = $application->merchantName->order_id;
        $body['status'] = $application->status;
        $body['disburseAmount'] = $application->approved_loan_amount;
        $body['disburseDate'] = $application->disbursement_date;
        $body['arogyaRefId'] = $application->pin_number;
        
        $auth_url="https://staging.ablepay.in/lenders/integrations/arogya/incoming/";
        // Create a request with auth credentials
        $ablepay_url_response = $authentication->request('POST',$auth_url, [
            'form_params' => $body
        ]);
        // Get the actual response without headers
        //$lead_response = $ablepay_url_response->getBody();
        $ablepay_response =json_decode($ablepay_url_response->getBody(), true);
        
        
        Session::flash('info','Merchant Status updated');
        return redirect()->back();
    }

    /**
     * [updateSelfPatient update the application self-patient to yes or no]
     * @param  [type] $id [application id]
     * @return \Illuminate\Http\Response
     */
    public function updateSelfPatient($id,Request $input)
    {
        $application=Application::find($id);
        // get colunn name
        $column_name = $input->get('name');
        // get column value
        $input_value =  ucFirst($input->get('value'));
        if ($input_value=='Yes') {
            $new_value = 1;
        } else {
            $new_value = 0;
        }
        // get admin id
        $admin_id = Auth::user()->id;
        // get old value 
        $old_value = $application->{$column_name};
        $field = 'application =>'.$column_name;
        //update borrower 
        $application->update([$column_name => $new_value]);
        //log application update
        Log::create(['application_id' => $application->id, 'admin_id' => $admin_id,
                     'field' => $field, 'old_value' => $old_value, 'new_value' => $new_value]);
    }


    public function importForm()
    {   
        $title = "Update Application Data";
        return view('admin.pages.application.import',['title'=>$title]);
    }

    public function import(Request $request)
    {
        if ($request->hasFile('sample_file')) {
            $path = $request->file('sample_file')->getRealPath();
            $data = \Excel::load($path)->get();
            
            if ($data->count()) {
                foreach ($data as $key => $value) {
                    $application = Application::find($value->application_id);
                    if($application) {
                    $application->update([
                                        'id'=>(int)$value->application_id,
                                        'pin_number'=>$value->application_pin,
                                        'disbursement_date'=>$value->disbursement_date,
                                        'estimated_cost'=>$value->medical_bill,
                                        'approved_hospital_name'=>$value->hospital_name,
                                        'mode_of_payment'=>$value->mode_of_payment,
                                        'bank_name'=>$value->bank_name,
                                        'bank_account_number'=>$value->account_no,
                                        'bank_customer_name'=>$value->bank_account_name,
                                        'foir'=>$value->foir,
                                        'advance_emi'=>(int)$value->no_of_adv_emi,
                                        'subvention'=>(int)$value->subvention
                                     ]);

                    $application->borrower->update(
                                 [ 'application_id'=>(int)$value->application_id,
                                    'residing_since'=>(int)$value->borrower_residence_stability,
                                    'relation_with_patient'=>$value->borrower_relation_with_patient,
                                    'email'=>$value->borrower_email_id,
                                    'marital_status'=>$value->borrower_marital,
                                    'nature_of_income'=>$value->borrower_sector,
                                    'earning_since'=>$value->borrower_earning_since
                                 ]);

                    $application->patient->update(
                                 [ 'application_id'=>(int)$value->application_id,
                                    'pan_card'=>$value->patient_pan,
                                    'voting_id'=>$value->patient_voter_id,
                                    'aadhar_card'=>$value->patient_aadhar,
                                    'address_line_1'=>$value->patient_address_1,
                                    'address_line_2'=>$value->patient_address_2,
                                    'city'=>$value->patient_city,
                                    'pincode'=>(int)$value->patient_pincode,
                                    'mobile_number'=>(int)$value->patient_mobile,
                                    'residing_since'=>(int)$value->patient_residence_stability,
                                    'marital_status'=>$value->patient_marital
                                 ]);
                    }

                }
                
                /*if (!empty($arr)) {*/
                   /* $application_id = Application::find($application['id']);
                    dd($application_id)
                    $update_app = $application_id->update($application);*/
                    /*$application_id = Application::find($application['id']);
                    $borrower_id = $application_id->borrower;
                    $update_borrower = $borrower_id->update($borrower);
                    $application_id = Application::find($application['id']);
                    $patient_id = $application_id->patient;
                    $update_patient = $patient_id->update($patient);*/
                    /*Session::flash('info','Application Updated Successfully');
                    return redirect('/admin/application/import/file');
                }*/
            }
        Session::flash('info','Application Updated Successfully');
        return redirect('/admin/application/import/file');
        }
    }

    public function updateValidUpto()
    {
        $applications = Application::where('type','loan')->where('status','disbursed')->get();
        foreach ($applications as $application) {
                $tenure = $application->type=="card" ? 12 :$application->approved_loan_tenure-1;
                $advance_emi = $application->advance_emi ?  $application->advance_emi : 0;
                $valid_from = Carbon::parse($application->getOriginal('valid_from'));

                if ($application->type=="card") {
                    $application->valid_upto = $valid_from->addMonths($tenure)->subDay(1);                    
                    $application->valid_from = Carbon::parse($application->getOriginal('valid_from'))->format('d-m-Y');                    
                } else {
                    $tenure = $tenure- $advance_emi;
                    $application->valid_from = $valid_from;
                    $application->valid_upto = $valid_from->addMonths($tenure);
                }
                $application->approved_loan_emi=$application->flat_interest_rate;    
            $application->save();
        }
              
        Session::flash('info','Application valid upto updated');
        
        return redirect()->back();
    }
}
