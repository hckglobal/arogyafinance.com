<?php
namespace App\Http\Controllers\Website\Digio;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Auth;
use App\Admin;
use App\Role;
use Redirect;
use Session;
use App\Application;
use App\Document;
use Carbon\Carbon;
use Log;
use Storage;
use File;
use json;
use App\Mandate;

class DigioController extends Controller
{
    /**
     * Request for NACH to Digio 
     * @param  [int]  $id   Application ID 
     * @return \Illuminate\Http\Response         
     */
    public function requestMandate($id, Request $input)
    {
        //dd($input->all());
        $application = Application::find($id);
        $application->bank_name = $input->bank_name;
        $application->bank_customer_name = $input->bank_customer_name;
        $application->bank_account_number = $input->bank_account_number;
        $application->bank_account_type = $input->bank_account_type;
        $application->bank_ifsc_code = $input->bank_ifsc_code;
        $application->save();
        //dd($application);
        $connection = $this->connectionToDigioServer();
        $authentication = $connection['authentication'];
        $digio_url = $connection['digio_url'];
        $lead = $this->initiate($application, $authentication, $digio_url);
        
        Session::flash('info','Mandate created');
        return redirect()->back();  
    }

    /**
     * Connect to Digio Server 
     * @return \Illuminate\Http\Response                 
     */
    public function connectionToDigioServer()
    {
        $digio_url=env('DIGIO_PRODUCTION_URL');
        $digio_client_id = env('DIGIO_CLIENT_ID');
        $digio_client_secret = env('DIGIO_CLIENT_SECRET');
        $auth = base64_encode($digio_client_id.':'.$digio_client_secret);
        //dd($auth);
        $authentication = new \GuzzleHttp\Client(
            ['headers' => 
                ['Content-Type' => 'application/json',
                 'Authorization'=> 'Basic '.$auth]
            ]);

        return ['digio_url'=>$digio_url,'authentication'=>$authentication];
    }

    /**
     * Initiate nach for a this application
     * @param  [object] $application    
     * @param  [property] $authentication         
     * @param  [property] $digio_url   
     * @return \Illuminate\Http\Response                 
     */
    public function initiate($application,$authentication, $digio_url)
    {
        $lead = $this->NACHCreation($application, $authentication, $digio_url);
    }

    /**
     * NACH Creation for this application
     * @param  [object] $application    
     * @param  [property] $authentication         
     * @param  [property] $digio_url   
     * @return                  
     */
    public function NACHCreation($application, $authentication, $digio_url)
    {
        //dd($application->bank_ifsc_code,$application->bank_name);
        /* NACH Creation */
        $today_timestamp = Carbon::now('Asia/Kolkata')->format('Y-m-d\TH:i:sP');
        
        $data=array();
        $signers = array();
        array_push($signers,['identifier'=>$application->borrower->mobile_number]);
        $data['signers']=$signers;
        $data['enach_type']='create';
        $data['partner_entity_email']='nach@hdfcbank.com';
        $nach = array();
        $nach['"mandate_request_id"']='"'.$application->pin_number.'"';
        $nach['"mandate_creation_date_time"']='"'.$today_timestamp.'"';
        $nach['"sponsor_bank_id"']='"HDFC0000060"';
        $nach['"sponsor_bank_name"']='"HDFC Bank Ltd"';
        $nach['"bank_identifier"']='"HDFC"'; // need to ask digio
        $nach['"login_id"']='"HDFC01664000013114"';
        $nach['"customer_account_type"']='"'.$application->bank_account_type.'"';
        $nach['"management_category"']='"L001"';
        $nach['"service_provider_name"']='"RAMTIRTHLEASING & FI"';
        $nach['"service_provider_utility_code"']='"HDFC01664000013114"';
        $nach['"customer_account_number"']='"'.$application->bank_account_number.'"';
        $nach['"instrument_type"']='"debit"';
        $nach['"customer_name"']='"'.$application->bank_customer_name.'"';
        $nach['"customer_email"']='"'.$application->borrower->email.'"';
        $nach['"customer_ref_number"']='"'.$application->pin_number.'"';
        //$nach['"destination_bank_id"']='"'.$application->bank_ifsc_code.'"';
        //$nach['"destination_bank_name"']='"'.$application->bank_name.'"';
        $nach['"first_collection_date"']='"'.Carbon::parse($application->getOriginal('valid_from'))->format('Y-m-d').'"';
        $nach['"customer_mobile"']='"'.$application->borrower->mobile_number.'"';
        $nach['"maximum_amount"']='"'.$application->approved_loan_emi.'"';
        $nach['"is_recurring"']='"true"';
        $nach['"frequency"']='"Adhoc"';    
        //dd($input->all());
        $nach = json_encode($nach,JSON_HEX_APOS);
        
        $nach  = str_replace('"', '', $nach);
        $nach  = str_replace('\\', '\"', $nach);
        //dd($nach);
        $data['content']=$nach;
        //dd($data, $input->all());
        //dd(parseJSON($content));
        /* End of NACH Creation */
        
        $nach1=json_encode($data);
        $nach1  = str_replace("\\\\", "\\", $nach1);
        $nach1  = str_replace("\\\\", "\\", $nach1);
        //dd($nach1);
        $nach_url = $digio_url."/v2/client/enach/mandate/create_form";
        // Create a request with auth credentials
        $nach_url_response = $authentication->request('POST',$nach_url,['body'=>$nach1]);
        //dd($nach_url_response->getBody());
        // Get the actual response without headers
        //$lead_response = $lead_url_response->getBody();
        $nach_response =json_decode($nach_url_response->getBody(), true);
        //dd($nach_response);

        if ($nach_response) {
            $data['application_id']=$application->id;
            $data['mandate_id']=$nach_response['id'];
            $data['type']=$nach_response['enach_type'];
            $data['status']=$nach_response['status'];
         
            $mandate = Mandate::create($data);     
        } else {
            return "Failed to create mandate";
        }
    }

    public function requestESign($id)
    {
        $application = Application::find($id);
        $borrower = $application->borrower;
        $connection = $this->connectionToDigioServer();
        $authentication = $connection['authentication'];
        $digio_url = $connection['digio_url'];
        
        $esign_url_sandbox = 'https://ext.digio.in/#/gateway/login/'.$application->mandate->mandate_id.'/'.$application->pin_number.'/'.$application->borrower->mobile_number.'?redirect_url=https://arogyafinance.com/user/dashboard';

        $esign_url_production = 'https://app.digio.in/#/gateway/login/'.$application->mandate->mandate_id.'/'.$application->pin_number.'/'.$application->borrower->mobile_number.'?redirect_url=https://arogyafinance.com/user/dashboard';
        Session::put('borrower_id',$application->borrower->id);
        return view('website.pages.dashboard.esign')->with(['locale'=>'en','borrower'=>$borrower,'application'=>$application,'esign_url_production'=>$esign_url_production]);
        //dd($esign_url);
    }

    public function getMandateFormMetaData($id)
    {
        $application = Application::find($id);
        //dd($application->mandate);
        $borrower = $application->borrower;
        $connection = $this->connectionToDigioServer();
        $authentication = $connection['authentication'];
        $digio_url = $connection['digio_url'];
        $mandate_status_url = $digio_url."/v2/client/enach/mandate/form/".$application->mandate->mandate_id;
        // Create a request with auth credentials
        $mandate_status_url_response = $authentication->request('GET',$mandate_status_url);
        //dd($mandate_status_url_response->getBody());
        // Get the actual response without headers
        //$lead_response = $lead_url_response->getBody();
        $mandate_response =json_decode($mandate_status_url_response->getBody(), true);
        //dd($mandate_response);
        if ($mandate_response) {
            $mandate = $application->mandate;
            $mandate->status = $mandate_response['status'];
            $mandate->partner_entity_status = $mandate_response['partner_entity']['status'];
            if(array_key_exists('umrn', $mandate_response)){
                $mandate->umrn = $mandate_response['umrn'];
            }
            
                        
            $mandate->save();            
        }
        Session::flash('info','Mandate status updated');
        return redirect()->back();  
    }

    
}
