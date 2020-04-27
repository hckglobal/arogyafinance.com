@extends('admin.pages.application.sanction_letters.partial.layout')

@section('content')
    <h5 style="text-align:right;">{{Carbon\Carbon::parse($borrower->application->disbursement_date)->format('j F, Y')}}</h5>

    <p>To,
         <b><i><br>{{strtoupper($borrower->first_name)}} {{strtoupper($borrower->middle_name)}} {{strtoupper($borrower->last_name)}}</i>
            <br>{{ucwords(strtolower($borrower->address_line_1))}},
            @if($borrower->address_line_2)
            <br>{{ucwords(strtolower($borrower->address_line_2))}}
            @endif
         <br>{{ucwords(strtolower($borrower->city))}}, {{ucwords(strtolower($borrower->state))}} - {{strtoupper($borrower->pincode)}} <br>
         Telephone Number - {{$borrower->mobile_number}}</b>
    </p><br><br>
   
    <p style="margin-top:10px;">
        Dear Customer,
    </p>
    <p style="margin-top:10px;">
        We are pleased to inform you that a loan of <span style="font-family: DejaVu Sans; sans-serif;">&#8377; </span> {{$borrower->application->approved_loan_amount}}/- <b>(Rupees {{App\Helpers\Helpers::getIndianCurrency($borrower->application->approved_loan_amount).' Only'}})</b>
        has been disbursed to you. As per your instruction the amount has been remitted to <strong>@if($borrower->application->approved_hospital_name) {{$borrower->application->approved_hospital_name}}  @else {{$borrower->application->hospital_name}} @endif.</strong> You are requested to use PIN Number <strong>{{$borrower->application->pin_number}}</strong> for any future communication with us.
    </p>
    <p style="margin-top:10px;">
        As you are aware, the installment amount is due on the {{Carbon\Carbon::parse($borrower->application->valid_from)->format('d')}}th of every month. Please ensure that your bank account is adequately funded. This will avoid levy of any additional charges for non-receipt of payment in time.
    </p>
    <p style="margin-top:10px;">
        Your installment amount is <span style="font-family: DejaVu Sans; sans-serif;">&#8377; </span> {{$borrower->application->approved_loan_emi}}/- and the repayment will start from {{$borrower->application->valid_from}}
    </p>
    <p style="margin-top:10px;">
        For your references, we are enclosing the Repayment Schedule.
    </p>
    <p style="margin-top:10px;">
        <table  cellspacing="0" class="compact" border="1" align="center" cellpadding="1">
            <tbody>
                <tr class="table-heading" align="center" valign="center" >
                    <td width="5">EMI No.</td>
                    <td width="5">EMI Type</td>
                    <td width="5">EMI Date</td>
                    <td width="5">EMI Amount</td>
                    <td width="10">Interest Amount</td>
                    <td width="10">Principal Amount</td>
                    <td width="15">Outstanding Principal Amount</td>
                </tr>
                <tr align="center" valign="center">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>{{$borrower->application->approved_loan_amount}}</td>
                </tr>
                <?php $count=0?>
                @foreach($borrower->application->idealRepaymentSchedule('first') as $ideal_repayment_schedule)
                    <tr align="center" valign="center"> 
                        <td >{{$count++}}</td>
                        <td>{{$ideal_repayment_schedule['type']}}</td>
                        <td>
                            @if($ideal_repayment_schedule['emi_month']!='0000-00-00')
                                {{$ideal_repayment_schedule['emi_month']}}
                            @endif
                        </td>
                        <td>{{$ideal_repayment_schedule['emi']}}</td>
                        <td>@if($ideal_repayment_schedule['type']=='Advance EMI') -- @else {{round($ideal_repayment_schedule['interest'],2)}} @endif</td>
                        <td>@if($ideal_repayment_schedule['type']=='Advance EMI') -- @else{{round($ideal_repayment_schedule['principal'])}} @endif</td>
                        <td>{{round($ideal_repayment_schedule['outstanding_principal'])}}</td>
                    </tr>
                @endforeach 
            </tbody>
        </table> 
    </p>
    <p style="margin-top:10px;">
        If you require any further details, please contact us on the email/telephone given below. Our customer service representative will be glad to assist you.
    </p>
    <p style="margin-top:10px;">
        We value your relationship with us and assure you of our best services always. 
    </p>
        
    <p style="margin-top:15px">
        Best regards,
        <br><br>
        <b>Ramtirth Leasing and Finance Company Private Limited</b>
        <br><br>
        (This is a computer generated letter hence does not require any signature.)
    </p><br>
    <p>
        <center>
            For any clarifications you are requested to contact us on,<br>
            <b>Email: jay.modi@arogyafinance.com</b><br>
            <b>Telephone: 9769205032</b><br>
            
        </center>
    </p>
     
@endsection