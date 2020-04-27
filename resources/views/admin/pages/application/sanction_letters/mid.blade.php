@extends('admin.pages.application.sanction_letters.partial.layout_blank')

<header class="letterhead">
    <h3>
        RAMTIRTH LEASING AND FINANCE COMPANY PRIVATE LIMITED
    </h3>
    <p>
        Registered Office: 31, Mystique, Plot No. 129, St. Cyril Road, Off Turner Road, Bandra (West), Mumbai - 400 050. 
    </p>
    <p> 
        Corporate Office: 102, Meadows, Sahar Plaza, Andheri - Kurla Road, J.B. Nagar, Andheri (East), Mumbai - 400 059.
    </p>
</header>

@section('content')
    <table>
        <tr>
             <td>
                 Date: {{$date}} 
             </td>
             <td>
                 Reference:  {{$borrower->application->pin_number}}
             </td>
             <td>
                 Loan Sanction Date: {{$borrower->application->sanction_date}}
             </td>
             <td>
                 Place: {{$borrower->application->location ? $borrower->application->location->name : ''}}
             </td>
        </tr>
    </table>

    <h3 class="title uc tc">MOST IMPORTANT DOCUMENT (MID)</h3>
    <p class="tc">(To be executed in duplicate and one copy to be given to the Customer)</p>


    <table border="1" bordercolor="black" cellspacing="0" class="compact" style="table-layout: fixed;">
            <tbody>
                <tr>
                    @if($borrower->application->type=='card')
                        @if($minor==false)   
                        <td rowspan="{{$application->borrowers->count()+1}}" class="custom-td-width">1.</td>
                        @else
                        <td rowspan="{{$application->borrowers->count()}}" class="custom-td-width">1.</td>
                        @endif
                    @endif

                    @if($borrower->application->type=='loan')
                        @if(!$application->self_patient==1)
                            @if($minor==false)   
                            <td rowspan="{{$application->borrowers->count()+2}}" class="custom-td-width">1.</td>
                            @else
                            <td rowspan="{{$application->borrowers->count()+1}}" class="custom-td-width">1.</td>
                            @endif
                        @else
                            @if($minor==false)
                                <td rowspan="{{$application->borrowers->count()+1}}" class="custom-td-width">1.</td>
                            @else
                                <td rowspan="{{$application->borrowers->count()}}" class="custom-td-width">1.</td>
                            @endif    
                        @endif
                    @endif    

                    <td  colspan="2">
                        Applicant's (full name and address)
                    </td>
                    
                </tr>
                
                <tr> 
                    <td class="custom-td-title">
                        Borrower
                    </td>
                    <td>
                        <p>{{$application->borrower->first_name}} {{$application->borrower->middle_name}} {{$application->borrower->last_name}}</p>
                        <p style="text-transform: capitalize;">{{$application->borrower->address_line_1}}@if($application->borrower->address_line_2), {{$application->borrower->address_line_2}}@endif, {{$application->borrower->city}}, {{$application->borrower->state}}, {{$application->borrower->pincode}}</p>
                    </td>
                </tr>
                @if($application->type=='loan' && !$application->self_patient)
                    @if($minor==false)
                    <tr> 
                        <td class="custom-td-title">
                            Co-borrower
                        </td>
                        <td>
                            <p>{{$borrower->application->patient->first_name}} {{$borrower->application->patient->middle_name}} {{$borrower->application->patient->last_name}}</p>
                            <p style="text-transform: capitalize;">{{$borrower->application->patient->address_line_1}}
                            @if($borrower->application->patient->address_line_2)
                            , {{$borrower->application->patient->address_line_2}}
                            @endif
                            , {{$borrower->application->patient->city}}, {{$borrower->application->patient->state}}, {{$borrower->application->patient->pincode}}</p>
                        </td>
                    </tr>
                    @endif
                @endif
                @foreach($application->coborrower as  $coborrower)
                <tr> 
                    <td class="custom-td-title">
                        Co-borrower
                    </td>
                    <td>
                        <p>{{$coborrower->first_name}} {{$coborrower->middle_name}} {{$coborrower->last_name}}</p>
                        <p style="text-transform: capitalize;">{{$coborrower->address_line_1}}
                        @if($coborrower->address_line_2)
                        , {{$coborrower->address_line_2}}
                        @endif
                        , {{$coborrower->city}}, {{$coborrower->state}}, {{$coborrower->pincode}}</p>
                    </td>
                </tr>
                @endforeach

                @foreach($application->guarantor as  $guarantor)
                <tr> 
                    <td class="custom-td-title">
                        Guarantor
                    </td>
                    <td>
                        <p>{{$guarantor->first_name}} {{$guarantor->middle_name}} {{$guarantor->last_name}}</p>
                        <p style="text-transform: capitalize;">{{$guarantor->address_line_1}}
                        @if($guarantor->address_line_2)
                        , {{$guarantor->address_line_2}}
                        @endif
                        , {{$guarantor->city}}, {{$guarantor->state}}, {{$guarantor->pincode}}</p>
                    </td>
                </tr>
                @endforeach
               
                
                <tr>
                    <td class="custom-td-width">2.</td>
                    <td class="custom-td-title">Purpose of the Loan</td>
                    <td>Medical Loan</td>
                </tr>
                <tr>
                    <td class="custom-td-width">3.</td>
                    <td class="custom-td-title">Loan Amount</td>
                    <td><span style="font-family: DejaVu Sans; sans-serif;">&#8377; </span> {{$borrower->application->approved_loan_amount}}/- <b>(Rupees {{App\Helpers\Helpers::getIndianCurrency($borrower->application->approved_loan_amount).' Only.'}})</td>
                </tr>
                <tr>
                    <td class="custom-td-width">4.</td>
                    <td class="custom-td-title">Tenure/No of Advance EMIs</td>
                    <td>{{strtoupper($borrower->application->approved_loan_tenure)}} Months / {{strtoupper($borrower->application->advance_emi)}} Months </td>
                </tr>
                <tr>
                    <td class="custom-td-width">5.</td>
                    <td class="custom-td-title">Disbursed, as per borrower instruction, to</td>
                    <td>{{$borrower->application->approved_hospital_name}}</td>
                </tr>
                <tr>
                    <td class="custom-td-width">6.</td>
                    <td class="custom-td-title">Rate of Interest / Method of calculation</td>
                    <td>{{round($borrower->application->interest_rate,2)}}% per annum (flat); ({{round($borrower->application->effective_interest_rate,2)}}% per annum (reducing balance))</td>
                </tr>
                <tr>
                    <td class="custom-td-width">7.</td>
                    <td class="custom-td-title">Processing Fee</td>
                    <td><span style="font-family: DejaVu Sans; sans-serif;">&#8377; </span> {{$borrower->application->processing_fee_amount}}/-  ( {{$borrower->application->processing_fee}}% of Loan Amount + 18% GST)</td>
                </tr>
                <tr>
                    <td class="custom-td-width">8.</td>
                    <td class="custom-td-title">Document Charges</td>
                    <td><span style="font-family: DejaVu Sans; sans-serif;">&#8377; </span> {{$borrower->application->documentation_charge_gst}}/-  (<span style="font-family: DejaVu Sans; sans-serif;">&#8377; </span>  {{$borrower->application->documentation_charge}} + 18% GST)</td>
                </tr>
                <tr>
                    <td class="custom-td-width">9.</td>
                    <td class="custom-td-title">Equated Monthly Installment(EMI)</td>
                    <td><span style="font-family: DejaVu Sans; sans-serif;">&#8377; </span> {{$borrower->application->approved_loan_emi}}/- </td>
                </tr>
                <tr>
                    <td class="custom-td-width">10.</td>
                    <td class="custom-td-title">Scheduled due Date (Repayment Schedule separately enclosed)</td>
                    <td>{{$application->valid_from}} to {{$application->valid_upto}}</td>
                </tr>
                <tr>
                    <td class="custom-td-width">11.</td>
                    <td class="custom-td-title">Repayment Instrument</td>
                    <td>Cheque/ECS/ACH as per Cheque Submission Letter</td>
                </tr>
                <tr>
                    <td class="custom-td-width">12.</td>
                    <td class="custom-td-title">Prepayment Charges</td>
                    <td class="tj">4% if prepaid in &lt;6 months, 3% if prepaid in &lt;12 months, 2% if prepaid after 12 months</td>
                </tr>
                <tr>
                    <td class="custom-td-width">13.</td>
                    <td class="custom-td-title">Delayed Payment Charges</td>
                    <td>18% per annum on the delayed EMI</td>
                </tr>
                <tr>
                    <td class="custom-td-width">14.</td>
                    <td class="custom-td-title">Cheque /ECS dishonour charges</td>
                    <td><span style="font-family: DejaVu Sans; sans-serif;">&#8377; </span> 500/-  per dishonour of cheque/ECS/ACH per presentation </td>
                </tr>
                <tr>
                    <td class="custom-td-width">15.</td>
                    <td class="custom-td-title">Taxes and Government Levies</td>
                    <td class="tj">Interest is net of taxes and government levies.The Applicant(s) shall be liable to pay the applicable taxes, if applicable</td>
                </tr>
                <tr>
                    <td class="custom-td-width">16.</td>
                    <td class="custom-td-title">Declaration</td>
                    <td class="tj">I/WE the Applicant(s) to the Loan from Ramtirth Leasing and Finance Company Private Limited (Lender)
                        have read and understood the general Terms and Conditions (T&amp;C) applicable to the Loan granted
                        by the lender which is registered on 23rd June 2017 with the Sub-Registrar-Andheri 2, Mumbai, vide registration
                        no. BDR-4/5272/2017 in Book No.1 from pages 1 to 26 and also available on Lender's 
                        website www.arogyafinance.com. Also, I have been informed in my vernacular language all aspects of the said
                        T&amp;C being incorporated to this Loan Application by way of this reference.
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <h4>
                            
                            <p>RECEIPT OF LOAN AMOUNT</p>
                            <p class="tj">I/WE hereby acknowledge receipt of the Loan amount mentioned above from Ramtirth Leasing and Finance Company Private
                                                       Limited ("Lender"). I/WE acknowledge and confirm that the Lender shall, at its sole discretion and under intimation to me / us,
                                                       be entitled to amend or modify the terms and conditions of the Loan and all such amendments(s) or modification(s),shall
                                                       be deemed to be effective and binding on me /us. I/WE hereby confirm having received a copy of the T&amp;C, Sanction Letter, MID and this Receipt.
                                                       I have read and understood the terms and conditions, understand the legal liabilities that arise upon me/us and executed this Receipt.</p> <br>
                            
                            <p>Signature</p>
                            <table>
                            <tr>
                                <td>
                                    <p class="signature">
                                        <img style="height:90px;" src="assets/images/sanction_letter/revenue_stamp.jpg"><br>
                                        Borrower : {{$application->borrower->first_name}} {{$application->borrower->middle_name}} {{$application->borrower->last_name}}
                                    </p>
                                </td>
                                @if($application->type=='loan' && !$application->self_patient)
                                    @if($minor==false)
                                    <td>
                                        <p class="signature">
                                            <img style="height:90px;" src="assets/images/sanction_letter/revenue_stamp.jpg"><br>
                                            Co-borrower : {{$borrower->application->patient->first_name}} {{$borrower->application->patient->middle_name}} {{$borrower->application->patient->last_name}}
                                        </p>
                                    </td>
                                    @endif
                                @endif
                                @foreach($application->coborrower as  $coborrower)
                                <td>
                                    <p class="signature">
                                        <img style="height:90px;" src="assets/images/sanction_letter/revenue_stamp.jpg"><br>
                                        Co-borrower : {{$coborrower->first_name}} {{$coborrower->middle_name}} {{$coborrower->last_name}}
                                    </p>
                                </td>
                                @endforeach

                                @foreach($application->guarantor as  $guarantor)
                                <td>
                                    <p class="signature">
                                        <img style="height:90px;" src="assets/images/sanction_letter/revenue_stamp.jpg"><br>
                                        Guarantor : {{$guarantor->first_name}} {{$guarantor->middle_name}} {{$guarantor->last_name}}
                                    </p>
                                </td>
                                @endforeach   
                            </tr>
                            </table>  
                            
                            <br><br>
                            Note:Each Borrower/Guarantor has to sign on Rs 1/- Revenue Stamp(Signature to be partially on the stamp)
                        </h4>
                    </td>
                </tr>
            </tbody>
    </table>
@endsection

