<!DOCTYPE html>
<html>
<head>
    <title>Example</title>
</head>
<body style="margin:2%">
	<br>
	<br>
	<br>
	<br>
	<br>
    <h1 style="text:underlined; text-align:center;"><u>Sanction Letter</u></h1>
    <h3 style="text-align:right;">Date: {{$date->format('j M, Y')}}</h3>
    <h4 style="margin-top:10px;">Patient Identification No: {{$borrower->application->pin_number}}</h4>
    <h4 style="margin-top:10px;">Patient's Name: {{$borrower->application->patient->first_name}} {{$borrower->application->patient->middle_name}} {{$borrower->application->patient->last_name}}</h4> 
    <p>To,
    	 <br>{{$borrower->first_name}} {{$borrower->last_name}},<br>{{$borrower->address_line_1}},<br>{{$borrower->address_line_2}},
    	 <br>{{$borrower->city}}, {{$borrower->state}} - {{$borrower->pincode}}
     </p>
   
    <p style="margin-top:10px;">
    	Dear Customer,
    </p>
    <p style="margin-top:10px;">
    	We are pleased to inform you that a loan facility of <span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>{{$borrower->application->approved_loan_amount}}/- <b>(Rupees {{numbers2words($borrower->application->approved_loan_amount)}} Only) </b> 
		for a period of <b>{{$borrower->application->approved_loan_tenure}}</b> months has been approved.  The EMI amount is <span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>{{$borrower->application->approved_loan_emi}}/- <b>(Rupees {{numbers2words($borrower->application->approved_loan_emi)}} Only).</b> <br> <br> As per your instructions and on your behalf, the loan amount will be disbursed directly to<b> {{$borrower->application->approved_hospital_name}}</b>
		@if(Input::get('type')=="medtronic") upon completion of surgery using a Medtronic Device.
		@endif
		<br> <br>
		Please note that this letter is valid only for a period of 3 months from the date of this letter. <br> <br>
		We value your relationship with us and assure you of our best services always.
	</p>
	<br>
	<br>
	<p style="margin-top:15px">
		Best Regards,
		<br>
		<br>
		<br>
		Authorized Signatory <br>
		<b>Arogya Finance</b>
	</p>
	<br>
	<p>
		CC to  <b>{{$borrower->application->approved_hospital_name}}</b>. You are requested to send us copy of hospital bill of the
        patient for treatment.
	 </p>
	

	
</body>
</html>>