@extends('admin.pages.application.sanction_letters.partial.layout')

@section('content')
    <h5 style="text-align:right;">{{$borrower->application->sanction_date}}</h5>

    <p style="margin-top:10px;">Reference: <b>{{$borrower->application->pin_number}}</b> </p>
    @if($borrower->application->card_no)
    <p style="margin-top:10px;">Arogya Card No: <b>{{$borrower->application->card_no}} </b><br><br></p>
    @endif
    <p>To,
         <b><i><br>{{strtoupper($borrower->first_name)}} {{strtoupper($borrower->middle_name)}} {{strtoupper($borrower->last_name)}}</i>
            <br>{{ucwords(strtolower($borrower->address_line_1))}},
            @if($borrower->address_line_2)
            <br>{{ucwords(strtolower($borrower->address_line_2))}}
            @endif
         <br>{{ucwords(strtolower($borrower->city))}}, {{ucwords(strtolower($borrower->state))}} - {{strtoupper($borrower->pincode)}}</b>
    </p><br><br>
    <p>
        <center><b>Subject : Sanction Letter</b></center>
    </p>
    <p style="margin-top:10px;">
        Dear Customer,
    </p>
    <p style="margin-top:10px;">
    	We are pleased to inform you that a loan facility of <span style="font-family: DejaVu Sans; sans-serif;">&#8377; </span>{{$borrower->application->approved_loan_amount}}/- <b>(Rupees {{App\Helpers\Helpers::getIndianCurrency($borrower->application->approved_loan_amount).' Only'}})</b>
		for a period of <b>{{strtoupper($borrower->application->approved_loan_tenure)}}</b> months has been approved.  The EMI amount is <span style="font-family: DejaVu Sans; sans-serif;">&#8377; </span>{{$borrower->application->approved_loan_emi}}/- <b>(Rupees {{App\Helpers\Helpers::getIndianCurrency($borrower->application->approved_loan_emi).' Only'}})</b> <br> <br> As per your instructions and on your behalf, the loan amount will be disbursed directly to<b> {{strtoupper($borrower->application->approved_hospital_name)}}</b> upon completion of surgery using a Medtronic Device.
		<br> <br>
		Please note that this letter is valid only for a period of 3 months from the date of this letter. <br> <br>
		We value your relationship with us and assure you of our best services always.
	</p>
    <p style="margin-top:15px">
        Yours Truly,
        <br><br>
        <b>For Ramtirth Leasing and Finance Company Private Limited</b>
        <br>
        
        <img src="assets/images/sanction_letter/jay_sign.png"><br>
                 
        Authorized Signatory <br>
        <b>Arogya Finance</b>
    </p>
    <p>
        CC to  :<b>{{strtoupper($borrower->application->approved_hospital_name)}}</b>. 
    </p>
    <p> You are requested to send us copy of hospital bill of the
        patient for treatment.
     </p>
     
@endsection