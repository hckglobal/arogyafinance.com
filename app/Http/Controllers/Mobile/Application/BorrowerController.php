<?php

namespace App\Http\Controllers\Mobile\Application;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Application;
use App\Helpers\Api;
use Helpers\CibilAPI;

class BorrowerController extends Controller
{
    /**
     * Save Borrower Info
     * @param  $application
     * @param  $input       
     * @return App/Borrower
     */
    public function saveBorrowerDetail($id,Request $input)
    {
        $application = Application::find($id);
        if ($application) {
            //Step-1 Update borrower detail
            $borrower = $this->saveBorrowerInfo($application, $input);
            
            //append id-proof-type & id-proof-number to input data
            $input->request->add(['id_proof_type'=>$borrower->id_proof_type,'id_proof_number'=>$borrower->id_proof_number]);
            
            //Step-2 Generate Credit Bureau Analysis
            $this->getCibilScore($application, $input); 
            // step-3 : check if application is eligible for psychometric test.
            $this->updatePsychometricStatus($application);

            return Api::success("Borrower Detail Updated!",['id'=>$application->id,'type'=>$application->type]);
        } else {
            return Api::error("Failed to Updated Borrower Detail.");
        }
    }

    /**
     * Save Borrower Info into database
     */
    public function saveBorrowerInfo($application, $input)
    {
        $borrower = $application->borrower;
        /*$borrower->date_of_birth = $input->borrower_birthday_year;
        $borrower->date_of_birth.= "-" . $input->borrower_birthday_month;
        $borrower->date_of_birth.= "-" . $input->borrower_birthday_day;*/
        $borrower->gender = $input->borrower_gender;
        $borrower->marital_status = $input->borrower_marital_status;
        /*$borrower->id_proof_type = $input->id_proof_type;
        $borrower->id_proof_number = $input->id_proof_number;
        if($borrower->id_proof_type=='PAN Card') {
            $borrower->pan_card_number=$input->id_proof_number;
        }
        if($borrower->id_proof_type=='Aadhaar Card') {
            $borrower->aadhar_card_number=$input->id_proof_number;
        }*/
        $borrower->address_line_1 = $input->address_line_1;
        $borrower->address_line_2 = $input->address_line_2;
        $borrower->state = $input->borrower_state;
        $borrower->city = $input->borrower_city;
        $borrower->pincode= $input->borrower_pincode;
        $borrower->residence_type = $input->residence_type;
        $borrower->save();
        return $borrower;
    }

    /**
     * Get CIBIL Score 
     * @param  $application 
     * @param  $input 
     * @return 
     */
    public function getCibilScore($application, $input)
    {
        $cibil_access = env('ENABLE_CIBIL');
        if($cibil_access){
            $application->cibil_score = CibilAPI::getScore($input,$application->id);
            $application->save();
        }
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
}
