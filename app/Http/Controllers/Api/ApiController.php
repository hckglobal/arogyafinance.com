<?php 

namespace App\Http\Controllers\Api;

use Log;
use Illuminate\Http\Request;
use App\Application;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use File;
use PDF;

header('Content-type: application/xml');

class ApiController extends Controller
{
    
    public function getYearlyData($type)
    {
         $data = Auth::user()->applications()
            ->where('type',$type)
            ->where(DB::raw("YEAR('created_at') = YEAR(CURDATE())"))
            ->select(DB::raw("MONTHNAME(created_at) as 'month'"), DB::raw("count(*) as applications"))
            ->orderBy('created_at','asc')
            ->groupBy('month')
            ->get();
        return $data;
    }

    public function ucb(Request $input)
    {

       if(!$input->has('api_token')) return ['error'=>'Authentication Failed'];
       
       if($input->get('api_token')!='15a74cac32e9ba04') return ['error'=>'Authentication Failed'];

       return Application::whereIn('treatment_type',['Multiple Sclerosis','MS','M.S.','M S','M.S','MS.'])->get();
    }

    public function show($id, Request $input)
    {

        

        if(!$input->has('api_token')) return ['error'=>'Authentication Failed'];
        if($input->get('api_token')!='15a74cac32e9ba04') return ['error'=>'Authentication Failed'];
        $application =  Application::find($id);

        if(!in_array($application->treatment_type, ['Multiple Sclerosis','MS','M.S.','M S','M.S','MS.'])){
            
            return ['error'=>'Application Access Denied, Non Multiple Sclerosis Case'];
        } 

        return $application;
    }


    public function index(Request $input)
    {

    $applications = Application::where('status','disbursed')->where('type','loan');

    if($input->has('start-date')){

     $applications = $applications->whereDate('disbursement_date','>=',$input->get('start-date'));
    }

    if($input->has('end-date')){
      $applications=  $applications->whereDate('disbursement_date','<=',$input->get('end-date'));
    }
    $array = $applications->get(); 
   

    $data = json_decode($array, true);

    // creating object of SimpleXMLElement
    $xml_data = new \SimpleXMLElement('<?xml version="1.0"?><data></data>');

    // function call to convert array to xml
    $this->array_to_xml($data,$xml_data);

    return response($xml_data->asXml(), 200)->header('Content-Type', 'text/plain');


    }


   
    /**
     * Convert array to xml
     * @param  array $data   json array to be converted
     * @param  SimpleXMLElement &$xml_data 
     */
   function array_to_xml( $data, &$xml_data ) {
        foreach( $data as $key => $value ) {
            if( is_numeric($key) ){
                $key = 'application'; //dealing with <0/>..<n/> issues
            }
            if( is_array($value) ) {
                $subnode = $xml_data->addChild($key);
                $this->array_to_xml($value, $subnode);
            } else {
                $xml_data->addChild("$key",htmlspecialchars("$value"));
            }
         }
    }
   
}
