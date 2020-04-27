<?php

namespace App\Helpers;
use Log;
use Exception;

class SMSProvider 
{
    public static function send($phone_number,$message)
    {
        $client = new \GuzzleHttp\Client();
        
        $SMSApi = "http://sms.businesskarma.in/api/v2/sms/send?";
        $SMSApi .= "access_token=6eee03bf4d0d7c970758f3b33795f1b1&";
        $SMSApi .= "message=".urlencode($message);
        $SMSApi .= "&sender=AROGYA&to=".$phone_number."&service=T";
        
        if(env('ENABLE_SMS'))
        {
            try {
                $request = $client->request('GET',$SMSApi);
                $response = json_decode($request->getBody(),true);

                if($request->getStatusCode() != 200) {
                    throw new Exception('Error in Sending SMS');
                }
            }
            catch(Exception $e) {
                Log::error($e->getMessage());
            }
            //file_get_contents($SMSApi);   
        }
    }
}

