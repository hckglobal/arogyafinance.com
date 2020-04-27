<?php

namespace App\Http\Controllers\Website\Payment;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\SMSProvider;
use App\Traits\PaymentTrait;
use App\Helpers\Alerts;
use App\Borrower;
use App\Application;
use App\Transaction;
use Session;

class PaymentController extends Controller
{
    use PaymentTrait;

    /**
     *  payment for application
     *  @param  Request $request
     */
    public function makePayment(Request $request)
    {
        $SALT=env('PAYMENT_LIVE_SALT');
        $ENV =env('PAYMENT_LIVE_ENV');
        
        if (Session::has('borrower_id')) {
            $borrower = Borrower::find(Session::get('borrower_id'));
            $application = $borrower->application;
            $amount=$application->type=="card" ? 1000 :1180;
            $payment_details = $this->getPaymentDetails($borrower, $amount);
            //dd($payment_details);
            $result = $this->easepay_page($payment_details, $SALT, $ENV);
            //dd($result);
            if ($result['status']==1) {
                Session::put('transaction_number',$payment_details['txnid']);
                Session::put('amount',$payment_details['amount']);
                return redirect($result['data']);
            } else {
                //$this->sendPaymentFailureSMSToBorrower($borrower);
                Session::flash('message_card_failed', $result['data']);
                return redirect()->back();
            }
        }
    }

    /**
     *  payment for application type card
     *  @param  Request $input
     *  @param  string $type The type of application
     *  @return App\Application
     */
    public function askForPayment($id)
    {
        $application = Application::find($id);
        $borrower_id=$application->borrower->id;
        Session::put('borrower_id',$borrower_id);
        $view =  'website.pages.payment.ask_payment_'.$application->type;    
        return view($view)->with(['application'=>$application,'locale'=>'en']);        
    }

    /**
     *  payment success Page
     *  @param  Request $request
     *  @return view
     */
    public function getSuccessPage(Request $request)
    {
        
        $borrower = Borrower::find(Session::get('borrower_id'));
        $this->sendPaymentSuccessSMSToBorrower($borrower);
        $application = $borrower->application;
        $logs = $application->logs->where('field', 'status');
        Session::flash('message_card_success', 'Payment for card was successful');


        //if (!$request->has('login')) {
            $message = "Thank you for applying, our Finance Counselor will get in touch with you shortly. Kindly use '".$application->reference_code."' code for all further communication & to complete your application.";
            $next_url = '/';
            return view('website.pages.payment.redirect-page')->with(['message'=>$message,'next_url'=>$next_url,'locale'=>'en']);
        //}
        /*return view('website.pages.dashboard.dashboard')->with(['borrower'=>$borrower,'application'=>$application,'logs'=>$logs]);*/
    }

    /**
     *  payment failure Page
     *  @param  Request $request
     *  @return view
     */
    public function getFailurePage(Request $request)
    {
        $borrower = Borrower::find(Session::get('borrower_id'));
        $application = $borrower->application;
        $logs = $application->logs->where('field', 'status');
        Session::flash('message_card_failed', 'Payment for card failed');
        if (!$request->has('login')) {
            $message="Payment failed !";
            $next_url = '/';
            return view('website.pages.payment.redirect-page')->with(['message'=>$message,'next_url'=>$next_url,'success'=>false,'locale'=>'en']);
        }
        return view('website.pages.dashboard.dashboard')->with(['borrower'=>$borrower,'application'=>$application,'logs'=>$logs,'locale'=>'en']);
    }

    /**
     *  payment successful Page
     *  @param  Request $id
     *  @return view
     */
    public function getPaymentSuccessful($id)
    {
        $application=Application::find($id);
        $borrower = $application->borrower;
        $transaction_number=Session::get('transaction_number');
        $amount=Session::get('amount');
        $transaction = Transaction::create(['application_id'=>$application->id,
                                                'transaction_number'=>$transaction_number,
                                                'amount'=>$amount
                                                ]);
        $this->sendPaymentSuccessSMSToBorrower($borrower);
        Session::flash('message_card_success', 'Payment successful');
        $message ="Payment successful!! your transaction number is ".$application->transaction->transaction_number;
        $next_url = Session::has('login') ?  '/user/dashboard' : '/thank-you/'.$application->id;
               
        return view('website.pages.payment.payment_status')
              ->with(['message'=>$message,'next_url'=>$next_url,'application'=>$application,'locale'=>'en']);
    }

    /**
     *  payment failure Page
     *  @param  Request $id
     *  @return view
     */
    public function getPaymentFailed($id)
    {
        $application=Application::find($id);
        $borrower = $application->borrower;
        $this->sendPaymentFailedSMSToBorrower($borrower);
        Session::flash('message_card_failed', 'Payment failed');
        $message="Payment Failed!";
        $next_url = Session::has('login') ?  '/user/dashboard' : '/payment/ask-for-payment/'.$application->id;
        return view('website.pages.payment.payment_status')
              ->with(['message'=>$message,'next_url'=>$next_url,'application'=>$application,'locale'=>'en']);
    }

    /**
     * send payment successful message to borrower
     * param   $borrower id
     * return  SMS to borrower
     */
    public function sendPaymentSuccessSMSToBorrower($borrower)
    {
        $phone_number = $borrower->mobile_number;
        $application = $borrower->application;
        $message = Alerts::SMSPAYMENTSUCCESS($application);
        SMSProvider::send($phone_number, $message);
    }

    /**
     * send payment failure message to borrower
     * param   $borrower id
     * return  SMS to borrower
     */
    public function sendPaymentFailedSMSToBorrower($borrower)
    {
        $phone_number = $borrower->mobile_number;
        $application = $borrower->application;
        $message = Alerts::SMSPAYMENTFAILURE($application);
        SMSProvider::send($phone_number, $message);
    }
}
