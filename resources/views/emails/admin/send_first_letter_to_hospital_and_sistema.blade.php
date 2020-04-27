Greetings from Arogya Finance!<br><br>
We are glad to inform you that a Medical Loan (PIN: {{$application->pin_number}} / Application Ref Code: {{$application->reference_code}}) of Rs.{{$application->approved_loan_amount}} has been processed for remittance to {{ucfirst($application->hospital_name)}} bank account no {{$hospital_detail->acc_number}}, on behalf of your Customer {{ucfirst($application->patient->first_name)}} {{ucfirst($application->patient->last_name)}}, as per details below.<br><br>
Payment advice from our HDFC Bank will reach your mail ID directly. Please contact us, in case for any reason the amount does not reflect in your bank account, with in 24 hours.<br>
<!DOCTYPE html>
<html>
	<head>
		<title>Loan Amount Breakdown</title>
            <style>
                  table {
                    font-family:sans-serif; box-sizing: border-box; margin: 7px; width: 50%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 50%;
                  }
                  thead {
                        font-family:sans-serif; box-sizing: border-box;
                  }
                  tbody {
                        font-family:sans-serif; box-sizing: border-box;
                  }
                  tbody td {
                        font-family:sans-serif; box-sizing: border-box; color: #74787e; font-size: 11px; line-height: 8px; padding: 5px 0;
                  }
            </style>
	</head>
	<body>
		<table>
                  <thead>
                        <tr>
                              <th style="font-family:sans-serif; box-sizing: border-box; color: #74787e; border-bottom: 1px solid #edeff2; padding-bottom: 6px; text-align: left; width: 60%" >
                                    Particulars
                              </th>
                              <th style="font-family:sans-serif; box-sizing: border-box; color: #74787e; border-bottom: 1px solid #edeff2; padding-bottom: 6px; text-align: left; width: 40%">
                                    Amount Rs
                              </th>
                        </tr>
                  </thead>
                  <tbody>
                  	<tr>
                  		<td>LOAN AMOUNT</td>
                  		<td>
                                    {{number_format($application->approved_loan_amount)}}
                              </td>
                  	</tr>
                        @if($application->advance_emi_deduct)
                  	<tr>
                  		<td>ADVANCE EMI AMOUNT</td>
                  		<td>{{number_format($application->advance_emi*$application->approved_loan_emi)}}
                                    
                              </td>
                  	</tr>
                        @endif

                        @if($application->subvention_deduct)
                  	<tr>
                  		<td>SUBVENTION</td>
                  		<td>
                                    {{number_format(round(($application->approved_loan_amount*$application->subvention)/100))}}
                              </td>
                  	</tr>
                        @endif

                        @if($application->document_processing_fee_deduct)                 
                  	<tr>
                  		<td>PROCESSING FEES / DOCUMENTATION CHARGES</td>
                  		<td>
                                    {{number_format(round($application->processing_fee_amount+$application->documentation_charge_gst))}}
                              </td>
                  	</tr>
                        @endif

                  	<tr>
                              <td>DISBURSEMENT AMOUNT</td>
                              <td>
                                   {{number_format($application->getDisbursedAmount())}}
                              </td>
                  	</tr>
                  </tbody>
		</table>
	</body>
</html>
We thank you for your continued support and look forward to supporting more Customers from your organisation.
<br><br>
@if($partner_detail!=null)
CC to {{ucfirst($partner_detail->first_name)}} {{ucfirst($partner_detail->last_name)}}<br><br>
@endif
<p>
      <b>Best Regards,<br><br>
      Sonali Parab <br>	
      Assistant Manager  - Accounts & Operation</b>
</p>