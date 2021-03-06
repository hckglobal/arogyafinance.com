<?php

return [
    'title' => "ઋણલેનારના દસ્તાવેજો",
    'note' => 'કૃપા કરીને ખરાઈ માટે જરૂરી દસ્તાવેજો અપલોડ કરો. નીચેના અપલોડ ફોર્મેટ સ્વીકાર્ય છે- તસવીરો (JPG, PNG); દસ્તાવેજો (PDF, DOC, DOCX)',
    'you_have' => 'તમારા ',
    'documents_remaining' => 'દસ્તાવેજો બાકી છે',
    'select_id_proof' => 'આઈડી પ્રુફ પસંદ કરો',
	'id_proof_options' => [ 1 => 'પાન કાર્ડ', 2 => 'આધાર કાર્ડ', 3 => 'કાયમી ડ્રાઈવિંગ લાઈસન્સ',
		4 => 'ફોટો ક્રેડિટ કાર્ડ', 5 => 'પાસપોર્ટ', 6 => 'સરકારી કર્મચારી આઈકાર્ડ', 
		7 => 'વોટર કાર્ડ', 8 => 'ફોટો બેંક પાસબુક'
		],		
    'select_address_proof' => 'એડ્રેસ પ્રુફ પસંદ કરો',
	'address_proof_options' => [ 1 => 'રેશન-કાર્ડ', 2 => 'ચૂંટણી/મતદાર કાર્ડ', 3 => 'વીજળીનું બિલ', 
		4 => 'પાણીનું બિલ', 5 => 'પોસ્ટપેઈડ લેન્ડલાઈન ફોન બિલ', 6 => 'પાસપોર્ટ',
		7 => 'કાયમી ડ્રાઈવિંગ લાઈસન્સ', 8 => 'મ્યુનિસિપાલિટી ટેક્સ બિલ', 
		9 => 'સોસાયટીનું શેર સર્ટિફિકેટ', 10 => 'મકાન ખરીદી દસ્તાવેજ',
		11 => 'ગેસ કનેક્શન (ફક્ત પીએસયુ)', 12 => ' એલઆઈસી પોલિસી ',
		13 => 'ક સ્ટેટમેન્ટ (ફક્ત શિડ્યુલ્ડ /કોમર્શિયલ બેંક)',
		14 => 'ભાડા કરાર',	15 => 'લેટરહેડ પર કર્મચારીનું પ્રમાણપત્ર',
		16 => 'RC બુક'
		],
	'select_residence_ownership_proof' => 'મકાનમાલિકીનો પુરાવો પસંદ કરો',
	'residence_ownership_proof_options' => [ 1 => 'ખરીદીનો દસ્તાવેજ', 2 => 'શેર સર્ટિફિકેટ',
		3 => 'માલિકીનું સરનામાવાળું વીજળીનું બિલ', 4 => 'ઈન્ડેક્સ 2', 5 => 'મિલ્કતવેરાનું પ્રમાણપત્ર'
		],		
	'select_income_proof' => 'આવકનો પુરાવો પસંદ કરો',
	'if_salaried' => 'પગારદાર હોવ તો (કોઈ એક પસંદ કરો)',
	'salaried_options' => [ 1 => 'પગારચિઠ્ઠી', 2 => 'ફોર્મ 16',
		3 => 'માસિક પગાર દર્શાવતો નોકરીદાતાનો પત્ર', 4 => 'ITR'
		],
	'if_self_employeed' => 'સ્વરોજગાર (કોઈ એક પસંદ કરો)',
	'self_employeed_options' => [ 1 => 'છેલ્લા બે વર્ષના ITR* (આવક વેરાનું રિટર્ન)',
		2 => 'છેલ્લા 2 વર્ષનું પાકું સરવૈયું',	3 => 'નફા-નુકસાન ખાતાનું સ્ટેટમેન્ટ છેલ્લા 2 વર્ષનું',
		4 => 'આવકની ગણતરીનું સ્ટેટમેન્ટ (CA એટેસ્ટેડ)', 
		5 => 'છેલ્લા 12 મહિનાનું સ્ટેટમેન્ટ કે જેમાં આવક દર્શાવાઈ હોય(રૂ. 10 લાખ સેવા ક્ષેત્રમાં હોવ તો/રૂ. 20 લાખ વેચાણ કરતા હોવ તો)',
		6 => 'વેચાણ વેરો/સેવા વેરો રસીદ અથવા પત્રક',
		7 => 'ITR ફાઈલ કર્યાની તારીખ અરજી કર્યાની તારીખથી ઓછામાં ઓછી 30 દિવસ અગાઉની અથવા 30 સપ્ટેમ્બર પહેલાની હોવી જોઈએ'
		],
	'if_agriculture' => 'કૃષિ (કોઈ એક પસંદ કરો)',
	'agriculture_options' => [ 1 => 'એપીએમસીની રસીદ', 2 => 'ખેડૂત પાસબુક', 3 => 'બેંક સ્ટેટમેન્ટ',
		4 => 'કિસાન ક્રેડિટ કાર્ડ'
		],
	'if_pension' => 'પેન્શન',
	'pension_options' => [ 1 => 'પેન્શનનો પૂરાવો'],
	'upload_bank_statements' => 'બેંક સ્ટેટમેન્ટ અપલોડ કરો : (Ctrl/Cmd દબાવો એક કરતા વધુ ફાઈલ અપલોડ કરવા)',
	'upload_photo' => 'ફોટો પસંદ કરો'
];
