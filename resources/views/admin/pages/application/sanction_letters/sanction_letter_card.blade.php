@extends('admin.pages.application.sanction_letters.partial.layout')
@section('content')
    <h4 style="text-align:right;">{{$date}}</h4>
    <p>To,
         <b><i><br>{{strtoupper($borrower->first_name)}} {{strtoupper($borrower->middle_name)}} {{strtoupper($borrower->last_name)}}</i>
            <br>{{ucwords(strtolower($borrower->address_line_1))}}
            @if($borrower->address_line_2)
            ,<br>{{ucwords(strtolower($borrower->address_line_2))}}
            @endif,
         <br>{{ucwords(strtolower($borrower->city))}}, {{ucwords(strtolower($borrower->state))}} - {{strtoupper($borrower->pincode)}}</b>
    </p>
    <p>
        <b>
            Phone No: {{$borrower->mobile_number}}
        </b>
    </p>
    <h4>Arogya Card No:{{$borrower->application->card_no}}</h4>
    <p style="margin-top:8px;">
        Dear <b>{{ucFirst($borrower->first_name)}} {{ucFirst($borrower->middle_name)}} {{ucFirst($borrower->last_name)}}</b>,<br>
        <br>We are pleased to welcome you as a privileged owner of an Arogya Card. 
            You can avail the medical loan anytime during the validity period to meet any of your 
            family’s hospitalization needs.
        </p>
    <p style="margin-top:8px;">
        Details of your Arogya Card are:
        <br>
        <ul>
            <li>Date of Application: {{$borrower->created_at}}</li>
            <br>
            <li>Loan Amount approved in-principle (in one or more occasions): <span style="font-family: DejaVu Sans; sans-serif;">&#8377; </span>{{$borrower->application->approved_loan_amount}}/- <b>(Rupees {{App\Helpers\Helpers::getIndianCurrency($borrower->application->approved_loan_amount).' Only'}})</b></li>
            <br>
            <li>Valid upto: {{$borrower->application->valid_upto}}</li>
            <br>
            @if($borrower->application->familyMembers!=null)
            <li>Name of family members covered:</li>
                <table>
                    <tr>
                        <td>
                            <ol type="a" start="1">
                            @foreach($borrower->application->familyMembers as $familyMember)   
                                <li float="left">{{ucfirst($familyMember->first_name)}} {{ucfirst($familyMember->last_name)}} - {{ucfirst($familyMember->relation)}}</li>
                           @endforeach
                            </ol>
                        </td>
                    </tr>
                </table>
           
            @endif
        
            <li>Tenure of Loan disbursed: Maximum 36 months.</li>
            <br>
            <li>Interest*: 15% (flat) / 26% (reducing) per annum.<br>
             In case of partner hospitals** 12% (flat) / 21.25% (reducing) per annum.</li>
            <br>
            <li>Processing fee*: 2% of Loan Amount.</li>
            <br>
        </ul>
        <p>
        This in-principle approval is subject to submission of the required documents before 
        disbursement, including a demand promissory note and postdated cheques, by you and your 
        acceptance of the terms and conditions laid down by the company which are on
        <span style="color:blue;">www.arogyafinance.com</span><br>
        <br>If the card holder is undergoing treatment, a co-borrower will be required and if the borrower is staying in a rented house, a guarantor will be required at the time of availing the medical loan.<br>
        <br>*Applicable at the time of disbursement <br>
        **List subject to change,please refer <span style="color:blue;">www.arogyafinance.com</span> for the list.
    </p>
    <p style="margin-top:15px">
        We look forward to a mutually rewarding relationship.        
    </p>
    <p style="margin-top:15px">
        Yours Truly,
        <br>
        <b>For Ramtirth Leasing and Finance Company Private Limited</b>
        <br>
        
        <img src="assets/images/sanction_letter/jay_sign.png"><br>
                 
        Authorized Signatory <br>
        <b>Arogya Finance</b>
    </p>
    
@endsection
