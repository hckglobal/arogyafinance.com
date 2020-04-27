<?php

use Mail;

class EmailNotification {

	 public static function CAT1LOANAPPROVAL($borrower) {
	 	if ($borrower->email == "")  {
	 		return false;
	 	}else{
	 	$success =  Mail::send('emails.user.cat1_loan_approval', 
	 		                  ['borrower' => $borrower],
						        function ($mail) use($borrower)
						        {
						            $mail
						            ->to($borrower->email, $borrower->first_name . ' ' . $borrower->last_name)
						            ->subject('Thank You for applying to Arogya Finance');
						        }); 
        return $success;	
	 	}
        
	 } 

	 public static function CAT1CARDAPPROVAL($borrower) {
	 	if ($borrower->email == "")  {
	 		return false;
	 	}else{
	 	$success =  Mail::send('emails.user.cat1_card_approval', 
	 		                  ['borrower' => $borrower],
						        function ($mail) use($borrower)
						        {
						            $mail
						            ->to($borrower->email, $borrower->first_name . ' ' . $borrower->last_name)
						            ->subject('Thank You for applying to Arogya Finance');
						        }); 
        return $success;	
	 	}
	 }

	 public static function ALLCATLOANAPPLICATION($borrower) {
	 	if ($borrower->email == "")  {
	 		return false;
	 	}else{
	 	$success =  Mail::send('emails.user.all_cat_loan_application', 
	 		                  ['borrower' => $borrower],
						        function ($mail) use($borrower)
						        {
						            $mail
						            ->to($borrower->email, $borrower->first_name . ' ' . $borrower->last_name)
						            ->subject('Thank You for applying to Arogya Finance');
						        }); 
        return $success;
        }	
	 }
	  public static function ALLCATCARDAPPLICATION($borrower) {
	  		if ($borrower->email == "")  {
	 		return false;
	 	}else{
	 	$success =  Mail::send('emails.user.all_cat_card_application', 
	 		                  ['borrower' => $borrower],
						        function ($mail) use($borrower)
						        {
						            $mail
						            ->to($borrower->email, $borrower->first_name . ' ' . $borrower->last_name)
						            ->subject('Thank You for applying to Arogya Finance');
						        }); 
        return $success;	
	  }

	}

	  public static function ONLOANSANCTION($borrower) {
		  	if ($borrower->email == "")  {
		 		return false;
		 	}else{
		 	$success =  Mail::send('emails.user.on_loan_sanction', 
		 		                  ['borrower' => $borrower],
							        function ($mail) use($borrower)
							        {
							            $mail
							            ->to($borrower->email, $borrower->first_name . ' ' . $borrower->last_name)
							            ->subject('Arogya Finance Medical Loan Sanctioned for Reference No.:'.$borrower->application->reference_code);
							        }); 
	        return $success;	
		  }
	  }
	  public static function ONLOANDISBURSAL($borrower) {
	  		if ($borrower->email == "")  {
		 		return false;
		 	}else{
		 	$success =  Mail::send('emails.user.on_loan_disbursal', 
		 		                  ['borrower' => $borrower],
							        function ($mail) use($borrower)
							        {
							            $mail
							            ->to($borrower->email, $borrower->first_name . ' ' . $borrower->last_name)
							            ->subject('Medical Loan disbursed for reference no:'.$borrower->application->reference_code);
							        }); 
	        return $success;	
		  }
	  }
	  public static function ONPARTIALLOANDISBURSAL($borrower) {
	  		if ($borrower->email == "")  {
		 		return false;
		 	}else{
		 	$success =  Mail::send('emails.user.on_partial_loan_disbursal', 
		 		                  ['borrower' => $borrower],
							        function ($mail) use($borrower)
							        {
							            $mail
							            ->to($borrower->email, $borrower->first_name . ' ' . $borrower->last_name)
							            ->subject('Medical Loan (partial disbursement) for reference no:'.$borrower->application->reference_code);
							        }); 
	        return $success;	
		  }
	  }

	  public static function ONCOMPLETELOANDISBURSEMENTINCONTINUATION($borrower) {
	  		if ($borrower->email == "")  {
		 		return false;
		 	}else{
		 	$success =  Mail::send('emails.user.on_complete_loan_disbursement_in_continuation', 
		 		                  ['borrower' => $borrower],
							        function ($mail) use($borrower)
							        {
							            $mail
							            ->to($borrower->email, $borrower->first_name . ' ' . $borrower->last_name)
							            ->subject('Medical Loan (Complete disbursement) for reference no:'.$borrower->application->reference_code);
							        }); 
	        return $success;	
		  }
	  }	  
	  public static function MESSAGEBEFOREEMIDUEDATE($borrower) {
	  		if ($borrower->email == "")  {
		 		return false;
		 	}else{
		 	$success =  Mail::send('emails.user.message_before_emi_due_date', 
		 		                  ['borrower' => $borrower],
							        function ($mail) use($borrower)
							        {
							            $mail
							            ->to($borrower->email, $borrower->first_name . ' ' . $borrower->last_name)
							            ->subject('Arogya Finance EMI Payment Reminder');
							        }); 
	        return $success;	
		  }	
	  }

	  public static function MESSAGEAFTERDUEDATE($borrower) {
	  		if ($borrower->email == "")  {
		 		return false;
		 	}else{
		 	$success =  Mail::send('emails.user.message_after_emi_due_date', 
		 		                  ['borrower' => $borrower],
							        function ($mail) use($borrower)
							        {
							            $mail
							            ->to($borrower->email, $borrower->first_name . ' ' . $borrower->last_name)
							            ->subject('Reminder - Outstanding EMI');
							        }); 
	        return $success;	
		  }	
	  } 

}