<?php

namespace App\Http\Controllers\Mobile;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\HospitalDirector;
use App\Helpers\Api;
use App\Hospital;
use Helpers\HospitalDirectorCibilAPI;

class HospitalDirectorController extends Controller
{
    /**
     * Save Hopital Director Info
     * @param  $input       
     * @return App/Hopital Director
     */
    public function store(Request $input)
    {
        $check_if_exist = $this->checkDedup($input);
        if($check_if_exist) {
            return Api::error("Hospital Director Already Exist");
        } else {
            if($input->has('hospital_id')) {
                $hospital = Hospital::find($input->hospital_id);
                if($hospital) {
                    $date_of_birth = $input->birthday_year;
                    $date_of_birth.= "-" . $input->birthday_month;
                    $date_of_birth.= "-" . $input->birthday_day;
                    $input->request->add(['date_of_birth'=>$date_of_birth]);
                    $input->request->remove('birthday_year');
                    $input->request->remove('birthday_month');
                    $input->request->remove('birthday_day');
                    $hospital_director = $this->saveHospitalDirectorInfo($input,$hospital);
                    //Step-2 Generate Credit Bureau Analysis
                    //$this->getCibilScore($input,$hospital_director->id); 
                    return Api::success("Hospital Director Created!");
                }    
            }
        }
    }

    /**
     * Save Borrower Info into database
     */
    public function saveHospitalDirectorInfo($input,$hospital)
    {
        $hospital->hospitalDirector()->create($input->all());
        return $hospital;
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
            $application->cibil_score = HospitalDirectorCibilAPI::getScore($input,$application->id);
            $application->save();
        }
    }

    /**
     * [checkDedup check if requested hospital director data already exist.]
     * @param  [array] $input [payload data]
     * @return [boolean]        [return true if application exist else false]
     */
    public function checkDedup($input)
    {
        $hospital_director = HospitalDirector::
                    where(function ($query) use($input) {
                        $query->where('first_name', 'like', '%'.$input->first_name.'%')
                            ->where('last_name', 'like', '%'.$input->last_name.'%')
                            ->where('date_of_birth', $input->date_of_birth);
                        }
                    )->orWhere(function($query) use($input) {
                        $query->where('first_name', 'like', '%'.$input->first_name.'%')
                            ->where('id_proof_number',$input->id_proof_number);
                        }
                    )->orWhere(function($query) use($input) {
                        $query->where('last_name', 'like', '%'.$input->last_name.'%')
                            ->where('id_proof_number', $input->id_proof_number);
                        }
                    )->orWhere(function($query) use($input) {
                        $query->where('date_of_birth', $input->date_of_birth)
                            ->where('id_proof_number', $input->id_proof_number);
                        }
                    )->get()->first();
        return $hospital_director;
    }
}
