<?php

/*
|--------------------------------------------------------------------------
| Eligibility Test Routes
|--------------------------------------------------------------------------
|
| Eligibility Test routes are defined here
|
*/
Route::group(['prefix'=>'','namespace'=>'Website\StaticPage'], function () {
	Route::get('/', 'PageController@home');
	Route::get('/locale/{locale}', 'PageController@home');
	Route::get('how-it-works', 'PageController@work');
	Route::get('faq', 'PageController@faq');
	Route::get('hospital-partners', 'PageController@hospitalPartners');
	Route::get('industry-partners','PageController@industryPartners');
	Route::get('associate-partners','PageController@associatePartners');
	Route::get('about', 'PageController@about');
	Route::get('news-room', 'PageController@press');
	Route::get('our-board', 'PageController@ourBoard');
	Route::get('management', 'PageController@Management');
	Route::get('advisory-board', 'PageController@advisoryBoard');
	Route::get('sitemap', 'PageController@sitemap');  
	Route::get('ceo-speaks', 'PageController@ceoSpeaks');
});

$ps = ["AF10704",
"AF10803",
"KF10341",
"KF10353",
"KF10345",
"KF10366",
"KF10388",
"KF10399",
"KF10406",
"KF10395",
"KF10439",
"KF10427",
"KF10466",
"KF10490",
"KF10508",
"KF10509",
"KF10533",
"DF10167",
"DF10207",
"DF10234",
"DF10236",
"DF10233",
"DF10245",
"DF10250",
"DF10252",
"DF10246",
"DF10262",
"NF10102",
"NF10158",
"NF10205",
"BF10110",
"BF10140",
"BF10146",
"PF10115",
"PF10149",
"SF10017",
"SF10040",
"SF10051",
"SF10061",
"GF10025",
"DF10280",
"NF10226",
"KF10574",
"GF10053",
"BF10171",
"AF10843",
"DF10298",
"AF10873",
"KF10582",
"KF10600",
"AF10888",
"AF10883",
"AF10894",
"AF10891",
"SF10073",
"GF10070",
"DF10308",
"BF10202",
"BF10190",
"KF10611",
"BF10207",
"GF10068",
"GF10067",
"KF10617",
"DF10311",
"AF10897",
"PF10471",
"BF10195",
"PF10445",
"KF10604",
"AF10912",
"KF10629",
"AF10921",
"PF10473",
"KF10628",
"AF10917",
"BF10211",
"AF10922",
"BF10205",
"PF10479",
"PF10474",
"SF10084",
"PF10467",
"NF10233",
"AF10898",
"PF10472",
"AF10932",
"SF10075",
"KF10614",
"SF10085",
"GF10102",
"AF10939",
"PF10497",
"AF10946",
"KF10655",
"SF10083",
"SF10086",
"AF10940",
"GF10089",
"PF10489",
"GF10076",
"GF10106",
"KF10663",
"AF10958",
"PF10503",
"AF10951",
"PF10502",
"SF10087",
"KF10667",
"GF10107",
"AF10902",
"BF10218",
"GF10097",
"BF10217",
"DF10317",
"KF10644",
"SF10088"];
Route::get('d-doc',function() use($ps) {
   $c =  App\Application::whereIn('pin_number',$ps)->get()->pluck('id');
   $d = App\Document::whereIn('application_id',$c)->where('type','other-zip')->delete();
   dd($d);
});
