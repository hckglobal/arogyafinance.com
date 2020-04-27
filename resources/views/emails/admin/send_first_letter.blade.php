@if($mandate)
Dear {{$admin->first_name}} {{$admin->last_name}},<br><br>
Application PIN - {{$application->pin_number}} has been disbursed.<br><br>
Repayment schedule as attached.<br>
@else
Dear {{$application->borrower->first_name}} {{$application->borrower->last_name}},<br><br>
Welcome to the Arogya Finance.<br>
Your {{ucfirst($application->type)}} Application PIN - <b>{{$application->pin_number}}</b> has been disbursed and your EMI is <span style="font-family: DejaVu Sans; sans-serif;">&#8377; </span>
<b>{{$application->approved_loan_emi}}.</b><br><br>
Please keep sufficient balance in your account to prevent EMI bounce and related charges.<br>
Your repayment schedule as attached.<br>
@endif

@if($mandate)
<a href="www.arogyafinance.com/admin/application/{{$application->type}}/detail/{{$application->id}}">
	Click here to view Application details
</a><br><br>
@else
Please use Reference Code - <b>{{$application->reference_code}}</b> for login.<br>
<a href="www.arogyafinance.com/login">
	Click here to view Application details
</a><br><br>
@endif
<p>
	<b>Best Regards,<br><br>
	Sonali Parab <br>	
	Assistant Manager  - Accounts & Operation</b>
</p>
