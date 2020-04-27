@extends('admin.pages.application.sanction_letters.partial.layout_blank')
@section('content')
  <p class="tj" style="margin-bottom: 2em">
    <table>
        <tr>
             <td width="5%">
                 Date  
             </td>
             <td>
                 : {{$date}}
             </td>
        </tr>
        <tr>     
             <td width="5%">
                 Reference  
             </td>
             <td>
                 : {{$borrower->application->pin_number}}
             </td>
        </tr>        
    </table>
  </p>    
  <p style="margin-bottom: 1em">To,
  </p>  
         <b>
        </b>
    
  <p class="tj" style="margin-bottom: 3em">
     Ramtirth Leasing and Fianace Company Private Limited<br>
     102, Meadows, Sahar Plaza, Andheri-Kurla Road,<br>
     J.B.Nagar, Andheri East,<br>
     Mumbai - 400059
  </p>
  <p class="title tc b">  
    Subject: Submission of Repayment Cheques
  </p>
  <p style="margin-bottom: 2em">
     For discharge of liabilities in respect of the Medical Loan availed for the treatment of
        Mr./Mrs/Ms <span class="b uc ">{{$borrower->application->patient->first_name}}
                        {{$borrower->application->patient->middle_name}}
                        {{$borrower->application->patient->last_name}}
                   </span>(Patients Name) for an amount of <span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>{{$borrower->application->approved_loan_amount}}/- <span class="b">(Rupees {{App\Helpers\Helpers::getIndianCurrency($borrower->application->approved_loan_amount).' Only.'}})</span>
     ,the persons signed herein submits the following cheques for repayment on Scheduled Due Date as per your Loan Sanction Letter dated
  </p>
  <p style="margin-bottom: 2em">
        <table border="1" bordercolor="black" cellspacing="0" width="100%" style="margin-bottom: 2em">
            <thead>
                <tr>
                    <th width="10%">Date</th>
                    <th width="35%">Name of Borrower issuing the repayment cheque</th>
                    <th width="15%">Cheque Number</th>
                    <th width="15%">Bank Name</th>
                    <th width="15%">Branch</th>
                    <th width="10%">Type</th>
                </tr>
            </thead>
            <tbody>
                @foreach($application->repaymentCheques as $repaymentCheque)
                <tr height="20">
                    <td align="center">
                    	@if($repaymentCheque->getOriginal('cheque_date')=="0000-00-00")
                        
                        @else
                        {{date('d-m-Y',strtotime($repaymentCheque->cheque_date))}}
                        
                        @endif
                    </td> 
                    <td align="center">{{$repaymentCheque->borrower_name}}</td>
                    <td align="center">{{$repaymentCheque->cheque_number}}</td>
                    <td align="center">{{$repaymentCheque->bank_name}}</td>
                    <td align="center">{{$repaymentCheque->branch}}</td> 
                    <td align="center">{{$repaymentCheque->type}}</td>                
                </tr>
                @endforeach                
            </tbody>
        </table>
  </p>    
    <p class="tj" style="margin-bottom: 1em">
      I/We authorize you to deposit the same on the Scheduled Due Date and also undertake to maintain sufficient balance in respective accounts.
         Further, we undertake to honour all the Post-dated Cheques when presented for payment by you and not to take any steps, which in any way, 
         affect or are likely to affect the payment thereunder to you including, without limitation, any stop payment instructions.
         
    </p>
    <p class="tj" style="margin-bottom: 1em">
    I/We undertake to replace the cheque(s) in the event any Post-dated Cheque issued as above by me/us is lost in transit or misplaced 
         or for any reason and give replacement cheque(s) to you immediately upon receipt of a written request from you in this regard.
    </p>    
    <p class="tj">
        Thanking You,
    </p>
    <p class="tj" style="margin-bottom: 3em">
        Yours Truly You,
    </p>
    <p style="margin-bottom: 2em">
        <table>
            <tr>@foreach($application->borrowers as $borrower)
                <td>
                    <p>
                       {{$borrower->type}} : {{$borrower->first_name}} {{$borrower->middle_name}} {{$borrower->last_name}}
                    </p>
                </td>
                @endforeach
            </tr>
        </table>
    </p>
    <p class="tj">
        Signature of all theBorrower(s)
 
    </p>
    <p class="tj">
        Place: {{$borrower->application->location ? $borrower->application->location->name : ''}}
    </p>
@endsection

