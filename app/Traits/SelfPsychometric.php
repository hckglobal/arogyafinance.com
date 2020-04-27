<?php

namespace App\Traits;
use App\Helpers\SMSProvider;
use App\Helpers\Alerts;
use App\Application;

trait SelfPsychometric {

    /**
     * check if borrower is applying for the psychometric test.
     * @param Int $id Application id
     * @param Int $input form input
     * @return \Illuminate\Http\Response
     */
    public function checkIfBorrowerIsApplyingForPsychometricTest($id, $input)
    {
        //if borrower is applying for psychometric test allow to apply for test.
        if($input->self_borrower=="no") {
            // send sms notification to borrower.
            $this->sendSMSToBorrower($id);
            return false;
        } else {
            return true;
        }
    }

    /**
     * Send Sms to borrower
     * @param  Int $id App\Application $id 
     * @return \Illuminate\Http\Response
     */
    public function sendSMSToBorrower($id) 
    {
        $application = Application::find($id);
        $borrower = $application->borrowers()->first();
        $phone_number = $borrower->mobile_number;
        $message = Alerts::WELCOMEMESSAGEWITHOUTPSYCHOMETRICTESTBORROWER($application);

        SMSProvider::send($phone_number,$message);
    }
}