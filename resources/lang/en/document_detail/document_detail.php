<?php

return [
    'title' => "Borrower's Documents",
    'note' => 'Kindly upload the required documents for verification. The following formats of upload are acceptable - Images (JPG, PNG); Documents (PDF, DOC, DOCX)',
    'you_have' => 'You have ',
    'documents_remaining' => 'documents remaining',
    'select_id_proof' => 'Select ID Proof',
	'id_proof_options' => [ 1 => 'PAN Card', 2 => 'Aadhar Card', 3 => 'Permanent Driving License',
		4 => 'Photo Credit Card', 5 => 'Passport', 6 => 'Government Employee ID Card', 
		7 => 'Election Card', 8 => 'Photo Bank Passbook'
		],		
    'select_address_proof' => 'Select Address Proof',
	'address_proof_options' => [ 1 => 'Ration Card', 2 => 'Election/Voting Card', 3 => 'Electricity Bill', 
		4 => 'Water Bill', 5 => 'Postpaid landline phone Bill', 6 => 'Passport',
		7 => 'Permanent Driving License', 8 => 'Municipal tax Bill', 
		9 => 'Share Certificate of Society', 10 => 'House Purchase Deed',
		11 => 'Gas Connection (only PSU)', 12 => 'LIC Policy',
		13 => 'Bank Statement (only of scheduled/commercial banks)',
		14 => 'Rent Agreement',	15 => 'Employer’s certificate on letterhead',
		16 => 'RC Book'
		],
	'select_residence_ownership_proof' => 'Select Residence Ownership Proof',
	'residence_ownership_proof_options' => [ 1 => 'Purchase deed', 2 => 'Share certificates',
		3 => 'Electricity bill having ownership address', 4 => 'Index 2', 5 => 'Property tax certificate'
		],		
	'select_income_proof' => 'Select Income Proof',
	'if_salaried' => 'If Salaried (Select Any One)',
	'salaried_options' => [ 1 => 'Salary Slip', 2 => 'Form 16',
		3 => 'Letter from employer stating monthly salary', 4 => 'ITR'
		],
	'if_self_employeed' => 'Self Employeed (Select Any One)',
	'self_employeed_options' => [ 1 => 'Latest two years ITR* (Income Tax Returns)',
		2 => 'Balance Sheet for last 2 years',	3 => 'P&amp;L Statement for last 2 years',
		4 => 'Income Computation Statement (CA attested)', 
		5 => 'Bank statement of last 12 months reflecting income (Rs. 10 Lacs in case of service/Rs. 20 Lacs in case of sales)',
		6 => 'Sales Tax/Service Tax Receipt or Register',
		7 => 'ITR filing date should be at least 30 days prior to application or before 30th Sept'
		],
	'if_agriculture' => 'Agriculture (Select Any One)',
	'agriculture_options' => [ 1 => 'Mandi Receipt', 2 => 'Kisan Passbook', 3 => 'Bank Statement',
		4 => 'Kisan Credit Card'
		],
	'if_pension' => 'Pension',
	'pension_options' => [ 1 => 'Proof of Pension'],
	'upload_bank_statements' => 'Upload Bank Statement: (Hold Ctrl/Cmd for multiple file upload)',
	'upload_photo' => 'Choose Photo'
];
