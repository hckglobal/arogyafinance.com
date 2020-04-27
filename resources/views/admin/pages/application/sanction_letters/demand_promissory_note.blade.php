@extends('admin.pages.application.sanction_letters.partial.layout_blank')
@section('content')
    <table width="200">
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
        <tr>    
             <td width="5%">
                 Amount  
             </td>
             <td>
                : <span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span> {{$borrower->application->approved_loan_amount}}/-
             </td>
        </tr>
    </table>

    <h3 class="title uc tc">DEMAND PROMISSORY NOTE</h3>
    <h3>ON DEMAND, I/WE,</h3>
    <p class="tj">
                    
                
                    @foreach($application->borrowers as $key => $borrower)
                        <p>{{$borrower->type=="Primary" ? "Borrower" : $borrower->type }} : {{$borrower->first_name}} {{$borrower->middle_name}} {{$borrower->last_name}}</p>

                        @if($borrower->type=="Primary")
                            @if(!$application->self_patient && $application->type=='loan')
                              @if($minor==false)
                                <p>Co-borrower : {{$borrower->application->patient->first_name}} {{$borrower->application->patient->middle_name}} {{$borrower->application->patient->last_name}}</p>
                              @endif  
                            @endif   
                        @endif                        
                    @endforeach
                
            
    </p><br>
    <p class="tj" style="margin-bottom: 1em">
        [The Party (ies) named aforesaid are hereinafter collectively referred as the <span class="b">Borrower(s)</span>]
    </p>

    <p  style="margin-bottom: 1em;">
        <span class="b">THE BORROWER(S)</span> 
        hereby jointly and severally promise to pay M/s Ramtirth Leasing and Finance Company Private Limited,
     or order the sum of <span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span> {{$borrower->application->approved_loan_amount}}/- <span class="b">(Rupees {{App\Helpers\Helpers::getIndianCurrency($borrower->application->approved_loan_amount).' Only'}})</span>
     <span class="b">(“Loan”)</span> with interest at the rate of {{round($borrower->application->interest_rate,2)}}% per annum (flat),{{round($borrower->application->effective_interest_rate,2)}}% per annum (reducing balance)
      thereon for value received together with applicable penal charges, payable at Mumbai.
    </p>
    <p class="tj" style="margin-bottom: 2em">
        Presentment for payment and noting and protest of this are hereby unconditionally and irrevocably waived.
    </p>
    <p>
        Signature
    </p>
    <table>
        <tr>
            <td>
                <p class="signature">
                    <img src="assets/images/sanction_letter/revenue_stamp.jpg"><br>
                    Borrower : {{$application->borrower->first_name}} {{$application->borrower->middle_name}} {{$application->borrower->last_name}}
                </p>
            </td>
            
            @if($application->type=='loan' && !$application->self_patient)
              @if($minor==false)
              <td>
                  <p class="signature">
                      <img src="assets/images/sanction_letter/revenue_stamp.jpg"><br>
                      Co-borrower : {{$borrower->application->patient->first_name}} {{$borrower->application->patient->middle_name}} {{$borrower->application->patient->last_name}}
                  </p>
              </td>
              @endif
            @endif
            @foreach($application->coborrower as  $coborrower)
            <td>
                <p class="signature">
                    <img src="assets/images/sanction_letter/revenue_stamp.jpg"><br>
                    Co-borrower : {{$coborrower->first_name}} {{$coborrower->middle_name}} {{$coborrower->last_name}}
                </p>
            </td>
            @endforeach

            @foreach($application->guarantor as  $guarantor)
            <td>
                <p class="signature">
                    <img src="assets/images/sanction_letter/revenue_stamp.jpg"><br>
                    Guarantor : {{$guarantor->first_name}} {{$guarantor->middle_name}} {{$guarantor->last_name}}
                </p>
            </td>
            @endforeach   
        </tr>
    </table>
       
    
    <p class="tj" style="margin-bottom: 2em">
        Place: {{$borrower->application->location ? $borrower->application->location->name : ''}}
    </p>
    <p style="margin-bottom: 2em">
        Note: Each Borrower has to sign on <span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span> 1/- Revenue stamp</br>
        (Signature to be partially on the Stamp and the Note)
 
    </p>
@endsection