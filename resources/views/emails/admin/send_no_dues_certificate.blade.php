@if($send_to_fc)
<b>Dear {{$admin->first_name}} {{$admin->last_name}},</b><br><br>
PFA of No Dues Certificate of {{$application->borrower->first_name}} {{$application->borrower->last_name}} ({{$application->pin_number}}).
@else
<b>Dear {{$application->borrower->first_name}} {{$application->borrower->last_name}},</b><br><br>
Thank You for being a loyal customer of Arogya Finance.<br><br>
It was a privilege to serve you, please find attached your  No Dues Certificate. <br><br>
We truly value your relationship and look forward to serving you in future.<br><br>
For any future needs, we will be glad to serve you.<br><br>
@endif
<p>
	<b>Best Regards,<br><br>
	Sonali Parab <br>	
	Assistant Manager  - Accounts & Operation</b>
</p>






