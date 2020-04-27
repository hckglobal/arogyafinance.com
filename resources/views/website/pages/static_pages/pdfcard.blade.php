<!DOCTYPE html>
<html>
<head>
    <title>Example</title>
</head>
<body style="margin:2%">
    <h3 style="text-align:right;">Date: {{$date->toFormattedDateString()}}</h3>
    <p>TO,<br>{{$borrower->first_name}} {{$borrower->last_name}},<br>{{$borrower->address_line_1}},<br>{{$borrower->address_line_2}}.</p>
    <h3>Arogya Card No:</h3>
    <p style="margin-top:10px;">
    	Dear {{$borrower->first_name}},<br>
    	We are pleased to welcome you as a privileged owner of an Arogya Card. We are sure that you will 
		find your Arogya Card a convenient way to pay for your medical bills. Overtime you will receive 
		notifications of our tie-ups and partnerships and the special privileges that you can enjoy with them.
    </p>
    <p style="margin-top:10px;">
    Details of your Arogya Card are: <br>
    1.Date of Application: {{$date->toFormattedDateString()}} <br>
    2.Loan Amount approved in-principle: Rs. {{$borrower->loan_amount}}	<br>
    3.Validity Period: <br>
    4.Name of Card Holder: {{$borrower->first_name}} {{$borrower->last_name}} <br>
    5.Name of family members covered:
    	&npsp;a.
    	&npsp;b.
    	&npsp;c.
    	&npsp;d. <br>
    6. Tenure of Loan disbursed: Maximum 36 months. <br>
    7. Interest*: 15% (flat) per annum. In case of partner hospitals** 12% (flat) per annum. <br>
	8. Processing fee*: 2% of Loan Amount. <br>
	9. Documentation charges*: Rs.500.	<br>
	This in-principle approval is subject to submission of the required documents before disbursement,
	including a demand promissory note and postdated cheques, by you and your acceptance of the 
	terms and conditions laid down by the company which are on 
	<span style="color:blue;">www.arogyafinance.com</span> <br>
	In case of Card holder is admitted a Co-borrower is required and in case of borrower staying in rented
	house guarantor is required. <br>
	* Applicable at the time of disbursement &npsp; &npsp; &npsp;**List subject to change
	We look forward to a mutually rewarding relationship. <br><br>
	Best regards,
	<br>
	<br>
	<br>
	Authorized Signatory 
	</p>
	<br>
	<br>
	<br>
	<br>
	<p style="margin-top:15px">
		Best Regards,
		<br>
		<br>
		<br>
		<br>
		<br>
		Authorized Signatory <br>
		<b>Arogya Finance.</b>
	</p>

	
</body>
</html>>
