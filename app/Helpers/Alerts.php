<?php 
namespace App\Helpers;

/**
*  List of all alerts in the system
*/
class Alerts
{
	
	const CAT_ONE_THANKYOU_MESSAGE = 'Thank you for uploading the documents, after verification of the documents submitted, a formal sanction letter will be issued to you via email & post.';

	const CAT_TWO_THANKYOU_MESSAGE = 'Thank you for your application, your application requires additional interaction. Our finance counselor will get in touch with you shortly to complete the formalities.';

	const CAT_THREE_THANKYOU_MESSAGE ='Thank you for your application, your application requires additional interaction. Our finance counselor will get in touch with you shortly to complete the formalities.';

	const DOCUMENT_UPLOAD_MESSAGE = 'Thank you for uploading your documents, our financial counsellor will get in touch with you shortly.';

	/*====================================
	=            User Section            =
	====================================*/
	
	public static function SMSUSERDOCUPLOAD($application)
	{
		return "Dear ".$application->borrower->first_name.". Thank you for uploading the documents, after verification of the documents submitted, a formal sanction letter will be issued to you via email & post. ";
	}
	
	public function SMSUSERAPPLICATION($application)
	{
		return "Dear ".$application->borrower->first_name.". Thank you for your application, your application requires additional interaction. Our finance counselor will get in touch with you shortly to complete the formalities.";
	}

	public static function SMSSTATUSAPPLICATION($application)
	{
		return "Dear ".$application->borrower->first_name.". Your status is ".$application->status.".";
	}


	/*=====  End of User Section  ======*/

	public static function WELCOMEMESSAGEALLCATEGORIESLOAN($application) {
		return "Thank You for applying, our finance counselor will get in touch with you shortly. Use $application->reference_code for all further communication & to complete your application.";

	}

	public static function WELCOMEMESSAGECAT1LOAN($application) {
		return "Congratulations! Arogya Loan application of ".ucfirst($application->borrower->first_name)." ".ucfirst($application->borrower->last_name)." for ₹ ".$application->calculated_loan_amount." is Approved, in principle. Our Finance Counsellor will call you for a personal discussion and a formal binding Sanction Letter will follow. You may login using reference code ".strtoupper($application->reference_code).".";

	}

	public static function WELCOMEMESSAGEFORALLCATEGORIESCARD($application) {
		return "Thank you for applying, our Finance Counselor will get in touch with you shortly. Kindly use '".$application->reference_code."' code for all further communication & to complete your application.";
	}

	public static function WELCOMEMESSAGECAT1CARD($application) {
		return "Congratulations! Arogya Card application of ".ucfirst($application->borrower->first_name)." ".ucfirst($application->borrower->last_name)." for ₹ ".$application->calculated_loan_amount." is Approved, in principle. Our Finance Counsellor will call you for a personal discussion and a formal binding Sanction Letter will follow. You may login using reference code ".strtoupper($application->reference_code).".";
	}

	public static function MESSAGEONLOANSANCTION($application) {
		return "Congratulations! Dear customer, your Medical Loan as per Application No. $application->pin_number is Sanctioned.";
	}
	public static function MESSAGEONLOANDISBURSAL($application)
	{
		return "Congratulations! Dear Customer, an amount of ₹. $application->approved_loan_amount has been Disbursed against your Medical Loan Application No. $application->pin_number";
	}

	public static function MESSAGEONPARTIALLOANDISBURSAL($application) {
		return "Congratulations! Dear Customer, an amount of ₹. $application->approved_loan_amount has been partially Disbursed against your Medical Loan Application No. $application->reference_code.";
	}

	public static function MESSAGEONCOMPLETELOANDISBURSAL($application) {
		return "Congratulations! Dear Customer, an amount of ₹. $application->approved_loan_amount has been Disbursed against your Medical Loan application no. $application->reference_code as complete disbursement.";
	}
	/*Three days before the EMI due date*/
	public static function MESSAGEBEFOREEMIDUEDATE ($application) {
		return "Dear Customer, EMI of ₹. $application->approved_loan_emi for your Medical Loan $application->id is due on 17/07/2017. Kindly pay before the due date to avoid any additional charges. Please ignore if already paid.";
	}
	/*After 5 days from the due date if 10% of the EMI amount is outstanding and only once in a month*/
	public static function MESSAGEAFTERDUEDATE($application) {
		return "Dear Customer, EMI of ₹. $application->approved_loan_emi for your Medical Loan $application->id was due on 17/07/2017. Kindly make the payment immediately. Please ignore if already paid.";
	}

	public static function SMSOTP($otp)
	{
		return "$otp is your One-Time Password (OTP). By using OTP; You agree to our Terms & Conditions as on www.arogyafinance.com. Kindly contact 9769205032 for any queries.";
	}

	public static function SMSPAYMENTSUCCESS($application) {
		return "Payment for Arogya ".$application->type." was sucessfully made \nfor amount ".$application->transaction->amount." rupees \nwith transaction number ".$application->transaction->transaction_number."\nThank You!";
	}
	public static function SMSPAYMENTFAILURE($application) {
		if($application->transaction!=null) {
			$amount = $application->transaction->amount;
		} elseif($application->type=='loan') {
			$amount = 1180;
		} else {
			$amount = 1000;
		}
		return "Sorry! \nPayment for Arogya ".$application->type." \nfor amount ".$amount." failed.";
	}

	public static function WELCOMEMESSAGEALLOTHERCATEGORIES($application) {
		return "Thank you for applying, our Finance Counselor will get in touch with you shortly. Kindly use '".$application->reference_code."' code for all further communication & to complete your application.";
	}

	public static function WELCOMEMESSAGEWITHOUTPSYCHOMETRICTESTBORROWER($application) {
		return "Dear ".$application->borrower->first_name." ".$application->borrower->last_name.", please use the below mentioned link and login to take the psychometric assessment. Please note only the borrower can give this assessment. Link: ".env('APP_URL')."/login  Use reference no: ".$application->reference_code;
	}

	public static function WELCOMEMESSAGEWITHOUTPSYCHOMETRICTESTFC($application) {
		return "Thank you for submitting your application with reference code: ".strtoupper($application->reference_code).", we have sent a link to the borrower's mobile number for further assessment.";
	}

	public static function EMINotificationFourDaysPrior($application, $current_emi_date) {
		return "Dear ".$application->borrower->first_name." ".$application->borrower->last_name." your EMI of Rs. ".$application->approved_loan_emi." for your Medical Loan ".$application->pin_number." is due on ".$current_emi_date.". Kindly pay before the due date to avoid any additional charges. Please ignore, if already paid.";
	}

	public static function ApplicationNotificationToFCAndCM($application) {
		return ucfirst($application->type)." application of ".$application->borrower->first_name." ".$application->borrower->last_name." with reference code: ".strtoupper($application->reference_code)." has been approved in principle of ₹ ".$application->calculated_loan_amount.". Kindly visit https://arogyafinance.com/admin/application/".$application->type."/detail/".$application->id." for more details.";
	}

	public static function ApplicationNotificationToPartner($application) {
		return ucfirst($application->type)." application of ".$application->borrower->first_name." ".$application->borrower->last_name." with reference code: ".strtoupper($application->reference_code)." has been approved in principle of ₹ ".$application->calculated_loan_amount.". Kindly visit https://arogyafinance.com/admin/application/".$application->type."/detail/".$application->id." for more details.";
	}
}