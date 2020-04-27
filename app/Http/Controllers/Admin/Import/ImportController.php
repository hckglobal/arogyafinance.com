<?php

namespace App\Http\Controllers\Admin\Import;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Application;
use App\Borrower;
use Excel;
use Carbon\Carbon;
use App\PsychometricTest;
use App\Product;
use App\Location;
use Session;

class ImportController extends Controller
{

    public function index(){
        return view ('admin.pages.import.index');
    }
    /**
     * Display a option to choose file for importing data.
     *
     * @return \Illuminate\Http\Response
     */
    public function importTranzcomsForm()
    {   
        $title = "Import Tranzcoms";
        return view('admin.pages.application.import',['title'=>$title]);
    }

    /**
     * Inmport tranzcom data
     *
     * @return \Illuminate\Http\Response
     */
    public function importTranzcoms(Request $input)
    {        
        if ($input->hasFile('sample_file')) {
            $path = $input->file('sample_file')->getRealPath();
            $data = \Excel::load($path)->get();
            if ($data->count()>0) {
                $sheets = $data->toArray();
                foreach ($sheets as $row) {
                    //foreach ($data as $row) {
                        //dd($row);
                        /***  Application Data  ***/
                        $application_data['type']='loan';
                        $application_data['status']='closed';
                        $application_data['pin_number']=$row['patient_identification_number'];
                        $application_data['location_id']=$row['location_id'];
                        $application_data['product_id']=$row['product_id'];
                        $application_data['documentation_charge']=(int)$row['document_charges'];
                        /*$application_data['processing_fee']=((int)$row['processing_charges']/(int)$row['disbursed_amount']) * 100;*/
                        $application_data['processing_fee']=1.899;

                        $application_data['subvention']=(float)$row['subvention'];
                        $application_data['approved_loan_amount']=(int)$row['disbursed_amount'];
                        $application_data['approved_loan_emi']=(int)$row['final_emi'];
                        $application_data['approved_loan_tenure']=(int)$row['loan_tenure'];
                        $application_data['disbursement_date']=$row['date_of_disbursal'];
                        $application_data['advance_emi']=(int)$row['no_of_advance_emi'];
                        $tenure = $application_data['approved_loan_tenure']-1;
                        if($application_data['advance_emi']>0) {
                            $application_data['advance_emi'] = $application_data['advance_emi'];
                        } else {
                            $application_data['advance_emi'] = 0;
                        }                        
                        $valid_from = $row['first_emi_month'];
                        $tenure = $tenure - $application_data['advance_emi'];
                        $application_data['valid_from'] = $valid_from;
                        $application_data['valid_upto'] = Carbon::parse($valid_from)->addMonths($tenure);
                        $application_data['self_patient']=$row['self_patient'];
                        $application_data['estimated_cost']=$row['estimated_cost'];
                        $application_data['loan_required']=$row['loan_required'];
                        $application_data['requested_tenure']=$row['requested_tenure'];
                        $application_data['requested_emi']=$row['requested_emi'];
                        $application_data['interest_rate']=$row['interest_rate'];
                        $application_data['closer_reason_id']=2;
                        $application_data['closer_note']='Tranzcom';
                        $application_data['closer_date']=$application_data['valid_upto'];
                        $application = Application::create($application_data);
                        $application->created_at=$row['application_created_at'];
                        $application->save();                        
                        
                        /***  Notes Data  ***/
                        $notes_data['admin_id'] = 3;
                        $notes_data['text'] = $row['notes'];
                        $notes_data['application_id'] = $application->id;
                        $notes_data['type'] = 'internal';                        
                        $application->notes()->create($notes_data);


                        /***  Psychometric Test Data  ***/
                        $psychometric_data['application_id'] = $application->id;
                        $psychometric_data['result'] = 'N/A';
                        $psychometric_data['test_url'] = '#';
                        $application->psychometricTest()->create($psychometric_data);

                        /***  Borrower Data  ***/
                        $borrower_data['type']='primary';
                        $borrower_data['first_name']=$row['borrower_first_name'];
                        $borrower_data['last_name']=$row['borrower_last_name'];
                        $borrower_data['gender']=$row['borrower_gender'];
                        if($row['borrower_aadhar_number']){
                            $borrower_data['id_proof_type']='Aadhaar Card';
                            $borrower_data['id_proof_number']=$row['borrower_aadhar_number']; 
                            $borrower_data['aadhar_card_number']=$row['borrower_aadhar_number'];    
                        } else {
                            $borrower_data['aadhar_card_number']='N/A';
                        }
                        if($row['borrower_pan_number']){
                            $borrower_data['pan_card_number']=$row['borrower_pan_number'];                            
                            $borrower_data['id_proof_type']='PAN Card';
                            $borrower_data['id_proof_number']=$row['borrower_pan_number']; 
                        } else {
                            $borrower_data['pan_card_number']='N/A';
                        }
                        $borrower_data['relation_with_patient']=$row['borrower_relationship_with_patient'];
                        $borrower_data['address_line_1']=$row['borrower_addressline_1'];
                        $borrower_data['city']=$row['borrower_city'];
                        $borrower_data['state']=$row['borrower_state'];     
                        if($row['borrower_nature_of_income']){
                            $borrower_data['nature_of_income']=$row['borrower_nature_of_income'];    
                        } else {
                            $borrower_data['nature_of_income']='N/A';
                        }
                        $borrower = $application->borrower()->create($borrower_data);
                        
                        /***  Patient Data  ***/
                        $patient_data['first_name']=$row['borrower_first_name'];
                        $patient_data['last_name']=$row['borrower_last_name'];
                        if($row['borrower_gender']){
                            $patient_data['gender']=$row['borrower_gender'];    
                        } else {
                            $patient_data['gender']='N/A';
                        }
                        if($row['borrower_addressline_1']){
                            $patient_data['address_line_1']=$row['borrower_addressline_1'];    
                        } else {
                            $patient_data['address_line_1']='N/A';
                        }
                        if($row['borrower_state']){
                            $patient_data['state']=$row['borrower_state'];    
                        } else {
                            $patient_data['state']='N/A';
                        }
                        if($row['borrower_city']){
                            $patient_data['city']=$row['borrower_city'];    
                        } else {
                            $patient_data['city']='N/A';
                        }
                        $patient = $application->patient()->create($patient_data);
                    //}   
                }
            }
        }
        
        Session::flash('info','Tranzcoms data imported Successfully');
        
        return redirect('/admin/import/tranzcoms');
    }
}
