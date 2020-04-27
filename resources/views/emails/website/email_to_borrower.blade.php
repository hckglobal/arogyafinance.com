@if($residence_type[0]=='Owned'|| $residence_type[0]=='Parental')
    @if ($application->requireTest()=='No' && $application->remainingDocumentsCount()==0)
        @if($application->type=='loan') {
            Dear {{$application->borrower->first_name}} {{$application->borrower->las_name}},<br>
			Congratulations! Your Medical Loan of Rs. {{$application->calculated_loan_amount}} is approved.
			A formal Sanction Letter will be sent to you after verifying the documents uploaded. For any other details, please feel free to write to us on info@arogyafinance.com or call us on our helpline +919769205032 (10 AM to 6 PM Monday to Saturday and excluding public holidays).<br>

			Best regards,<br>

			Team Arogya Finance
        @else
            Dear {{$application->borrower->first_name}} {{$application->borrower->las_name}},<br>
			We would like to thank you for Arogya Card application. Your Arogya Card with Pre-approved limit of Rs. {{$application->calculated_loan_amount}} has been Approved. A formal Sanction Letter will be sent after verifying the documents uploaded. For any other details, please feel free to write to us on info@arogyafinance.com or call us on our helpline +919769205032 (10 AM to 6 PM Monday to Saturday and excluding public holidays).<br>

			Best regards,<br>

			Team Arogya Finance
        @endif
    } elseif ($application->requireTest()=='Yes' && $application->category()=='Two' && 
        $application->remainingDocumentsCount()==0) {
        @if($application->type=='loan') {
            Dear {{$application->borrower->first_name}} {{$application->borrower->las_name}},<br>
			Congratulations! Your Medical Loan of Rs. {{$application->calculated_loan_amount}} is approved.
			A formal Sanction Letter will be sent to you after verifying the documents uploaded. For any other details, please feel free to write to us on info@arogyafinance.com or call us on our helpline +919769205032 (10 AM to 6 PM Monday to Saturday and excluding public holidays).<br>

			Best regards,<br>

			Team Arogya Finance
        @else
            Dear {{$application->borrower->first_name}} {{$application->borrower->las_name}},<br>
			We would like to thank you for Arogya Card application. Your Arogya Card with Pre-approved limit of Rs. {{$application->calculated_loan_amount}} has been Approved. A formal Sanction Letter will be sent after verifying the documents uploaded. For any other details, please feel free to write to us on info@arogyafinance.com or call us on our helpline +919769205032 (10 AM to 6 PM Monday to Saturday and excluding public holidays).<br>

			Best regards,<br>

			Team Arogya Finance
        @endif
    @else 
    Thank you for applying, our Finance Counselor will get in touch with you shortly. Kindly use {{$application->reference_code}} code for all further communication & to complete your application
    @endif
@else
Thank you for applying, our Finance Counselor will get in touch with you shortly. Kindly use {{$application->reference_code}} code for all further communication & to complete your application
@endif