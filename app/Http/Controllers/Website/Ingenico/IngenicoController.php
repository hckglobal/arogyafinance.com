<?php
namespace App\Http\Controllers\Website\Ingenico;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Application;
use Illuminate\Support\Facades\Hash;
use Config;
use App\Mandate;
use Carbon\Carbon;

class IngenicoController extends Controller
{
    /**
     * Request for NACH to Digio 
     * @param  [int]  $id   Application ID 
     * @return \Illuminate\Http\Response         
     */
    public function requestMandate($id, Request $input)
    {
        $application = Application::find($id);
        if($application->mandate) {
            $status = $this->getMandateStatus($application);
            return view('website.pages.dashboard.mandate_status', ['locale'=>'en','application'=>$application, 'borrower'=>$application->borrower,'status'=>$status]);
        } elseif($application->ingenicoMandate) {

            if($application->ingenicoMandate) {
                $status = $this->fetchMandateStatus($application, $input);
                return view('website.pages.dashboard.mandate_status', ['locale'=>'en','application'=>$application, 'borrower'=>$application->borrower,'status'=>$status]);
            }
        } else {
            $data = $this->generateHash($application);
            $locale = 'en';
            $redirect_url = env('APP_URL').'/user/process/emandate/'.$application->id;
            //$redirect_url = 'https://www.tekprocess.co.in/MerchantIntegrationClient/MerchantResponsePage.jsp';
            
            return view('website.pages.dashboard.apply_for_mandate', [
                'application' => $application, 'data' => $data, 'locale' => $locale,
                'redirect_url' => $redirect_url
            ]);
        }
    }

    /**
     * generate hash based on application detail 
     * @return string hashed md5                 
     */
    public function generateHash($application)
    {
        $merchantId = Config::get('ingenico.merchantId');
        $txnId = $application->reference_code;
        $amount = $application->approved_loan_emi;
        $itemId = Config::get('ingenico.scheme_code'); //scheme code
        $comAmt = Config::get('ingenico.comAmt'); // commission Amtount
        $accountNo = '';
        $consumerId = $application->reference_code;
        $consumerMobileNo = $application->borrower->mobile_number;
        $consumerEmailId = $application->borrower->email;
        $debitStartDate = Carbon::parse($application->getOriginal('valid_from'))->format('d-m-Y');
        $debitEndDate = Carbon::parse($application->getOriginal('valid_upto'))->format('d-m-Y');        
        $maxAmount = Config::get('ingenico.maxAmount');
        $amountType = Config::get('ingenico.amountType');
        $frequency = Config::get('ingenico.frequency');
        $cardNumber = '';
        $expMonth = '';
        $expYear = '';
        $cvvCode = '';
        $salt = Config::get('ingenico.salt');

        $hash = hash('sha256', $merchantId.'|'.$txnId.'|'.$amount.'|'.$accountNo.'|'.$consumerId.'|'.$consumerMobileNo.'|'.$consumerEmailId.'|'.$debitStartDate.'|'.$debitEndDate.'|'.$maxAmount.'|'.$amountType.'|'.$frequency.'|'.$cardNumber.'|'.$expMonth.'|'.$expYear.'|'.$cvvCode.'|'.$salt
        );
        return [
            'merchantId' => $merchantId,
            'txnId' => $txnId,
            'amount' => $amount,
            'itemId' => $itemId,
            'comAmt' => $comAmt,
            'accountNo' => $accountNo,
            'consumerId' => $consumerId,
            'consumerMobileNo' => $consumerMobileNo,
            'consumerEmailId' => $consumerEmailId,
            'debitStartDate' => $debitStartDate,
            'debitEndDate' => $debitEndDate,
            'maxAmount' => $maxAmount,
            'amountType' => $amountType,
            'frequency' => $frequency,
            'cardNumber' => $cardNumber,
            'expMonth' => $expMonth,
            'expYear' => $expYear,
            'cvvCode' => $cvvCode,
            'salt' => $salt,
            'hash' => $hash
        ];
    }


    /**
     * Check mandate status 
     * @return \Illuminate\Http\Response                 
     */
    public function checkMandateStatus(Request $input, $id)
    {
        $application = Application::find($id);
        $status = $this->fetchMandateStatus($application, $input);

        return view('website.pages.dashboard.mandate_status', ['locale'=>'en','application'=>$application, 'borrower'=>$application->borrower,'status'=>$status]);
    }

    /**
     * fetch mandate status
     *
     *@param Object Application
     */
    public function fetchMandateStatus($application, $input)
    {
        $status = '';
        if($input->msg) {
            $input_msg = explode('|',$input->msg);
            $txn_err_msg = $input_msg[2];
            if($txn_err_msg=="Mandate Initiated Successfully") {
                $data = $this->getMandateUpdatedStatus($application);
                $status = $txn_err_msg;
                $mandate = $data['mandate'];
                $mandate->message=$status;
                $mandate->save();
            } else {
                $data = $this->getMandateUpdatedStatus($application);
                $status = $txn_err_msg;
                $mandate = $data['mandate'];
                $mandate->message=$status;
                $mandate->save();

            }
        } else {
            $data = $this->getMandateUpdatedStatus($application);
            $status = $data['message'];
            $mandate = $data['mandate'];
            //$mandate->message=$status;
            $mandate->save();
        }
        return $mandate->status;
    }

    public function getMandateStatus($application)
    {
        switch ($application->mandate->partner_entity_status) {
            case 'register_success':
                $message = 'Accepted';
                break;
            case 'spo_reject':
                $message = 'Rejected';
                break;
            case 'register_failed':
                $message = 'Rejected';
                break;
            case 'partial':
                $message = 'Expired';
                break;                case '':
                if($application->mandate->status=='partial') {
                    $message = 'Pending';
                } elseif($application->mandate->status=='success') {
                    $message = 'Signing Success';
                }
                break;
            default:
                $message = 'In Progress';
                break;
        }
        
        return $message;
    }

    public function getMandateUpdatedStatus($application)
    {
        $mandate_status_url = Config::get('ingenico.mandate_status_url');
                
        $authentication = new \GuzzleHttp\Client(
            ['headers' => 
                ['Content-Type' => 'application/json']
            ]);
        
        $data = [
            'merchant' => [
                'identifier' => Config::get('ingenico.merchantId'),
            ],
            'payment' => [
                'instruction' => json_decode('{}'),
            ],
            'transaction' => [
                'deviceIdentifier' => 'S',
                'type' => '002',
                'currency' => 'INR',
                'identifier' => $application->reference_code,
                'subType' => '002',
                'requestType' => 'TSI'
            ],
            'consumer' => [
                'identifier' => $application->reference_code,
            ]
        ];
        
        $data = json_encode($data,JSON_HEX_APOS);

        $mandate_request = $authentication->request('POST',$mandate_status_url, 
                ['body' => $data]
        );

        $mandate_response = json_decode($mandate_request->getBody(), true);

        if ($mandate_response) {            
            if($application->ingenicoMandate) {
                $mandate = $application->ingenicoMandate;
                $mandate->status = $mandate_response['paymentMethod']['paymentTransaction']['statusMessage'];
                $mandate->partner_entity_status = $mandate_response['paymentMethod']['paymentTransaction']['statusCode'];
                $mandate->updated_at = Carbon::now();
                $mandate->umrn = $mandate_response['paymentMethod']['paymentTransaction']['bankReferenceIdentifier'];
                $mandate->save();
                $mandate->provider = 'ingenico';
                $message = $mandate->status;       
            } else {
                $mandate_data['application_id']=$application->id;
                $mandate_data['mandate_id']=$application->reference_code;
                $mandate_data['type']='CREATE';
                $mandate_data['status']=$mandate_response['paymentMethod']['paymentTransaction']['statusMessage'];
                $mandate_data['partner_entity_status']=$mandate_response['paymentMethod']['paymentTransaction']['statusCode'];
                $mandate_data['umrn'] = $mandate_response['paymentMethod']['paymentTransaction']['bankReferenceIdentifier'];

                $mandate_data['provider']='ingenico';
                $mandate = Mandate::create($mandate_data);
                $message = $mandate_data['status'];    
            }
        }

        return ['message' => $message, 'mandate' => $mandate];
    }

    /**
     * Request for NACH to ingenico again 
     * @param  [int]  $id   Application ID 
     * @return \Illuminate\Http\Response         
     */
    public function requestMandateAgain($id, Request $input)
    {
        $application = Application::find($id);

        $application->ingenicoMandate()->delete();

        $data = $this->generateHash($application);
        $locale = 'en';
        $redirect_url = env('APP_URL').'/user/process/emandate/'.$application->id;
        //$redirect_url = 'https://www.tekprocess.co.in/MerchantIntegrationClient/MerchantResponsePage.jsp';
        
        return view('website.pages.dashboard.apply_for_mandate', [
            'application' => $application, 'data' => $data, 'locale' => $locale,
            'redirect_url' => $redirect_url
        ]);
    }
}
