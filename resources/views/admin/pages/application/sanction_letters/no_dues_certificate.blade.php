@extends('admin.pages.application.sanction_letters.partial.layout')

@section('content')
    <h3 class="title uc tc" style="text-align:center; margin-top: 10px"><u>No Dues Certificate</u></h3>
    <h5 style="text-align:right; margin-right: 10px">{{Carbon\Carbon::now()->format('j F, Y')}}</h5>

    <p style="margin-top:10px;">PIN: <b>{{$borrower->application->pin_number}}</b> </p>
    @if($borrower->application->card_no)
    <p style="margin-top:10px;">Arogya Card No: <b>{{$borrower->application->card_no}} </b></p>
    @endif   
    <p style="margin-top:10px;">Patient's Name: <b>{{strtoupper($borrower->application->patient->first_name)}}
					    {{strtoupper($borrower->application->patient->middle_name)}}
					    {{strtoupper($borrower->application->patient->last_name)}}
     </b>
     </p><br>
    <p>To,
    	 <b><i><br>{{strtoupper($borrower->first_name)}} {{strtoupper($borrower->middle_name)}} {{strtoupper($borrower->last_name)}}</i>
    	 	<br>{{ucwords(strtolower($borrower->address_line_1))}},
    	 	@if($borrower->address_line_2)
    	 	<br>{{ucwords(strtolower($borrower->address_line_2))}}
    	 	@endif
    	 <br>{{ucwords(strtolower($borrower->city))}}, {{ucwords(strtolower($borrower->state))}} - {{strtoupper($borrower->pincode)}}</b>
    </p>
    <br>
	<p style="margin-top:10px;">
    	Dear Customer,
    </p>
    <p style="margin-top:10px;">
    	We are pleased to inform that the EMIs due from you, as per finance availed on {{Carbon\Carbon::parse($borrower->application->getOriginal('disbursement_date'))->format('d/m/Y')}} (account: <b>{{$borrower->application->pin_number}}</b>),
    </p>
    <p style="margin-top:10px;">
        has been completed as on {{Carbon\Carbon::parse($borrower->application->getOriginal('closer_date'))->format('d/m/Y')}} and that you have no further dues whatsoever.
    </p> <br>
    <p>
    	Please acknowledge the receipt of this letter. 
    </p><br>
	<p>
		We value your relationship with us and assure you of our best services always.
	</p>
	<p style="margin-top:15px">
		Best regards,
        <br>
        
		<br>
		
        <img src="assets/images/sanction_letter/jay_sign.png"><br>
                 
		Authorized Signatory <br>
	</p>
@endsection