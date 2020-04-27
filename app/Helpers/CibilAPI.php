<?php
namespace Helpers;

use Illuminate\Http\Request;
use Log;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
class CibilAPI
{

  public static function getScore(Request $input,$id){
   
    $date = $input->get('borrower_birthday_year')."-".$input->get('borrower_birthday_month')."-".$input->get('borrower_birthday_day');
    $dob = date('dmY', strtotime($date));

    switch (ucfirst($input->get('borrower_gender'))) {
      case 'Male':
      $gender=2;
      break;
      case 'Female':
      $gender=1;
      break;
      default:
      break;
    }

    switch ($input->get('id_proof_type')) {
      case  "PAN Card" :
      $type_of="01";
      break;
      case  "Voter Id" :
      $type_of="02";
      break;
      case  "Ration Card" :
      $type_of="03";
      break;
      case  "Passport" :
      $type_of="04";
      break;
      case  "Driving License" :
      $type_of="05";
      break;
      case  "Aadhaar Card" :
      $type_of="06";
      break;
      default:
      break;
    }


    switch ($input->get('residence_type')) {
      case  "Owned" :
      $res_code="01";
      break;
      case  "Rented" :
      $res_code="02";
      break;
      default:
      $res_code="02";
      break;
    }

    $query="http://122.169.102.98:8090/cibil?";
    $query.="name=".$input->get('borrower_first_name')." ".$input->get('borrower_last_name');
    $query.="&dob=".$dob;
    $query.="&gender=".$gender;
    $query.="&id=".$id;
    $query.="&type_of=".$type_of;
    $query.="&no=".$input->get('borrower_mobile_number');
    $query.="&id_no=".$input->get('id_proof_number');
    $query.="&address=".$input->get('address_line_1')." ".$input->get('address_line_2');
    $query.="&state=".$input->get('borrower_state');
    $query.="&pin=".$input->get('borrower_pincode');
    $query.="&category=04";
    $query.="&res_code=".$res_code;
    
    $client = new \GuzzleHttp\Client();
    
    try {
        $response = $client->request('GET',$query);
        $response = json_decode($response->getBody());
        $score = $response->score;
        
        if($score==NULL) $score = -100;
        Log::useFiles(storage_path().'/logs/cibil.log');
        Log::info('query='.$query.' || score='.$score);
        return $score;
    
    } catch (RequestException $e) {

        echo Psr7\str($e->getRequest());
        if ($e->hasResponse()) {
            echo Psr7\str($e->getResponse());
            Log::useFiles(storage_path().'/logs/cibil.log');
            Log::info('catch = '.$e->getResponse());
        }
        $score = -99;
        return $score;
    }
  }
}