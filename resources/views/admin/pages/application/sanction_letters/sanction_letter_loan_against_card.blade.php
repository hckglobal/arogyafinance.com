@extends('admin.pages.application.sanction_letters.partial.layout')

@section('content')
    <h5 style="text-align:right; margin-right: 10px">{{$borrower->application->sanction_date}}</h5>

    <p style="margin-top:10px;">Reference: <b>{{$borrower->application->pin_number}}</b> </p>
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
    <p>
    	<center><b>Subject : Sanction Letter</b></center>
    </p>
	<p style="margin-top:10px;">
    	Dear Customer,
    </p>
    <p style="margin-top:10px;">
    	We are pleased to inform that you are eligible for a Loan from us as per following terms:
    </p>
    <p>
    	<table  cellspacing="0" class="compact">
            <tbody>
                <tr>
                    <td>1.</td>
                    <td>Date of Loan Application</td>
                    <td>: </td>
                    <td>{{$borrower->application->created_at}}</td>
                </tr>
                <tr>
                    <td>2.</td>
                    <td>Loan Amount Sanctioned</td>
                    <td>: </td>
                    <td><span style="font-family: DejaVu Sans; sans-serif;">&#8377; </span>{{$borrower->application->approved_loan_amount}}/- <b>(Rupees {{App\Helpers\Helpers::getIndianCurrency($borrower->application->approved_loan_amount).' Only'}})</td>
                </tr>
                <tr>
                    <td>3.</td>
                    <td>Equated Monthly Installment (EMI)</td>
                    <td>: </td>
                    <td><span style="font-family: DejaVu Sans; sans-serif;">&#8377; </span>{{$borrower->application->approved_loan_emi}}/- <b>(Rupees {{App\Helpers\Helpers::getIndianCurrency($borrower->application->approved_loan_emi).' Only'}})</td>
                </tr>
                <tr>
                    <td>4.</td>
                    <td>Tenure/ No of Advance EMIs</td>
                    <td>: </td>
                    <td>{{strtoupper($borrower->application->approved_loan_tenure)}} Months / {{strtoupper($borrower->application->advance_emi)}} Months </td>
                </tr>
                <tr>
                    <td>5.</td>
                    <td>Rate of Interest</td>
                    <td>: </td>
                    <td>{{round($borrower->application->interest_rate,2)}}% flat per year ({{round($borrower->application->effective_interest_rate,2)}}% on reducing balance)</td>
                </tr>
                <tr>
                    <td>6.</td>
                    <td>Charges<br>(GST @18% extra)</td>
                    <td>: </td>
                    <td><span style="font-family: DejaVu Sans; sans-serif;">&#8377; </span>{{$borrower->application->documentation_charge}} as Documentation Charges.<br>
                        {{$borrower->application->processing_fee}} % of the Loan Amount as Processing Fees.</td>
                </tr>
                <tr>
                    <td>7.</td>
                    <td>Disbursement to (as requested in the Loan Application)</td>
                    <td>: </td>
                    <td>{{strtoupper($borrower->application->approved_hospital_name)}} </td>
                 </tr>
                <tr>
                    <td valign="top">8.</td>
                    <td valign="top">Loan Documents</td>
                    <td valign="top">: </td>
                    <td valign="top">
                        (i) Demand Promissory Note<br>
                        (ii) Most Important Document (MID)<br>
                        (iii) Receipt<br>
                        (iv) Cheque Submission Letter<br>
                        (v) Repayment Instruments (Cheques/ECS/ACH) <br><br>
                    </td>
                </tr>                             
            </tbody>
    </table> 
    </p>
    <p>
    	With respect to the aforesaid Loan Sanction if you need any further details, please feel free to contact us. 
	</p><br>
    <p>
    	Please note that this letter is valid only for a period of 1 month from the date of this letter and will lapse unless the pending documents are received within 4 days of this sanction letter.
	</p><br>
	<p>
		We value our relationship with you and assure you the best services always.
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
	<p>	You are requested to send us copy of hospital bill of the
        patient for treatment.
	 </p>
	 
@endsection