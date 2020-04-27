<?php 

namespace App\Http\Controllers\Api;

use Log;
use Illuminate\Http\Request;
use App\Application;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use File;
use PDF;

header('Content-type: application/xml');

class CibilController extends Controller
{
    public function generateReport(Request $input)
    {
        $id = $input->get('id');
        Application::find($id);
        $tuef = $input->get('data');
        //trim 
        $tuef = rtrim($tuef);
        //remove -> Connected to server...sending echo string 
        $tuef= str_replace("Connected to server...sending echo string","",$tuef); 
        $tuef = trim($tuef);
        $info =[];
        $info['cibil_score'] = $input->get('score');
        $info['member_reference_number']=substr($tuef,6,25);
        $info['member_id']=substr($tuef,37,30);
        $info['control_number']=substr($tuef,68,12);
        $info['date']=substr($tuef,80,2).'/'.substr($tuef,82,2).'/'.substr($tuef,84,4);
        $info['time']=wordwrap(substr($tuef,88,6),2, ':' , true );
        $info['current_balance']=0;
        $info['zero_balance_count']=0;
        $info['account_count']=0;
        $info['overdue_count']=0;
        $info['overdue_amount']=0;
        $info['sanction_amount']=0;
        $info['recent_opened_date']= NULL;
        $info['oldest_opened_date']= NULL;
        //field tags
        $info['fields'][0]['field_tag']='07';
        $info['fields'][0]['name']='Date Of Birth';        
        $segments=[];
        $pn_seg = ["name"=>"Consumer Name","fields"=>[["field_tag"=>"PN","field_name"=>"Segment Tag"],["field_tag"=>"01","field_name"=>"Name"],["field_tag"=>"02","field_name"=>"ConsumerName Field2"],["field_tag"=>"03","field_name"=>"ConsumerName Field3"],["field_tag"=>"04","field_name"=>"ConsumerName Field4"],["field_tag"=>"05","field_name"=>"ConsumerName Field5"],["field_tag"=>"07","field_name"=>"Date of Birth"],["field_tag"=>"08","field_name"=>"Gender"],["field_tag"=>"80","field_name"=>"Date of Entry for Error Code"],["field_tag"=>"81","field_name"=>"Error SegmentTag"],["field_tag"=>"82","field_name"=>"Error Code"],["field_tag"=>"83","field_name"=>"Date of Entry for CIBIL Remarks Code"],["field_tag"=>"84","field_name"=>"CIBIL Remarks
        Code"]]];

        $id_id = ["name"=>"Identification Details","fields"=>[["field_tag"=>"ID","field_name"=>"Segment Tag"],["field_tag"=>"01","field_name"=>"ID Type"],["field_tag"=>"02","field_name"=>"ID Number"],["field_tag"=>"03","field_name"=>"Issue Date"],["field_tag"=>"04","field_name"=>"Expiration Date"],["field_tag"=>"90","field_name"=>"Enriched Through Enquiry"]
                                                             ]];
        $pt_seg = ["name"=>"Telephone Contact","fields"=>[["field_tag"=>"PT","field_name"=>"Segment Tag"],["field_tag"=>"01","field_name"=>"Telephone Number"],["field_tag"=>"02","field_name"=>"Telephone Extension"],["field_tag"=>"03","field_name"=>"Telephone Type"],["field_tag"=>"90","field_name"=>"Enriched Through Enquiry"]]];

        $ec_seg = ["name"=>"Email Contact","fields"=>[["field_tag"=>"EC","field_name"=>"Segment Tag"],["field_tag"=>"01","field_name"=>"E-Mail ID"]]];

        $em_seg =["name"=>"Employment Details","fields"=>[["field_tag"=>"EM","field_name"=>"Segment Tag"],["field_tag"=>"01","field_name"=>"Account Type"],["field_tag"=>"02","field_name"=>"Date Reported and Certified"],["field_tag"=>"03","field_name"=>"Occupation Type"],["field_tag"=>"04","field_name"=>"Income"],["field_tag"=>"05","field_name"=>"Net/Gross Income Indicator"],["field_tag"=>"06","field_name"=>"Monthly/Annual Income Indicator"],["field_tag"=>"80","field_name"=>"Date of Entry for Error Code"],["field_tag"=>"82","field_name"=>"Error Code"],["field_tag"=>"83","field_name"=>"Date of Entry for CIBIL Remarks Code"],["field_tag"=>"84","field_name"=>"CIBIL Remarks Code"],["field_tag"=>"85","field_name"=>"Date of Entry for Error/Dispute Remarks Code"],["field_tag"=>"86","field_name"=>"Error/Dispute Remarks Code 1"],["field_tag"=>"87","field_name"=>"Error/Dispute Remarks Code 2"]]];

        $pi_seg =["name"=>"PI Segment","fields"=>[["field_tag"=>"PI","field_name"=>"Segment Tag"],["field_tag"=>"01","field_name"=>"Account Number"]]];

        $sc_seg =["name"=>"Score Details","fields"=>[["field_tag"=>"SC","field_name"=>"Score Name"],["field_tag"=>"01","field_name"=>"Score Card Name"],["field_tag"=>"02","field_name"=>"Score Card Version"],["field_tag"=>"03","field_name"=>"Score Date"],["field_tag"=>"04","field_name"=>"Score"],["field_tag"=>"05","field_name"=>"Exclusion Code 1"],["field_tag"=>"06","field_name"=>"Exclusion Code 2"],["field_tag"=>"07","field_name"=>"Exclusion Code 3"],["field_tag"=>"08","field_name"=>"Exclusion Code 4"],["field_tag"=>"09","field_name"=>"Exclusion Code 5"],["field_tag"=>"10","field_name"=>"Exclusion Code 6"],["field_tag"=>"11","field_name"=>"Exclusion Code 7"],["field_tag"=>"12","field_name"=>"Exclusion Code 8"],["field_tag"=>"13","field_name"=>"Exclusion Code 9"],["field_tag"=>"14","field_name"=>"Exclusion Code 10"],["field_tag"=>"25","field_name"=>"Score Reason 1"],["field_tag"=>"26","field_name"=>"Score Reason 2"],["field_tag"=>"27","field_name"=>"Score Reason 3"],["field_tag"=>"28","field_name"=>"Score Reason 4"],["field_tag"=>"29","field_name"=>"Score Reason 5"],["field_tag"=>"75","field_name"=>"Error Code"]]];        

        $pa_seg =["name"=>"Address Details","fields"=>[["field_tag"=>"PA","field_name"=>"Segment Tag"],["field_tag"=>"01","field_name"=>"Address Line1"],["field_tag"=>"02","field_name"=>"Address Line2"],["field_tag"=>"03","field_name"=>"Address Line3"],["field_tag"=>"04","field_name"=>"Address Line4"],["field_tag"=>"05","field_name"=>"Address Line5"],["field_tag"=>"06","field_name"=>"State Code"],["field_tag"=>"07","field_name"=>"PIN Code"],["field_tag"=>"08","field_name"=>"Address Category"],["field_tag"=>"09","field_name"=>"Residence Type"],["field_tag"=>"10","field_name"=>"Date Reported"],["field_tag"=>"11","field_name"=>"Member Short Name"],["field_tag"=>"90","field_name"=>"Enriched Through Enquiry"]]];

        $tl_seg =["name"=>"Account Details","fields"=>[["field_tag"=>"TL","field_name"=>"Segment Tag"],["field_tag"=>"02","field_name"=>"Reporting Member Short Name"],["field_tag"=>"03","field_name"=>"Account Number"],["field_tag"=>"04","field_name"=>"Account Type"],["field_tag"=>"05","field_name"=>"Ownership Indicator"],["field_tag"=>"08","field_name"=>"Date Opened/Disbursed"],["field_tag"=>"09","field_name"=>"Date of Last Payment"],["field_tag"=>"10","field_name"=>"Date Closed"],["field_tag"=>"11","field_name"=>"Date Reported and Certified"],["field_tag"=>"12","field_name"=>"High Credit/Sanctioned Amount"],["field_tag"=>"13","field_name"=>"Current Balance"],["field_tag"=>"14","field_name"=>"Amount Overdue"],["field_tag"=>"28","field_name"=>"Payment History 1"],["field_tag"=>"29","field_name"=>"Payment History 2"],["field_tag"=>"30","field_name"=>"Payment History Start Date"],["field_tag"=>"31","field_name"=>"Payment History End Date"],["field_tag"=>"32","field_name"=>"Suit Filed / Wilful Default"],["field_tag"=>"33","field_name"=>"Written-off and Settled Status"],["field_tag"=>"34","field_name"=>"Value of Collateral"],["field_tag"=>"35","field_name"=>"Type of Collateral"],["field_tag"=>"36","field_name"=>"Credit Limit"],["field_tag"=>"37","field_name"=>"Cash Limit"],["field_tag"=>"38","field_name"=>"Rate Of Interest"],["field_tag"=>"39","field_name"=>"Repayment Tenure"],["field_tag"=>"40","field_name"=>"EMI Amount"],["field_tag"=>"41","field_name"=>"Written-off Amount (Total)"],["field_tag"=>"42","field_name"=>"Written-off Amount (Principal)"],["field_tag"=>"43","field_name"=>"Settlement Amount"],["field_tag"=>"44","field_name"=>"Payment Frequency"],["field_tag"=>"45","field_name"=>"Actual Payment Amount"],["field_tag"=>"80","field_name"=>"Date of Entry for Error Code"],["field_tag"=>"82","field_name"=>"Error Code"],["field_tag"=>"83","field_name"=>"Date of Entry for CIBIL Remarks Code"],["field_tag"=>"84","field_name"=>"CIBIL Remarks Code"],["field_tag"=>"85","field_name"=>"Date of Entry for Error/Dispute Remarks Code"],["field_tag"=>"86","field_name"=>"Error/Dispute Remarks Code 1"],["field_tag"=>"87","field_name"=>"Error/Dispute Remarks Code 2"]]];

        $iq_seg= ["name"=>"IQ Segment","fields"=>[["field_tag"=>"IQ","field_name"=>"Segment Tag"],["field_tag"=>"01","field_name"=>"Date of Enquiry"],["field_tag"=>"04","field_name"=>"Enquiring Member Short Name"],["field_tag"=>"05","field_name"=>"Enquiry Purpose"],["field_tag"=>"06","field_name"=>"Enquiry Amount"]]];

        $dr_seg=["name"=>"DR Segment","fields"=>[["field_tag"=>"DR","field_name"=>"Segment Tag"],["field_tag"=>"01","field_name"=>"Date of Entry"],["field_tag"=>"02","field_name"=>"Dispute Remarks Line1"],["field_tag"=>"03","field_name"=>"Dispute Remarks Line2"],["field_tag"=>"04","field_name"=>"Dispute Remarks Line3"],["field_tag"=>"05","field_name"=>"Dispute Remarks Line4"],["field_tag"=>"06","field_name"=>"Dispute Remarks Line5"],["field_tag"=>"07","field_name"=>"Dispute Remarks Line6"]]];

        array_push($segments,$pn_seg,$id_id,$pt_seg,$ec_seg,$em_seg,$sc_seg,$pa_seg,$tl_seg,$iq_seg);

        //final array of results
        $result = array();

        //initiate cursor
        $cursor = 94;

        foreach($segments as $segment){
            
            //make a segment
            $cur_segment = ["name"=>$segment["name"],"sections"=>array()];
            //check if the $cur_tag is present in string
            $cur_tag =$segment['fields'][0]['field_tag'];
            
            //check if the cur segment is present in string else skip to next segment
            if($cur_tag != substr($tuef,$cursor,2)) continue;

            do{
                //empty fileds array
                $fields = array();

                //see if current tag is tl
                if($cur_tag=="TL"){
                   $info['account_count']++;
                }                
               
                foreach($segment['fields'] as $field){
                    //get the current tag in queue
                    $cur_field = substr($tuef,$cursor,2);
                    //skip the tag if doesnt match
                    if($cur_field!=$field['field_tag']) continue;
                    
                    //move cursor ahead by 2
                    $cursor+=2;
                    $field_value_length =  intval(substr($tuef,$cursor,2));
                    //move cursor ahead by 2
                    $cursor+=2;
                    $value = substr($tuef,$cursor,$field_value_length);
                    
                    //formate value if date
                    if (stripos($field['field_name'], 'date') !== false) {
                        $value = substr($value,0,2).'/'.substr($value,2,2).'/'.substr($value,4,4);
                    }
                    //echo $field['field_name'].' : '.$value.'<br>';
                    //cursor 
                    $cursor+=$field_value_length;

                    //push it in array
                    $field = ['field_name'=>$field['field_name'],'field_value'=>$value];
                    //push it into fields
                    array_push($fields,$field);

                    //see if current tag is TL
                    if($cur_tag=="TL"){
                        //see if cur field is
                        if($cur_field=="12") $info['sanction_amount']+= $value;

                        if($cur_field=="13"){

                            //store current balance
                            $info['current_balance']+= $value;

                            //count zero balance
                            if(intval($value)==0){
                                $info['zero_balance_count']++;
                            }
                        } 

                        if($cur_field=="14") {
                            $info['overdue_amount']+= $value;
                            $info['overdue_count']++;
                        }

                        if($cur_field=="08"){
                            if($info['recent_opened_date']==NULL) $info['recent_opened_date'] = $value;
                            $info['oldest_opened_date'] = $value;
                            
                        }
                        
                    }
                }

                //push all the fields into the section of segment
                array_push($cur_segment['sections'],$fields);

                //end of all fields, read the next tag
                $next_tag= substr($tuef,$cursor,2);

            }while($next_tag==$cur_tag);
            
            //push segment into  result
            array_push($result,$cur_segment);
        }
        
        //length of name
        $nameLength= substr($tuef,103,2);
        $info['consumer_name']=substr($tuef,105,$nameLength);

        $result = $this->replaceValues($result);
        
        $report = view('reports.cibil')->with(['data'=>$result,'info'=>$info])->render();

       //destination path is a folder
        $basePath= public_path()."/documents/".$id;

        if (!file_exists($basePath)){
            File::makeDirectory($basePath, 0775, true);
        }
       //write into the file
       File::put($basePath.'/cibil_report.html', $report);

       // return 'ok';   

       $pdf = PDF::loadView('reports.cibil', ['data'=>$result,'info'=>$info])->setPaper('a4');
       $pdf->save(public_path().'/documents/'.$id.'/cibil_report.pdf');

       return "ok";

      // Log::info($c);
    }


    public function replaceValues($segments)
    {

        $replacements['ID Type']=["01"=>"PAN Card","02"=>"Ration Card","03"=>"Passport","04"=>"Aadhaar Card","06"=>"Universal ID Number (UID)"];
        $replacements['Gender']=["1"=>"Female","2"=>"Male"];
        $replacements['Telephone Type']=["00"=>"NOT CLASSIFIED"];
        $replacements['State Code'] = ["01"=>"Jammu and Kashmir","02"=>"Himachal Pradesh","03"=>"Punjab","04"=>"Chandigarh","05"=>"Uttaranchal","06"=>"Haryana","07"=>"Delhi","08"=>"Rajasthan","09"=>"Uttar Pradesh","10"=>"Bihar","11"=>"Sikkim","12"=>"Arunachal Pradesh","13"=>"Nagaland","14"=>"Manipur","15"=>"Mizoram","16"=>"Tripura","17"=>"Meghalaya","18"=>"Assam","19"=>"West Bengal","20"=>"Jharkhand","21"=>"Orissa","22"=>"Chhattisgarh","23"=>"Madhya Pradesh","24"=>"Gujarat","25"=>"Daman and Diu","26"=>"Dadra and Nagar Haveli","27"=>"Maharashtra","28"=>"Andhra Pradesh","29"=>"Karnataka","30"=>"Goa","31"=>"Lakshadweep","32"=>"Kerala","33"=>"Tamil Nadu","34"=>"Pondicherry","35"=>"Andaman and Nicobar Islands","36"=>"Telangana","99"=>"APO Address"];

        $replacements['Account Type']=["01"=>"Auto Loan (Personal)","02"=>"Housing Loan","03"=>"Property Loan","04"=>"Loan Against Shares/Securities","05"=>"Personal Loan","06"=>"Consumer Loan","07"=>"Gold Loan","08"=>"Education Loan","09"=>"Loan to Professional","10"=>"Credit Card","11"=>"Leasing","12"=>"Overdraft","13"=>"Two-wheeler Loan","14"=>"Non-Funded Credit Facility","15"=>"Loan Against Bank Deposits","16"=>"Fleet Card","17"=>"Commercial Vehicle Loan","18"=>"Telco – Wireless","19"=>"Telco – Broadband","20"=>"Telco – Landline","31"=>"Secured Credit Card","32"=>"Used Car Loan","33"=>"Construction Equipment Loan","34"=>"Tractor Loan","35"=>"Corporate Credit Card","36"=>"Kisan Credit Card","40"=>"Microfinance – Business Loan","41"=>"Microfinance – Personal Loan","42"=>"Microfinance – Housing Loan","43"=>"Microfinance – Other","51"=>"Business Loan – General","52"=>"Business Loan – Priority Sector – Small Business","53"=>"Business Loan – Priority Sector – Agriculture","54"=>"Business Loan – Priority Sector – Others","55"=>"Business Non-Funded Credit Facility – General","56"=>"Business Non-Funded Credit Facility – Priority Sector – Small Business","57"=>"Business Non-Funded Credit Facility – Priority Sector – Agriculture","58"=>"Business Non-Funded Credit Facility – Priority Sector- Others","59"=>"Business Loan Against Bank Deposits","60"=>"Business Loan – Director Search","80"=>"Microfinance Detailed Report (Applicable to Enquiry Purpose only)","81"=>"Summary Report (Applicable to Enquiry Purpose only)","88"=>"Locate Plus for Insurance (Applicable to Enquiry Purpose only)","90"=>"Account Review (Applicable to Enquiry Purpose only)","91"=>"Retro Enquiry (Applicable to Enquiry Purpose only)","92"=>"Locate Plus (Applicable to Enquiry Purpose only)","97"=>"Adviser Liability (Applicable to Enquiry Purpose only)","00"=>"Other","98"=>"Secured (Account Group for Portfolio Review response)","99"=>"Unsecured (Account Group for Portfolio Review response)"];

        $replacements['Score Reason 1']=["01"=>"Not enough credit card debt experience","02"=>"Length of time since most recent account delinquency is too short","03"=>"Too many two-wheeler accounts","04"=>"Too many business loans","05"=>"Credit card account balances too high in proportion to high credit amount","06"=>"Maximum amount on mortgage loan is low","07"=>"Total amount past due is too high","08"=>"Not enough mortgage debt experience","09"=>"Too much change of indebtedness on non-mortgage trades over the past 24 months","10"=>"Insufficient improvement in delinquency status","11"=>"Too much increase of indebtedness on non-mortgage trades over the past 12 months","12"=>"Too many enquiries","13"=>"Too many accounts with a balance","14"=>"Length of time accounts have been established is too short","15"=>"Not enough debt experience","16"=>"Too many credit card accounts","17"=>"Presence of a high number of enquiries","18"=>"Number of active trades with a balance too high in proportion to total trades","19"=>"Too much change of indebtedness on credit cards over the past 24 months","20"=>"Credit card balance too high","21"=>"Proportion of delinquent trades too high","22"=>"Presence of delinquency","23"=>"Total high credit of delinquencies is too high","24"=>"Presence of a minor delinquency on personal loan"];

        $replacements['Score Reason 2']=["01"=>"Not enough credit card debt experience","02"=>"Length of time since most recent account delinquency is too short","03"=>"Too many two-wheeler accounts","04"=>"Too many business loans","05"=>"Credit card account balances too high in proportion to high credit amount","06"=>"Maximum amount on mortgage loan is low","07"=>"Total amount past due is too high","08"=>"Not enough mortgage debt experience","09"=>"Too much change of indebtedness on non-mortgage trades over the past 24 months","10"=>"Insufficient improvement in delinquency status","11"=>"Too much increase of indebtedness on non-mortgage trades over the past 12 months","12"=>"Too many enquiries","13"=>"Too many accounts with a balance","14"=>"Length of time accounts have been established is too short","15"=>"Not enough debt experience","16"=>"Too many credit card accounts","17"=>"Presence of a high number of enquiries","18"=>"Number of active trades with a balance too high in proportion to total trades","19"=>"Too much change of indebtedness on credit cards over the past 24 months","20"=>"Credit card balance too high","21"=>"Proportion of delinquent trades too high","22"=>"Presence of delinquency","23"=>"Total high credit of delinquencies is too high","24"=>"Presence of a minor delinquency on personal loan"];

        $replacements['Score Reason 3']=["01"=>"Not enough credit card debt experience","02"=>"Length of time since most recent account delinquency is too short","03"=>"Too many two-wheeler accounts","04"=>"Too many business loans","05"=>"Credit card account balances too high in proportion to high credit amount","06"=>"Maximum amount on mortgage loan is low","07"=>"Total amount past due is too high","08"=>"Not enough mortgage debt experience","09"=>"Too much change of indebtedness on non-mortgage trades over the past 24 months","10"=>"Insufficient improvement in delinquency status","11"=>"Too much increase of indebtedness on non-mortgage trades over the past 12 months","12"=>"Too many enquiries","13"=>"Too many accounts with a balance","14"=>"Length of time accounts have been established is too short","15"=>"Not enough debt experience","16"=>"Too many credit card accounts","17"=>"Presence of a high number of enquiries","18"=>"Number of active trades with a balance too high in proportion to total trades","19"=>"Too much change of indebtedness on credit cards over the past 24 months","20"=>"Credit card balance too high","21"=>"Proportion of delinquent trades too high","22"=>"Presence of delinquency","23"=>"Total high credit of delinquencies is too high","24"=>"Presence of a minor delinquency on personal loan"];

        $replacements['Score Reason 4']=["01"=>"Not enough credit card debt experience","02"=>"Length of time since most recent account delinquency is too short","03"=>"Too many two-wheeler accounts","04"=>"Too many business loans","05"=>"Credit card account balances too high in proportion to high credit amount","06"=>"Maximum amount on mortgage loan is low","07"=>"Total amount past due is too high","08"=>"Not enough mortgage debt experience","09"=>"Too much change of indebtedness on non-mortgage trades over the past 24 months","10"=>"Insufficient improvement in delinquency status","11"=>"Too much increase of indebtedness on non-mortgage trades over the past 12 months","12"=>"Too many enquiries","13"=>"Too many accounts with a balance","14"=>"Length of time accounts have been established is too short","15"=>"Not enough debt experience","16"=>"Too many credit card accounts","17"=>"Presence of a high number of enquiries","18"=>"Number of active trades with a balance too high in proportion to total trades","19"=>"Too much change of indebtedness on credit cards over the past 24 months","20"=>"Credit card balance too high","21"=>"Proportion of delinquent trades too high","22"=>"Presence of delinquency","23"=>"Total high credit of delinquencies is too high","24"=>"Presence of a minor delinquency on personal loan"];

        $replacements['Score Reason 5']=["01"=>"Not enough credit card debt experience","02"=>"Length of time since most recent account delinquency is too short","03"=>"Too many two-wheeler accounts","04"=>"Too many business loans","05"=>"Credit card account balances too high in proportion to high credit amount","06"=>"Maximum amount on mortgage loan is low","07"=>"Total amount past due is too high","08"=>"Not enough mortgage debt experience","09"=>"Too much change of indebtedness on non-mortgage trades over the past 24 months","10"=>"Insufficient improvement in delinquency status","11"=>"Too much increase of indebtedness on non-mortgage trades over the past 12 months","12"=>"Too many enquiries","13"=>"Too many accounts with a balance","14"=>"Length of time accounts have been established is too short","15"=>"Not enough debt experience","16"=>"Too many credit card accounts","17"=>"Presence of a high number of enquiries","18"=>"Number of active trades with a balance too high in proportion to total trades","19"=>"Too much change of indebtedness on credit cards over the past 24 months","20"=>"Credit card balance too high","21"=>"Proportion of delinquent trades too high","22"=>"Presence of delinquency","23"=>"Total high credit of delinquencies is too high","24"=>"Presence of a minor delinquency on personal loan"];

        $replacements['Telephone Type']=["00"=>"Not Classified","01"=>"Mobile Phone","02"=>"Home Phone","03"=>"Office Phone"];

        $replacements['Occupation Type']=["01"=>"Salaried","02"=>"Self Employed Professional.","03"=>"Self Employed","04"=>"Others"];

        $replacements['Net/Gross Income Indicator']=["G"=>"Gross Income","N"=>"Net Income"];

        $replacements['Monthly/Annual Income Indicator']=["M"=>"Monthly","A"=>"Annual"];

        $replacements['Score Card Name']=["01"=>"CIBILTUSCR","02"=>"PLSCORE","04"=>"CIBILTUSC2"];

        $replacements['Exclusion Code 1']=["01"=>"One or more trades with suit filed status in the past 24 months."];
        
        $replacements['Exclusion Code 2']=["01"=>"One or more trades with wilful default status in the past 24 months."];
        
        $replacements['Exclusion Code 3']=["01"=>"One or more trades with suit filed (wilful default) status in the past 24 months."];
        
        $replacements['Exclusion Code 4']=["01"=>"One or more trades written off in the past 24 months."];
        
        $replacements['Exclusion Code 5']=["01"=>"One or more trades with suit filed and written off status in the past 24 months."];
        
        $replacements['Exclusion Code 6']=["01"=>"One or more trades with wilful default and written off status in the past 24 months."];
        
        $replacements['Exclusion Code 7']=["01"=>"One or more trades with suit filed (wilful default) and written off status in the past 24 months."];
        
        $replacements['Exclusion Code 8']=["01"=>"No eligible trade for scoring."];
        
        $replacements['Exclusion Code 9']=["01"=>"One or more trades with restructured debt in the past 24 months."];
        
        $replacements['Exclusion Code 10']=["01"=>"One or more trades with settled debt in the past 24 months."];

        $replacements['Address Category']=["01"=>"Permanent Address","02"=>"Residence Address","03"=>"Office Address","04"=>"Not Categorized"];

        $replacements['Residence Type']=["01"=>"Owned","02"=>"Rented"];

        $replacements['Ownership Indicator']=["1"=>"Individual","2"=>"Authorised User (refers to supplementary credit card holder)","3"=>"Guarantor","4"=>"Joint"];

        $replacements['Suit Filed / Wilful Default']=["00"=>"No Suit Filed","01"=>"Suit filed","02"=>"Wilful default","03"=>"Suit filed (Wilful default)"];

        $replacements['Written-off and Settled Status']=["00"=>"Restructured Loan","01"=>"Restructured Loan (Govt. Mandated)","02"=>"Written-off","03"=>"Settled","04"=>"Post (WO) Settled","05"=>"Account Sold","06"=>"Written Off and Account Sold","07"=>"Account Purchased","08"=>"Account Purchased and Written Off","09"=>"Account Purchased and Settled","10"=>"Account Purchased and Restructured","01"=>"Restructured Loan (Govt. Mandated)","02"=>"Written-off","03"=>"Settled","04"=>"Post (WO) Settled","05"=>"Account Sold","06"=>"Written Off and Account Sold","07"=>"Account Purchased","08"=>"Account Purchased and Written Off","09"=>"Account Purchased and Settled","10"=>"Account Purchased and Restructured"];

        $replacements['Type of Collateral']=["00"=>"No Collateral","01"=>"Property","02"=>"Gold","03"=>"Shares","04"=>"Saving Account and Fixed Deposit"];

        $replacements['Payment Frequency']=["01"=>"Weekly","02"=>"Fortnightly","03"=>"Monthly","04"=>"Quarterly"];
        
        $replacements['Enquiry Purpose']=["01"=>"Auto Loan (Personal)","02"=>"Housing Loan","03"=>"Property Loan","04"=>"Loan Against Shares/Securities","05"=>"Personal Loan","06"=>"Consumer Loan","07"=>"Gold Loan","08"=>"Education Loan","09"=>"Loan to Professional","10"=>"Credit Card","11"=>"Leasing","12"=>"Overdraft","13"=>"Two-wheeler Loan","14"=>"Non-Funded Credit Facility","15"=>"Loan Against Bank Deposits","16"=>"Fleet Card","17"=>"Commercial Vehicle Loan","18"=>"Telco – Wireless","19"=>"Telco – Broadband","20"=>"Telco – Landline","31"=>"Secured Credit Card","32"=>"Used Car Loan","33"=>"Construction Equipment Loan","34"=>"Tractor Loan","35"=>"Corporate Credit Card","36"=>"Kisan Credit Card","40"=>"Microfinance – Business Loan","41"=>"Microfinance – Personal Loan","42"=>"Microfinance – Housing Loan","43"=>"Microfinance – Other","51"=>"Business Loan – General","52"=>"Business Loan – Priority Sector – Small Business","53"=>"Business Loan – Priority Sector – Agriculture","54"=>"Business Loan – Priority Sector – Others","55"=>"Business Non-Funded Credit Facility – General","56"=>"Business Non-Funded Credit Facility – Priority Sector – Small Business","57"=>"Business Non-Funded Credit Facility – Priority Sector – Agriculture","58"=>"Business Non-Funded Credit Facility – Priority Sector- Others","59"=>"Business Loan Against Bank Deposits","60"=>"Business Loan – Director Search","80"=>"Microfinance Detailed Report (Applicable to Enquiry Purpose only)","81"=>"Summary Report (Applicable to Enquiry Purpose only)","88"=>"Locate Plus for Insurance (Applicable to Enquiry Purpose only)","90"=>"Account Review (Applicable to Enquiry Purpose only)","91"=>"Retro Enquiry (Applicable to Enquiry Purpose only)","92"=>"Locate Plus (Applicable to Enquiry Purpose only)","97"=>"Adviser Liability (Applicable to Enquiry Purpose only)","00"=>"Other","98"=>"Secured (Account Group for Portfolio Review response)","99"=>"Unsecured (Account Group for Portfolio Review response)"];

        foreach ($segments as &$segment) {

            foreach ($segment['sections'] as &$section) {

                foreach ($section as &$field) {
                    //check if in replacement value
                    if(array_key_exists($field['field_name'],$replacements)){
                        if(array_key_exists($field['field_value'],$replacements[$field['field_name']])){
                            $field['field_value'] = $replacements[$field['field_name']][$field['field_value']];
                        }
                    }
                }
            }
            
            
        }
        return $segments;
    }

    public function ucb(Request $input)
    {

       if(!$input->has('api_token')) return ['error'=>'Authentication Failed'];
       
       if($input->get('api_token')!='15a74cac32e9ba04') return ['error'=>'Authentication Failed'];

       return Application::whereIn('treatment_type',['Multiple Sclerosis','MS','M.S.','M S','M.S','MS.'])->get();
    }

    public function show($id, Request $input)
    {

        

        if(!$input->has('api_token')) return ['error'=>'Authentication Failed'];
        if($input->get('api_token')!='15a74cac32e9ba04') return ['error'=>'Authentication Failed'];
        $application =  Application::find($id);

        if(!in_array($application->treatment_type, ['Multiple Sclerosis','MS','M.S.','M S','M.S','MS.'])){
            
            return ['error'=>'Application Access Denied, Non Multiple Sclerosis Case'];
        } 

        return $application;
    }


    public function index(Request $input)
    {

    $applications = Application::where('status','disbursed')->where('type','loan');

    if($input->has('start-date')){

     $applications = $applications->whereDate('disbursement_date','>=',$input->get('start-date'));
    }

    if($input->has('end-date')){
      $applications=  $applications->whereDate('disbursement_date','<=',$input->get('end-date'));
    }
    $array = $applications->get(); 
   

    $data = json_decode($array, true);

    // creating object of SimpleXMLElement
    $xml_data = new \SimpleXMLElement('<?xml version="1.0"?><data></data>');

    // function call to convert array to xml
    $this->array_to_xml($data,$xml_data);

    return response($xml_data->asXml(), 200)->header('Content-Type', 'text/plain');


    }


   
    /**
     * Convert array to xml
     * @param  array $data   json array to be converted
     * @param  SimpleXMLElement &$xml_data 
     */
   function array_to_xml( $data, &$xml_data ) {
        foreach( $data as $key => $value ) {
            if( is_numeric($key) ){
                $key = 'application'; //dealing with <0/>..<n/> issues
            }
            if( is_array($value) ) {
                $subnode = $xml_data->addChild($key);
                $this->array_to_xml($value, $subnode);
            } else {
                $xml_data->addChild("$key",htmlspecialchars("$value"));
            }
         }
    }
   
}
