<?php

namespace App\Http\Controllers\Api\DMI;
use Illuminate\Http\Request;
use App\Application;
use App\ReferrerCompany;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;

class PartnerController extends Controller
{
    /**
     * validation rules 
     * @var array
     */
    protected $validationRules = ['api_token' => 'required'];

    /**
     * Display application based on the refernce_company_id
     * @param  [string]  $company 
     * @param  Request $input   
     * @return \Illuminate\Http\Response           
     */
    public function index($company,Request $input)
    {   
        //validation code
        $validator = Validator::make($input->all(),$this->validationRules);

        //if validation fails displays errors in json format
        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }

        $apitoken = $input->get('api_token');
        $referrer = ReferrerCompany::where('slug',$company)
                     ->where('api_token',$apitoken)->first();
        
        if ($referrer==null) {
            return  ["success"=>false,"message"=>"Authentication Failed!"];
        }

        $applications =Application::where('referrer_company_id',$referrer->id)->get();
        return ["success"=>true, "message"=>$applications];
    }

    /**
     * Display application details based on the company id
     * @param  [string]  $company 
     * @param  [type]  $id      
     * @param  Request $input   
     * @return \Illuminate\Http\Response             
     */
    public function show($company,$id, Request $input)
    {
    	//validation code
    	$validator=Validator::make($input->all(),$this->validationRules);

    	//if validation fails displays errors in json format
    	if ($validator->fails()) {
    		return response()->json($validator->messages(), 200);
    	}

    	$apitoken = $input->get('api_token');
        $application = Application::find($id);
        $referrer= ReferrerCompany::where('api_token', $apitoken)->first();

        if ($referrer == null) {
        	return ["success"=>false, "message"=>"Authentication Falied!"];
        }

        $result = ["application_id"=>$application->id,
                   "borrower_first_name"=>$application->borrower->first_name,
                   "borrower_last_name"=>$application->borrower->last_name,
                   "borrower_mobile_number"=>$application->borrower->mobile_number,
                   "borrower_email"=>$application->borrower->email,
                   "referrer_company_id"=>$application->referrer_company_id,
                   "referrer_id"=>$application->referrer_id,
                   "status"=>$application->status,
                   "pin_number"=>$application->pin_number
                  ];
        return ["success"=>true, "message" => $result];
    }

    /**
     * DMI Status Update 
     * @param  [int]  $id    
     * @param  Request $input 
     * @return \Illuminate\Http\Response             
     */
    public function dmiStatusUpdate($id,Request $input)
    {   
        //get the user api token.
        $user_token =$input->get('token');

        //check whether user enter status or not.if not, show error message.
        if ($this->api_token!=$user_token) return ["success"=>false,"message"=>"Authentication failed"];

        //list of valid statuses.
        $valid_statuses=collect(["accepted","rejected"]);
        //get the user input status.
        $status =$input->get('status');

        //check whether user enter status or not.if not, show error message.
        if (!$status) return ["success"=>false,"message"=>"Status is required"];

        //check if the user status match with valid statuses.
        $exist=$valid_statuses->contains($status);

        //check whether status is valid or not.
        if (!$exist) return ["success"=>false,"message"=>"Invalid status provided"];

        $application = Application::find($id);
        //check whether application exist.
        //if not exist,show error message.
        //if exist update that application dmi status.
        if (!$application)  return ["success"=>false,"message"=>"Application not found"];
        
        $application->dmi_status=$status;
        $application->save();

        return ["success"=>true,"message"=>"Status Updated"];   
    }
 
}
