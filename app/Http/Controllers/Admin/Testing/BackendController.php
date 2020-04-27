<?php

namespace App\Http\Controllers\Admin\Testing;

use Illuminate\Http\Request;
use App\Application;
use App\Borrower;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Excel;
use Log;
use Carbon\Carbon;
use App\PsychometricTest;
use Session;
use App\Product;
use App\Location;
use Terbilang;
use Mail;
use PDF;
use App\Helpers\Alerts;
use App\Helpers\SMSProvider;

class BackendController extends Controller
{
    /*
    * Set the following pin numbers status as "disbursed"
    * 
    */
    public function disbursedCase()
    {
        $arr = array();
        $date = Carbon::now()->format('Y-m-d');
        $today_month = Carbon::now()->format('Y-m');
        $applications_chunks = Application::where('type','loan')->where('status','disbursed')->get()->chunk(100);
        foreach ($applications_chunks as $applications) {
            foreach ($applications as $application) {
            /*if($application->id==2111){*/
                $emi_day = Carbon::parse($application->getOriginal('valid_from'))->format('d');
                $ideal_repayment_schedules = $application->principalIdealRepaymentSchedule();
                $current_month_emi = $ideal_repayment_schedules->where('emi_month',$today_month)->first();
                if ($current_month_emi) {
                    $current_emi_date = $current_month_emi['emi_month']."-".$emi_day;                
                    $emi_notification_date = Carbon::parse($current_emi_date)->subDays(4)->format('Y-m-d');
                    //dd($emi_notification_date,$date);
                    //$diff_in_days = Carbon::parse($current_emi_date)->diffInDays(Carbon::now()->subDays(4));
                    //if ($emi_notification_date == $date) {
                        if($application->borrower){
                            $mobile_number = $application->borrower->mobile_number;
                            
                        } else {
                            $mobile_number = 'N/A';
                        }
                        $data =  array(
                                    'id'=>$application->id,
                                    'pin_number'=>$application->pin_number,
                                    'emi'=>$application->approved_loan_emi,
                                    'borrower_mobile_number' => $mobile_number,
                                    'type'=>$application->type,
                                    'status'=>$application->status,
                                    'valid_from'=>Carbon::parse($application->getOriginal('valid_from'))->format('Y-m-d'),
                                    'valid_upto'=>Carbon::parse($application->getOriginal('valid_upto'))->format('Y-m-d'),
                                    'disbursement_date'=>$application->disbursement_date,
                                    'current_emi_date'=>$current_emi_date,
                                    'emi_notification_date'=>$emi_notification_date
                                );
                            array_push($arr, $data);
                        //var_dump($application->id);
                        $message = Alerts::EMINotificationFourDaysPrior($application,Carbon::parse($current_emi_date)->format('d-m-Y'));
                            dd($message);
                        //SMSProvider::send($application->borrower->mobile_number,$message);
                    //}                
                }
            /*}*/    
            }
        }
        
        Excel::create('EMI Notification', function($excel) use ($arr) {

        $excel->sheet('Sheet1', function($sheet) use($arr) {       
            $arr1 =array();
            foreach ($arr as $key => $value) {
                 $application_data =  array(
                    $value['id'],
                    $value['pin_number'],
                    $value['emi'],
                    $value['borrower_mobile_number'],
                    $value['type'],
                    $value['status'],
                    $value['valid_from'],
                    $value['valid_upto'],
                    $value['disbursement_date'],
                    $value['current_emi_date'],
                    $value['emi_notification_date']);
                array_push($arr1, $application_data);
            }
            //set the titles
            $sheet->fromArray($arr1,null,'A1',false,false)->prependRow(array(
                    'Id','PIN','EMI','Borrower Mobile No','Type','Status','Valid From','Valid Upto','Disbursement Date','Current EMI Date','EMI Notification Date'
                )

            );

        });

    })->export('xlsx');
        dd($arr);
        $given_pin=collect(["AF10001"]);
        $match_rows=Application::whereIn('pin_number',$given_pin)->where('type','loan')->where('status','disbursed')->get();
        //dd($match_rows->count());        
        $match_pins = $match_rows->pluck('id');
        dd($match_pins);
                $present_pin = $given_pin->intersect($match_pins);
                $not_present_pin = $given_pin->diff($present_pin);
                dd($present_pin->toArray(),$not_present_pin->toArray());
        dd('done');
        foreach($match_rows as $application){
         //$application->disbursement_date="2018-04-30";
         $application->status="disbursed";
         $application->save();
        }
        return "Status & date Updated";

        /*foreach($match_rows as $application){
         $application->product_id=1;
         $application->save();

        }
        return "Application product_id Updated to 1";*/
    }

    public function reduplication()
    {   
        $aadhar_cards = collect();
        $application_ids = collect();      

        $applications=Application::all();
        foreach ($applications as $application) {
            foreach ($application->borrowers as $borrower) {
                if($borrower->aadhar_card_number!=''){
                $aadhar_cards->push($this->getAadharCardNumber($borrower));
                }
            }

        }

        $aadhar_cards =$aadhar_cards->groupBy('aadhar_cards');

       
        foreach ($aadhar_cards as $key => $values) {
            if($values->count() > 1){
                foreach ($values as $key => $value) {
                     $application_ids->push($value);
                }
               
            }
        }

        $applications = $application_ids->groupBy('aadhar_cards');
        Excel::create('Reduplication', function($excel) use ($applications) {

        $excel->sheet('Sheet1', function($sheet) use($applications) {       
            $arr =array();
            foreach($applications as $key=>$values) {
                    $data =  array($key);
                    array_push($arr, $data);
                    foreach ($values as $key => $value) {
                         $data =  array(
                            '',
                            $value['id']);
                        array_push($arr, $data);
                    }
                
            }

            //set the titles
            $sheet->fromArray($arr,null,'A1',false,false)->prependRow(array(
                    'Aadhar Card Number','Application_id'
                )

            );

        });

    })->export('xlsx');

    }

    public function getAadharCardNumber($borrower)
    {
        $aadhar_cards=collect();
        $aadhar_cards->put('id',$borrower->application_id);
        $aadhar_cards->put('aadhar_cards',$borrower->aadhar_card_number);
        return $aadhar_cards;
    }

    public function applicationAnalysis($id)
    { 
        $application=Application::find($id);
        
        Excel::create('Application_Analysis', function($excel) use ($application) {

            $excel->sheet('Application_Analysis', function($sheet) use($application) {       
            $arr =array();            
            $data = array (
                            $application->id,
                            $application->type,
                            $application->status,
                            $application->borrower->first_name.' '.$application->borrower->last_name,
                            $application->borrower->email,
                            $application->borrower->mobile_number,
                            $application->patient->id,
                            $application->patient->first_name.' '.$application->borrower->last_name,
                            $application->patient->email                      
                          );
            array_push($arr, $data);
            //set the titles
            $sheet->fromArray($arr,null,'A1',false,false)
                  ->prependRow(array('Application_id','Type','Status','Borrower Name','Borrower Email',
                                     'Borrower Ph.no','Patient Id','Patient Name','Patient Email'
                    ));
            });
        })->export('xlsx');
    }

    public function nonPDC()
    {
        $repayment = collect();

        $applications = Application::where('status','disbursed')->get();
        foreach ($applications as $application) {
            $repayment->push($application->repaymentCheques->where('type','!=','pdc'));
        }
        dd($repayment);
        /*SELECT 
        app.id as ApplicationID, app.type as Type, app.status as Status, app.pin_number as PIN_Number, 
        repayment_cheque.id as repayment_Id,repayment_cheque.type as Cheque_Type from applications as app  INNER JOIN repayment_cheques as repayment_cheque on app.id = repayment_cheque.application_id where repayment_cheque.type != 'pdc' AND app.status='disbursed'*/
    }

    public function ach()
    {
        $application=Application::find(2);
        return view('admin.pages.application.ach')->with(['title'=>'ACH Form','application'=>$application]);
    }


    public function exportMis()
    {
        $applications = Application::where('status','disbursed')->get();
        
        Excel::create('MIS', function($excel) use ($applications) {

            $excel->sheet('Mis_Cases', function($sheet) use($applications) {       
            $arr =array();
            foreach($applications as $application) {            
                if ($application->patient()->count()>0 ) {
                    $data = array (
                                $application->pin_number,
                                $application->location->name,
                                $application->patient->first_name.' '.$application->patient->last_name,                                    
                                $application->borrower->first_name.' '.$application->borrower->last_name,
                                $application->approved_loan_amount,
                                $application->disbursement_date,
                                $application->valid_from,
                                $application->approved_loan_emi                      
                                  );
                    array_push($arr, $data);
                } else {
                    $data = array (
                                $application->pin_number,
                                $application->location->name,
                                '',
                                $application->borrower->first_name,
                                $application->approved_loan_amount,
                                $application->disbursement_date,
                                $application->valid_from,
                                $application->approved_loan_emi                      
                              );
                array_push($arr, $data);
                }
            }
            //set the titles
            $sheet->fromArray($arr,null,'A1',false,false)
                  ->prependRow(array('Patient identification number','Location','Patient Name','Name of Borrower','Disbursed Amount','Date of Disbursal','EMI Date','Final EMI'
                    ));
            });
        })->export('xlsx');
    }

    public function exportDisbursedCaseData()
    {
        $query = Application::latest()->whereIN('status',['disbursed','sanctioned'])->where('type','loan');
            Excel::create('Sanctioned & Disbursed Data', function ($excel) use ($query) {
                $excel->sheet('report', function ($sheet) use ($query) {
                    $sheet->prependRow(array('PIN Number',
                                     'Status', 
                                     'Patient Name', 
                                     'Borrower Name', 
                                     'Cibil Score', 
                                     'Count of Co-borrower',
                                     'Count of Gurantor',
                                     'Borrower Marital status',
                                     'Relation with Patient',
                                     'Treatment type',
                                     'Hospital Name',
                                     'Loan to be disbursed',
                                     'Nature of Income',
                                     'Product',
                                     'Location',
                                     'Approved Tenure',
                                     'Flat rate of interest',
                                     'EMI amount',
                                     'Vaild From',
                                     'Vaild Upto',
                                     'Subvention',
                                     'Advance EMI',
                                     'Disbursement Date'
                    ));
                    // Freeze first row
                    $sheet->freezeFirstRow();
                    $query->chunk(100, function ($applications) use ($sheet) {
                        foreach($applications as $application) {            
                            $data['pin_number']=$application->pin_number;
                            $data['status']=$application->status;
                            if($application->patient) {
                                $data['patient_name']=$application->patient->first_name.' '.$application->patient->last_name;
                            } else {
                                $data['patient_name']=' ';
                            }
                            $data['borrower_name']=$application->borrower->first_name.' '.$application->borrower->last_name;
                            $data['cibil_score']=$application->cibil_score;
                            $data['no_coborrower']=$application->coborrower->count();
                            $data['no_guarantor']=$application->guarantor->count();
                            $data['marital_status']=$application->borrower->marital_status;
                            $data['relation_with_patient']=$application->borrower->relation_with_patient;
                            $data['treatment_type']=$application->treatment_type;
                            $data['approved_hospital_name']=$application->approved_hospital_name;
                            $data['approved_loan_amount']=$application->approved_loan_amount;
                            $data['nature_of_income']=$application->borrower->nature_of_income;
                            if($application->product) {
                                $data['product']=$application->product->name;
                            } else {
                                $data['product']=$application->product_id;    
                            }
                            if($application->location) {
                                $data['location']=$application->location->name;
                            } else {
                                $data['location']=$application->location_id;    
                            }
                            $data['approved_loan_tenure']=$application->approved_loan_tenure;
                            $data['flat_interest_rate']=$application->flat_interest_rate;
                            $data['approved_loan_emi']=$application->approved_loan_emi;
                            $data['valid_from']=$application->valid_from;
                            $data['valid_upto']=$application->valid_upto;
                            $data['subvention']=$application->subvention;
                            $data['advance_emi']=$application->advance_emi;
                            $data['disbursement_date']=$application->disbursement_date;
                            $sheet->appendRow($data);
                        }
                    });
                });
            })->download('xlsx');
    }

    public function exportDisbursedCaseCIBIL()
    {
        $applications = Application::where('status','disbursed')->where('type','loan')->get();
        //dd($applications->count());
        Excel::create('Disbursed_Data_CIBIL', function($excel) use ($applications) {

            $excel->sheet('Disbursed_Data_CIBIL', function($sheet) use($applications) {       
            $arr =array();
            foreach($applications as $application) {           
                $data = array (
                            $application->borrower->first_name.' '.$application->borrower->last_name,
                            $application->borrower->date_of_birth,
                            $application->borrower->gender,
                            $application->borrower->pan_card_number,
                            ' ',
                            ' ',
                            ' ',
                            $application->borrower->aadhar_card_number,
                            $application->borrower->mobile_number,
                            ' ',
                            ' ',
                            ' ',
                            $application->borrower->alternate_number,
                            $application->borrower->email,
                            ' ',
                            $application->borrower->address_line_1.' '.$application->borrower->address_line_2,
                            $application->borrower->pincode,
                            $application->pin_number,
                            $application->borrower->residence_type,
                            $application->disbursement_date
                        );
                array_push($arr, $data);
            }
            //set the titles
            $sheet->fromArray($arr,null,'A1',false,false)
                  ->prependRow(array('Consumer Name', 
                                     'Date of Birth', 
                                     'Gender', 
                                     'Income Tax ID Number', 
                                     'Passport Number',
                                     'Voter ID Number',
                                     'Driving License Number',
                                     'Universal ID Number',
                                     'Telephone No.Mobile',
                                     'Telephone No.Residence',
                                     'Telephone No.Office',
                                     'Extension Office',
                                     'Telephone No.Other',
                                     'Email ID 1',
                                     'Email ID 2',
                                     'Address 1',
                                     'PIN Code 1',
                                     'Curr/New Account No',
                                     'Rented / owned',
                                     'Date Opened/Disbursed'
                    ));
            });
        })->export('xlsx');
    }

    public function exportDisbursedData()
    {
        $given_pin=collect([
            "GF10133", "AF10985", "BF10227", "DF10336", "KF10673", "GF10138",
            "AF11002", "KF10688", "BF10246", "GF10142", "GF10140", "GF10144", "SF10092", "BF10238", "DF10289", 
            "KF10692", "PF10547", "GF10141", "GF10143", "KF10694", "GF10150", "PF10500", "KF10693", "KF10691", 
            "AF10996", "AF11005", "GF10095", "GF10088", "GF10149", "AF11006", "GF10158", "AF11004", "GF10146", 
            "AF11007", "DF10341", "PF10532", "PF10545", "PF10555", "NF10243", "KF10695", "PF10554", "PF10526", 
            "DF10332", "PF10546", "PF10480", "GF10135", "AF11014", "NF10262", "DF10344", "KF10690", "AF11010", 
            "GF10159", "GF10160", "AF11012", "PF10538", "AF11016", "DF10340", "AF11013", "BF10251", "AF11019", 
            "AF11020", "PF10529", "DF10337", "SF10094", "BF10247", "BF10252", "BF10239"   
        ]);

        $applications = Application::whereIn('pin_number',$given_pin)->where('type','loan')->get();

        Excel::create('Disbursed_Data_March', function($excel) use ($applications) {

            $excel->sheet('Disbursed_Data_March', function($sheet) use($applications) {       
            $arr =array();
            foreach($applications as $application) {     
                if ($application->patient()->count()>0 ) {
                    $data = array (
                            $application->pin_number,
                            $application->disbursement_date,
                            $application->approved_loan_amount,
                            $application->valid_from,
                            $application->approved_loan_emi,
                            $application->borrower->first_name.' '.$application->borrower->last_name,
                            $application->patient->first_name.' '.$application->patient->last_name,
                        );
                    array_push($arr, $data);
                } else {
                    $data = array (
                            $application->pin_number,
                            $application->disbursement_date,
                            $application->approved_loan_amount,
                            $application->valid_from,
                            $application->approved_loan_emi,
                            $application->borrower->first_name.' '.$application->borrower->last_name,
                            ' ',
                        );
                    array_push($arr, $data);
                }
            }
            //set the titles
            $sheet->fromArray($arr,null,'A1',false,false)
                  ->prependRow(array('PIN No', 
                                     'Disb Date', 
                                     'Disb amount', 
                                     'EMI Date', 
                                     'EMI amount',
                                     'Borrower name',
                                     'Patient Name'
                    ));
            });
        })->export('xlsx');
    }

    public function exportDMITranch()
    {
        $given_pin=collect([
            "AF10883", "AF10894", "AF10891", "SF10073", "GF10070", "DF10308", "BF10202", "BF10190", "KF10611", 
            "BF10207", "GF10068", "GF10067", "KF10617", "DF10311", "AF10897", "PF10471", "AF10905", "BF10195", 
            "PF10445", "KF10604", "AF10912", "KF10629", "AF10921", "PF10473", "KF10628", "AF10917", "BF10211", 
            "AF10922", "BF10205", "PF10479", "PF10474", "SF10084", "PF10467", "NF10233", "AF10898", "KF10642", 
            "PF10472", "KF10632", "AF10932", "AF10928", "SF10075", "PF10486", "KF10614", "SF10085", "KF10640", 
            "PF10485", "GF10102", "AF10937", "KF10648", "KF10646", "KF10647", "KF10650", "KF10657", "AF10939", 
            "DF10323", "BF10215", "DF10318", "KF10653", "BF10214", "PF10497", "AF10946", "AF10941", "KF10655", 
            "SF10083", "SF10086", "AF10940", "GF10089", "AF10948", "KF10643", "PF10489", "GF10076", "GF10099", 
            "GF10106", "AF10945", "KF10661", "KF10663", "DF10326", "AF10958", "PF10503", "AF10951", "PF10502", 
            "SF10087", "DF10325", "KF10652", "KF10666", "KF10667", "GF10107", "AF10902", "AF10953", "BF10218", 
            "GF10097", "BF10217", "KF10656", "KF10651", "KF10668", "KF10659", "KF10598", "KF10660", "KF10662", 
            "KF10665", "DF10317", "DF10324", "AF10950", "KF10644", "SF10088"   
        ]);

        $applications = Application::whereIn('pin_number',$given_pin)->where('type','loan')->get();
        
        Excel::create('DMI-Tranch', function($excel) use ($applications) {

            $excel->sheet('DMI-Tranch', function($sheet) use($applications) {
            $current_year = Carbon::now();
                
            $arr =array();
            foreach($applications as $application) {    
                $patient_dob = $application->patient->date_of_birth;
                $patient_birth_year = Carbon::parse($patient_dob);
                $patient_age = $current_year->diffInYears($patient_birth_year); 

                $borrower_dob = $application->borrower->date_of_birth;
                $borrower_birth_year = Carbon::parse($borrower_dob);
                $borrower_age = $current_year->diffInYears($borrower_birth_year);
                $data = array (
                        $application->pin_number,
                        $application->patient->first_name.' '.$application->patient->last_name,
                        $patient_age,
                        $application->borrower->gender,
                        $application->hospital_name,
                        $application->patient->mobile_number,
                        ' ',
                        $application->patient->mobile_number,
                        $application->patient->address_line_1.' '.$application->patient->address_line_2,
                        $application->patient->city,
                        $application->patient->pincode,
                        $application->borrower->first_name.' '.$application->borrower->last_name,
                        $borrower_age,
                        $application->coborrower,
                        $application->borrower->address_line_1.' '.$application->borrower->address_line_2,
                        $application->borrower->city,
                        $application->borrower->pincode,
                        $application->borrower->mobile_number,
                        $application->borrower->nature_of_income,
                        $application->borrower->borrowers_income,
                        $application->guarantor,
                        $application->treatment_type,
                        $application->cibil_score,
                        $application->borrower->result('total'),
                        $application->effective_interest_rate,
                        $application->approved_loan_amount,
                        $application->approved_loan_emi,
                        $application->approved_loan_tenure,
                        $application->product->name,
                        $application->disbursement_date,
                        $application->valid_from
                    );
                array_push($arr, $data);
            }
            //set the titles
            $sheet->fromArray($arr,null,'A1',false,false)
                  ->prependRow(array('Pin Number', 
                                     'Patient Name', 
                                     'Age', 
                                     'Gender', 
                                     'Name of The Hospital',
                                     'Patient Cell phone',
                                     'Patient Nature of Income',
                                     'Patient Contact Number',
                                     'Patient Address 1',
                                     'Patient Location',
                                     'Patient Pin code',
                                     'Name of Borrower',
                                     'Age of Borrower',
                                     'Relationship with Patient (Co-Borrower1)',
                                     'Borrower Resi. Address 1',
                                     'Borrower Resi. Location',
                                     'Resi. Pin code Borrower',
                                     'Borrower cell phone (Resi.)',
                                     'Borrower Nature of Income',
                                     'Total monthly family income',
                                     'Name of Guarantor',
                                     'Type of Procedure',
                                     'CIBIL SCORE(Borrower)',
                                     'Psychometric test (Borrower)',
                                     'IRR',
                                     'Disbursed Amount',
                                     'Final EMI',
                                     'Loan Tenure',
                                     'Product',
                                     'Date of Disbursal',
                                     '1st EMI month'



                    ));
            });
        })->export('xlsx'); 
    }

    public function exportDisbursedCases()
    {
        $applications = Application::whereIn('status',['disbursed'])->where('type','loan')->get();
        //dd($applications->count());
        Excel::create('Disbursed Loan Cases', function($excel) use ($applications) {

            $excel->sheet('Disbursed Loan Cases', function($sheet) use($applications) {       
            $arr =array();
            foreach($applications as $application) {
                if ($application->familyMembers()->count()>0 ) {
                    $data = array (
                                $application->pin_number,
                                $application->type,
                                $application->borrower->first_name.' '.$application->borrower->last_name,
                                $application->borrower->mobile_number,
                                $application->borrower->address_line_1.' '.$application->borrower->address_line_2,
                                $application->borrower->email,
                                $application->borrower->pan_card_number,
                                $application->borrower->aadhar_card_number,                    
                                $application->borrower->gender,
                                $application->borrower->date_of_birth,
                                $application->borrower->nature_of_income,
                            );
                    foreach ($application->familyMembers as $familyMember) {
                        array_push($data, $familyMember->first_name.' '.$familyMember->last_name);
                        array_push($data, $familyMember->relation);
                        array_push($data, $familyMember->date_of_birth);
                        array_push($data, $familyMember->gender);
                    }
                    array_push($arr, $data);
                } else {
                    $data = array (
                                $application->pin_number,
                                $application->type,
                                $application->borrower->first_name.' '.$application->borrower->last_name,
                                $application->borrower->mobile_number,
                                $application->borrower->address_line_1.' '.$application->borrower->address_line_2,
                                $application->borrower->email,
                                $application->borrower->pan_card_number,
                                $application->borrower->aadhar_card_number,
                                $application->borrower->gender,
                                $application->borrower->date_of_birth,
                                $application->borrower->nature_of_income,
                                ' '                      
                              );
                array_push($arr, $data);
                }
            }
            //set the titles
            $sheet->fromArray($arr,null,'A1',false,false)
                  ->prependRow(array('PIN Number','Type', 'Borrower Name', 'Mobile Number', 'Address', 
                    'Email', 'PAN Number', 'Aadhar Number', 'Gender', 'Date of Birth', 'Nature of Income','Family Member 1','Relation','Date of Birth','Gender','Family Member 2','Relation','Date of Birth','Gender','Family Member 3','Relation','Date of Birth','Gender','Family Member 4','Relation','Date of Birth','Gender'));
            });
        })->export('xlsx');
    }

    public function exportDisbursedDataForMay()
    {
        $applications = Application::whereBetween('id',[5332,5529])->where('type','loan')->where('status','disbursed')->get();
        Excel::create('Disbursed_Data_March', function($excel) use ($applications) {

            $excel->sheet('Disbursed_Data_March', function($sheet) use($applications) {       
            $arr =array();
            foreach($applications as $application) {     
                if ($application->patient()->count()>0 ) {
                    $data = array (
                            $application->pin_number,
                            $application->patient->first_name.' '.$application->patient->last_name,
                            $application->borrower->first_name.' '.$application->borrower->last_name,
                            $application->approved_loan_emi,
                            $application->valid_from,
                            $application->approved_loan_tenure
                        );
                    array_push($arr, $data);
                } else {
                    $data = array (
                            $application->pin_number,
                            ' ',
                            $application->borrower->first_name.' '.$application->borrower->last_name,
                            $application->approved_loan_emi,
                            $application->valid_from,
                            $application->approved_loan_tenure
                        );
                    array_push($arr, $data);
                }
            }
            //set the titles
            $sheet->fromArray($arr,null,'A1',false,false)
                  ->prependRow(array('PIN No', 
                                     'Patient Name',
                                     'Borrower name',
                                     'EMI Amount',
                                     'EMI Date', 
                                     'Loan Tenure'
                                     
                                     
                                     
                    ));
            });
        })->export('xlsx');
    }

    public function exportAllApplications()
    {
        $applications = Application::where('type','loan')->whereIn('status',['disbursed','closed'])->get();
        //dd($applications->count());
        Excel::create('Disbursed Loan App(29-10-18)', function($excel) use ($applications) {
            $excel->sheet('Disbursed Loan App(29-10-18)', function($sheet) use($applications) {       
            $arr =array();
            foreach($applications as $application) {            
                    $data = array (
                                $application->id,
                                $application->type,
                                $application->cibil_score,
                                $application->hospital_name,
                                $application->approved_hospital_name,
                                $application->total_borrowers_income,
                                $application->calculated_income,
                                $application->calculated_loan_amount,
                                $application->calculated_loan_emi,
                                $application->calculated_loan_tenure,
                                $application->approved_loan_amount,
                                $application->approved_loan_emi,
                                $application->approved_loan_tenure,
                                $application->treatment_type,
                                $application->estimated_cost,
                                $application->loan_required,
                                $application->status,
                                $application->other_expense,
                                $application->requested_tenure,
                                $application->requested_emi,
                                $application->interest_rate,
                                $application->subvention,
                                $application->processing_fee,
                                $application->pin_number,
                                $application->reference_code,
                                $application->created_at,
                                $application->updated_at,
                                $application->referrer_id,
                                $application->referrer_company_id,
                                $application->valid_from,
                                $application->valid_upto,
                                $application->disbursement_date,
                                $application->product_id,
                                $application->location_id,
                                $application->card_no,
                                $application->rejection_reason_id,
                                $application->partner_reference_code,
                                $application->arogya_card_id,
                                $application->rejection_note,
                                $application->enable_psychometric_test,
                                $application->test_language,
                                $application->documentation_charge,
                                $application->advance_emi,
                                $application->dmi_status,
                                $application->dmi_issue_date,
                                $application->dmi_sent,
                                $application->self_patient,
                                $application->merchant,
                                $application->mode_of_payment,
                                $application->foir,
                                $application->bank_customer_name,
                                $application->bank_name,
                                $application->bank_account_number,
                                $application->lead_id                                                     
                              );
                array_push($arr, $data);                
            }
            //set the titles
            $sheet->fromArray($arr,null,'A1',false,false)
                  ->prependRow(array(
                        'id', 'type', 'cibil_score', 'hospital_name', 'approved_hospital_name', 'total_borrowers_income', 'calculated_income', 'calculated_loan_amount', 'calculated_loan_emi', 'calculated_loan_tenure', 'approved_loan_amount', 'approved_loan_emi', 'approved_loan_tenure', 'treatment_type', 'estimated_cost', 'loan_required', 'status', 'other_expense', 'requested_tenure', 'requested_emi', 'interest_rate', 'subvention', 'processing_fee', 'pin_number', 'reference_code', 'created_at', 'updated_at', 'referrer_id', 'referrer_company_id', 'valid_from', 'valid_upto', 'disbursement_date', 'product_id', 'location_id', 'card_no', 'rejection_reason_id', 'partner_reference_code', 'arogya_card_id', 'rejection_note', 'enable_psychometric_test', 'test_language', 'documentation_charge', 'advance_emi', 'dmi_status', 'dmi_issue_date', 'dmi_sent', 'self_patient', 'merchant', 'mode_of_payment', 'foir', 'bank_customer_name', 'bank_name', 'bank_account_number', 'lead_id'                                     
                    ));
            });
        })->export('xlsx');
    }

    public function exportAllBorrowers()
    {
        $applications = Application::where('type','loan')->whereIn('status',['disbursed','closed'])->get();
        //dd($applications->count());
        Excel::create('Disbursed Loan Borr(29-10-18)', function($excel) use ($applications) {

            $excel->sheet('Disbursed Loan Borr(29-10-18)', function($sheet) use($applications) {       
            $arr =array();
            foreach($applications as $application) {
                foreach ($application->borrowers as $borrower) {
                    $data = array (
                        $borrower->id,
                        $borrower->application_id,
                        $borrower->type,
                        $borrower->first_name,
                        $borrower->middle_name,
                        $borrower->last_name,
                        $borrower->date_of_birth,
                        $borrower->gender,
                        $borrower->mobile_number,
                        $borrower->email,
                        $borrower->residence_type,
                        $borrower->city,
                        $borrower->state,
                        $borrower->pincode,
                        $borrower->address_line_1,
                        $borrower->address_line_2,
                        $borrower->marital_status,
                        $borrower->borrowers_income,
                        $borrower->earning_since,
                        $borrower->nature_of_income,
                        $borrower->source_of_income,
                        $borrower->employer_details,
                        $borrower->name_of_firm,
                        $borrower->income_itr,
                        $borrower->current_loan_emi,
                        $borrower->education_expenses,
                        $borrower->house_rent,
                        $borrower->number_of_dependants,
                        $borrower->other_earnings,
                        $borrower->other_earnings_type,
                        $borrower->monthly_emi_possible,
                        $borrower->id_proof_type,
                        $borrower->id_proof_number,
                        $borrower->pan_card_number,
                        $borrower->aadhar_card_number,
                        $borrower->created_at,
                        $borrower->updated_at,
                        $borrower->alternate_number,
                        $borrower->relation_with_patient,
                        $borrower->residing_since,
                        $borrower->permanent_address,
                        $borrower->permanent_city,
                        $borrower->permanent_state,
                        $borrower->permanent_pincode                                                     
                                  );
                    array_push($arr, $data);
                }          
            }
            //set the titles
            $sheet->fromArray($arr,null,'A1',false,false)
                  ->prependRow(array(
                        'id', 'application_id', 'type', 'first_name', 'middle_name', 'last_name', 'date_of_birth', 'gender', 'mobile_number', 'email', 'residence_type', 'city', 'state', 'pincode', 'address_line_1', 'address_line_2', 'marital_status', 'borrowers_income', 'earning_since', 'nature_of_income', 'source_of_income', 'employer_details', 'name_of_firm', 'income_itr', 'current_loan_emi', 'education_expenses', 'house_rent', 'number_of_dependants', 'other_earnings', 'other_earnings_type', 'monthly_emi_possible', 'id_proof_type', 'id_proof_number', 'pan_card_number', 'aadhar_card_number', 'created_at', 'updated_at', 'alternate_number', 'relation_with_patient', 'residing_since', 'permanent_address', 'permanent_city', 'permanent_state', 'permanent_pincode'                                      
                    ));
            });
        })->export('xlsx');
    }

    public function exportAllPatients()
    {
        $applications = Application::where('type','loan')->whereIn('status',['disbursed','closed'])->get();
        //dd($applications->count());
        Excel::create('Disbursed Loan Pat(29-10-18)', function($excel) use ($applications) {

            $excel->sheet('Disbursed Loan Pat(29-10-18)', function($sheet) use($applications) {       
            $arr =array();
            foreach($applications as $application) {
                if ($application->patient()->count()>0 ) {
                    $data = array (
                                $application->patient->id,
                                $application->patient->application_id,
                                $application->patient->first_name,
                                $application->patient->middle_name,
                                $application->patient->last_name,
                                $application->patient->date_of_birth,
                                $application->patient->gender,
                                $application->patient->mobile_number,
                                $application->patient->created_at,
                                $application->patient->updated_at,
                                $application->patient->address_line_1,
                                $application->patient->address_line_2,
                                $application->patient->city,
                                $application->patient->state,
                                $application->patient->pincode,
                                $application->patient->pan_card,
                                $application->patient->aadhar_card,
                                $application->patient->driving_id,
                                $application->patient->voting_id,
                                $application->patient->residing_since,
                                $application->patient->marital_status,
                                $application->patient->permanent_address,
                                $application->patient->permanent_city,
                                $application->patient->permanent_state,
                                $application->patient->permanent_pincode                                                     
                              );
                array_push($arr, $data);    
                }
                    
            }
            //set the titles
            $sheet->fromArray($arr,null,'A1',false,false)
                  ->prependRow(array(
                        'id', 'application_id', 'first_name', 'middle_name', 'last_name', 'date_of_birth', 'gender', 'mobile_number', 'created_at', 'updated_at', 'address_line_1', 'address_line_2', 'city', 'state', 'pincode', 'pan_card', 'aadhar_card', 'driving_id', 'voting_id', 'residing_since', 'marital_status', 'permanent_address', 'permanent_city', 'permanent_state', 'permanent_pincode'                                      
                    ));
            });
        })->export('xlsx');
    }

    public function exportAllFamilyMember()
    {
        $applications = Application::where('type','card')->where('status','!=','rejected')->get();
        //dd($applications->count());
        Excel::create('All Card Family Members', function($excel) use ($applications) {

            $excel->sheet('All Card Family Members', function($sheet) use($applications) {       
            $arr =array();
            foreach($applications as $application) {
                foreach ($application->familyMembers as $familyMember) {
                    $data = array (
                                $familyMember->id,
                                $application->id,
                                $familyMember->first_name.' '.$familyMember->last_name,
                                $familyMember->relation,
                                $familyMember->date_of_birth,
                                $familyMember->gender                                                   
                              );
                    array_push($arr, $data);    
                }
            }    
            //set the titles
            $sheet->fromArray($arr,null,'A1',false,false)
                  ->prependRow(array(
                        'id', 'application_id', 'first_name', 'last_name', 'relation', 'date_of_birth', 'gender'                                      
                    ));
            });
        })->export('xlsx');
    }

    public function getHealthFinapplications()
    { 
        $applications = Application::where('partner_reference_code','healthfin')->get();
        //dd($applications->count());
        Excel::create('Health-Fin-Applications', function($excel) use ($applications) {

            $excel->sheet('Health-Fin-Applications', function($sheet) use($applications) {       
            $arr =array();
            foreach($applications as $application) {            
                $data = array (
                                $application->id,
                                $application->created_at,              
                                $application->pin_number,
                                $application->borrower->first_name.' '.$application->borrower->last_name,
                                $application->status
                              );
                array_push($arr, $data);
            }
            //set the titles
            $sheet->fromArray($arr,null,'A1',false,false)
                  ->prependRow(array('Application_id','Date','PIN','Borrower Name','Status'
                    ));
            });
        })->export('xlsx');
    }

    public function updatePsychometricTest()
    {   $applications = Application::where('id',7679)->get();
        //dd($applications->count());
        foreach ($applications as $application) {
            if ($application->borrower) {
                 if ($application->borrower->answers->count()>0) {
                    $data['application_id'] = $application->id;
                    $result = $application->borrower->result('total');
                    if($result=='accept') {
                        $data['result'] = 'Accepted';
                    } else {
                        $data['result'] = 'Rejected';
                    }
                    $data['test_url'] = "/admin/application/test-result/".$application->borrower->id;
                    $psychometric_test = PsychometricTest::updateOrCreate($data);
                }
            }           
        }
        return "psychometric test updated";
        //dd($application->count());
    }

    public function importApplicationsForm()
    {   
        $title = "Import Applications";
        return view('admin.pages.application.import',['title'=>$title]);
    }

    public function importApplications(Request $input)
    {        
        if ($input->hasFile('sample_file')) {
            $path = $input->file('sample_file')->getRealPath();
            //dd($path);
            $data = \Excel::load($path)->get();
            //dd($data);
            if ($data->count()>0) {
                $sheets = $data->toArray();
                $data = $data->toArray();
                //dd($sheets);
                //dd($data);
                foreach ($data as $row) {
                    //dd($row,$row['valid_from']->format('Y-m'));
                    $applications = Application::where('id',(int)$row['id'])->get();
                    //dd($applications);
                    foreach ($applications as $application) {
                        if($application) {
                            $valid_from = Carbon::parse($application->getOriginal('valid_from'));
                            //dd($valid_from);
                            $yr_mnth =  $row['valid_from']->format('Y-m');
                            $application->valid_from = $yr_mnth.'-'.$valid_from->format('d');
                            $application->advance_emi = (int)$row['adv_emi'];
                            $application->save(); 
                        }                       
                    }                                 
                }
                dd('date updated');
                //$data = $data[0];
                //dd($data);
                //$check_name_duplication = $this->checkNameDuplication($data);
                //$check_mobile_duplication = $this->checkMobileDuplication($data);*/
                /*$given_pins = collect();
                $match_rows = collect();
                foreach ($data as $key => $value) {
                    $patient_identification_number = preg_replace('/\s+/', '', $value['patient_identification_number']);
                    $given_pins->push($patient_identification_number);
                }
                $match_rows=Application::whereIn('pin_number',$given_pins)->get();
                $applications = $match_rows->groupBy('pin_number');
                Excel::create('Pending', function($excel) use ($applications) {

                $excel->sheet('Match PIN', function($sheet) use($applications) {       
                    $arr =array();
                    foreach($applications as $keys=>$values) {
                            
                            foreach ($values as $key => $value) {
                                 $data =  array(
                                    $keys,
                                    $value['id'],
                                    $value['type'],
                                    $value['status']);
                                array_push($arr, $data);
                            }                        
                    }
                    //set the titles
                    $sheet->fromArray($arr,null,'A1',false,false)
                        ->prependRow(array('PIN','Application_id','Type','Status'));
                });
            })->export('xlsx');*/
                /*dd('exported');
                $match_pins = $match_rows->pluck('pin_number');
                $present_pin = $given_pins->intersect($match_pins);
                $not_present_pin = $given_pins->diff($present_pin);
                dd($present_pin->toArray(),$not_present_pin->toArray());*/
                
                /*if($data[1]['co_borrower_name']){
                    dd($data[1]['co_borrower_name']);
                } else {
                    dd('no');
                }
                dd($data);*/
                //dd($data);
                
                foreach ($sheets as $row) {
                        //dd($data[0]['borrower_date_of_birth']);
                        /***  Application Data  ***/
                        $application_data['type']='loan';
                        $application_data['status']='disbursed';
                        $application_data['pin_number']=$row['patient_identification_number'];
                        if($row['treatment_type']){
                            $application_data['treatment_type']=$row['treatment_type'];    
                        } else {
                            $application_data['treatment_type']='N/A';
                        }
                        $application_data['cibil_score']=(int)$row['cibil_score'];
                        if($row['hospital_name']){
                            $application_data['hospital_name']=$row['hospital_name'];
                            $application_data['approved_hospital_name']=$row['hospital_name'];    
                        } else {
                            $application_data['hospital_name']='N/A';
                            $application_data['approved_hospital_name']='N/A';
                        }
                        $application_data['total_borrowers_income']=(int)$row['total_monthly_family_income'];
                        $application_data['location_id']=(int)$row['location'];    
                        $application_data['documentation_charge']=(int)$row['document_charges'];
                        $application_data['processing_fee']=((int)$row['processing_charges']/(int)$row['disbursed_amount']) * 100;
                        $application_data['subvention']=(float)$row['subvention'];
                        $application_data['approved_loan_amount']=(int)$row['disbursed_amount'];
                        $application_data['approved_loan_emi']=(int)$row['final_emi'];
                        $application_data['approved_loan_tenure']=(int)$row['loan_tenure'];
                        $product = Product::where('name',$row['product'])->first();
                        if ($product) {
                            $application_data['product_id']=$product->id;
                        } else {
                            $application_data['product_id']=0;
                        }                    
                        $application_data['disbursement_date']=$row['date_of_disbursal'];
                        $application_data['valid_from']=$row['first_emi_month'];
                        $application_data['advance_emi']=(int)$row['no_of_advance_emi'];
                        $application_data['foir']=$row['foir'];
                        $application_data['self_patient']=$row['self_patient'];
                        $application = Application::create($application_data);
                        $application->created_at=$row['application_created_at'];
                        $application->save();                        
                        
                        /***  Psychometric Test Data  ***/
                        $psychometric_data['application_id'] = $application->id;
                        $psychometric_data['result'] = $row['psychometric_test_result'];
                        $psychometric_data['test_url'] = '#';
                        $application->psychometricTest()->create($psychometric_data);

                        /***  Borrower Data  ***/
                        $borrower_data['type']='primary';
                        $borrower_data['first_name']=$row['borrower_first_name'];
                        $borrower_data['last_name']=$row['borrower_last_name'];

                        if($row['borrower_date_of_birth']){
                            $borrower_data['date_of_birth']=Carbon::parse($row['borrower_date_of_birth'])->format('Y-m-d');    
                        } else {
                            $borrower_data['date_of_birth']='0001-01-01';
                        }                        
                        if($row['borrower_aadhar_number']){
                            $borrower_data['id_proof_type']='Aadhaar Card';
                            $borrower_data['id_proof_number']=$row['borrower_aadhar_number']; 
                            $borrower_data['aadhar_card_number']=$row['borrower_aadhar_number'];    
                        } else {
                            $borrower_data['aadhar_card_number']='N/A';
                        }
                        if($row['borrower_pan_number']){
                            $borrower_data['pan_card_number']=$row['borrower_pan_number'];                            
                            $borrower_data['id_proof_type']='PAN Card';
                            $borrower_data['id_proof_number']=$row['borrower_pan_number']; 
                        } else {
                            $borrower_data['pan_card_number']='N/A';
                        }
                        $borrower_data['relation_with_patient']=$row['borrower_relationship_with_patient'];
                        $borrower_data['address_line_1']=$row['borrower_addressline_1'];
                        if($row['borrower_addressline_2']){
                            $borrower_data['address_line_2']=$row['borrower_addressline_2'];    
                        } else {
                            $borrower_data['address_line_2']='N/A';
                        }
                        if($row['borrower_city']){
                            $borrower_data['city']=$row['borrower_city'];    
                        } else {
                            $borrower_data['city']='N/A';
                        }                      
                        $borrower_data['pincode']=(int)$row['borrower_pin_code'];
                        $borrower_data['alternate_number']=$row['borrower_alternate_number'];
                        if($row['borrower_mobile_number']){
                            $borrower_data['mobile_number']=$row['borrower_mobile_number'];    
                        } else {
                            $borrower_data['mobile_number']='0';
                        }
                        if($row['borrower_nature_of_income']){
                            $borrower_data['nature_of_income']=$row['borrower_nature_of_income'];    
                        } else {
                            $borrower_data['nature_of_income']='N/A';
                        }
                        $borrower_data['borrowers_income']=(int)$row['total_monthly_family_income'];                  
                        $borrower = $application->borrower()->create($borrower_data);
                        //dd($borrower);
                        /***  Co-Borrower Data  ***/
                        if ($row['co_borrower_first_name']) {
                            $co_borrower_data['type']='co-borrower';
                            $co_borrower_data['first_name']=$row['co_borrower_first_name'];
                            $co_borrower_data['last_name']=$row['co_borrower_last_name'];
                            $co_borrower_data['relation_with_patient']=$row['co_borrower_relationship_with_patient'];
                            $co_borrower_data['address_line_1']=$row['co_borrower_addressline_1'];
                            if($row['co_borrower_addressline_2']){
                                $co_borrower_data['address_line_2']=$row['co_borrower_addressline_2'];    
                            } else {
                                $co_borrower_data['address_line_2']='N/A';
                            }
                            if($row['co_borrower_city']){
                                $co_borrower_data['city']=$row['co_borrower_city'];    
                            } else {
                                $co_borrower_data['city']='N/A';
                            }  
                            $co_borrower_data['pincode']=(int)$row['co_borrower_pin_code'];
                            $co_borrower_data['alternate_number']=$row['co_borrower_alternate_number'];
                            if($row['co_borrower_mobile_number']){
                                $co_borrower_data['mobile_number']=$row['co_borrower_mobile_number'];    
                            } else {
                                $co_borrower_data['mobile_number']='0';
                            }
                            $co_borrower = $application->borrowers()->create($co_borrower_data);
                        }
                        
                        /***  Guarantor Data  ***/
                        if ($row['guarantor_first_name']) {
                            $guarantor_data['type']='guarantor';
                            $guarantor_data['first_name']=$row['guarantor_first_name'];
                            $guarantor_data['last_name']=$row['guarantor_last_name'];
                            $guarantor_data['relation_with_patient']=$row['guarantor_relationship_with_patient'];
                            $guarantor_data['address_line_1']=$row['guarantor_addressline_1'];
                            if($row['guarantor_addressline_2']){
                                $guarantor_data['address_line_2']=$row['guarantor_addressline_2'];    
                            } else {
                                $guarantor_data['address_line_2']='N/A';
                            }
                            if($row['guarantor_city']){
                                $guarantor_data['city']=$row['guarantor_city'];    
                            } else {
                                $guarantor_data['city']='N/A';
                            } 
                            $guarantor_data['pincode']=(int)$row['guarantor_pin_code'];
                            $guarantor_data['alternate_number']=$row['guarantor_alternate_number'];
                            if($row['guarantor_mobile_number']){
                                $guarantor_data['mobile_number']=$row['guarantor_mobile_number'];    
                            } else {
                                $guarantor_data['mobile_number']='0';
                            }
                            $guarantor = $application->borrowers()->create($guarantor_data);
                        }
                        
                        /***  Patient Data  ***/
                        if ($row['self_patient']==1) {
                            $patient_data['first_name']=$row['borrower_first_name'];
                            $patient_data['last_name']=$row['borrower_last_name'];
                            if($row['patient_gender']){
                                $patient_data['gender']=$row['patient_gender'];    
                            } else {
                                $patient_data['gender']='N/A';
                            }
                            if($row['borrower_date_of_birth']){
                                $patient_data['date_of_birth']=Carbon::parse($row['borrower_date_of_birth'])->format('Y-m-d');    
                            } else {
                                $patient_data['date_of_birth']='0001-01-01';
                            }  
                            if($row['borrower_mobile_number']){
                                $patient_data['mobile_number']=$row['borrower_mobile_number'];    
                            } else {
                                $patient_data['mobile_number']='0';
                            }
                            if($row['borrower_addressline_1']){
                                $patient_data['address_line_1']=$row['borrower_addressline_1'];    
                            } else {
                                $patient_data['address_line_1']='N/A';
                            }
                            if($row['borrower_addressline_2']){
                                $patient_data['address_line_2']=$row['borrower_addressline_2'];    
                            } else {
                                $patient_data['address_line_2']='N/A';
                            }
                            if($row['borrower_city']){
                                $patient_data['city']=$row['borrower_city'];    
                            } else {
                                $patient_data['city']='N/A';
                            }
                            if($row['borrower_aadhar_number']){
                                $patient_data['aadhar_card']=$row['borrower_aadhar_number'];    
                            } else {
                                $patient_data['aadhar_card']='N/A';
                            }
                            if($row['borrower_pan_number']){
                                $patient_data['pan_card']=$row['borrower_pan_number'];                            
                            } else {
                                $patient_data['pan_card']='N/A';
                            }
                            $patient_data['pincode']=(int)$row['borrower_pin_code'];
                            $patient = $application->patient()->create($patient_data);
                        } else {
                            $patient_data['first_name']=$row['patient_first_name'];
                            $patient_data['last_name']=$row['patient_last_name'];
                            if($row['patient_gender']){
                                $patient_data['gender']=$row['patient_gender'];    
                            } else {
                                $patient_data['gender']='N/A';
                            }
                            if($row['patient_mobile_number']){
                                $patient_data['mobile_number']=$row['patient_mobile_number'];    
                            } else {
                                $patient_data['mobile_number']='0';
                            }
                            if($row['patient_addressline_1']){
                                $patient_data['address_line_1']=$row['patient_addressline_1'];    
                            } else {
                                $patient_data['address_line_1']='N/A';
                            }
                            if($row['patient_addressline_2']){
                                $patient_data['address_line_2']=$row['patient_addressline_2'];    
                            } else {
                                $patient_data['address_line_2']='N/A';
                            }
                            if($row['patient_city']){
                                $patient_data['city']=$row['patient_city'];    
                            } else {
                                $patient_data['city']='N/A';
                            }
                            $patient_data['pincode']=(int)$row['patient_pin_code'];
                            $patient = $application->patient()->create($patient_data);
                        }
                }
            }
        }
        
        Session::flash('info','Application imported Successfully');
        
        return redirect('/testing/import-applications');
    }

    public function getCalculation($application, $row)
    {
        $estimatedCost = $application->estimated_cost;      
        $loanRequired = (int)$row['loan_required'];
        $borrowersIncome = (int)$row['borrowers_income'];
        $incomeItr = (int)$row['borrower_income_itr'];
        $currentLoanEmi = (int)$row['borrower_current_loan_emi'];
        $educationExpense = (int)$row['borrower_education_expenses'];
        $houseRent = (int)$row['borrower_house_rent'];
        //$otherExpenses = (int)$row['other_expense'];
        $numberOfDependants = (int)$row['borrower_number_of_dependants'];
        $otherEarnings = (int)$row['borrower_other_earnings'];
        $monthlyEmiPossible = (int)$row['requested_emi'];
        $requestedTenure = (int)$row['requested_tenure'];

        //setting defualt value for otherEarnings
        $otherEarnings = $otherEarnings?$otherEarnings:0;
        
        // total income cal of borrower from borrwerincome iput and other earning
        $totalBorrowerIncome = $borrowersIncome + (($otherEarnings) * 0.5);

        // the extra expenses after users income and other things
        $otherExpense = (($educationExpense + $houseRent) + (($numberOfDependants - 3) * 2000)) - ($totalBorrowerIncome * 0.5);
        if ($otherExpense<0) {
            $otherExpense=0;
        } else {
            $otherExpense=$otherExpense;
        }       

        // use to calculate the max limit of income of user and giving the highest value of the incomes
        $originalIncome1 = $totalBorrowerIncome - $currentLoanEmi;
        $originalIncome2 = ($incomeItr / 12) - $currentLoanEmi;

        // calculated montly income
        $calculatedMonthlyIncome = max($originalIncome1, $originalIncome2);

        // the emi which the user can pay to the loan provider with only 25% risk
        $calculatedMonthlyEmi = ($calculatedMonthlyIncome - $otherExpense) * 0.25;
        
        $treatment_types = collect(["Cardiology (Heart Valves/Surgery)","CRDM (Pace Makers)"]);

        if ($treatment_types->contains($application->treatment_type)) {
            $maxLoanEligible = ($calculatedMonthlyEmi * 36) / 1.2475;
        } else {
            $maxLoanEligible = ($calculatedMonthlyEmi * 36) / 1.36;
        }

        // gives the min loan amount user can get.change
        if ($application->type=="loan" && !$treatment_types->contains($application->treatment_type)) {            
            $loanNeededUser = $estimatedCost * 0.75;            
            $approvedLoanAmount = min($loanNeededUser, $loanRequired, $maxLoanEligible,300000);
            // final emi given to the user to pay monthly        
            $approvedLoanEmi = $approvedLoanAmount * (1 + (0.12 * ($requestedTenure / 12))) / $requestedTenure;
            $approvedLoanEmi=(int)round($approvedLoanEmi,0);
        }   
        if ($application->type=="card") {            
            $approvedLoanAmount = min($loanRequired, $maxLoanEligible,300000);
            $approvedLoanAmount =(int)$approvedLoanAmount+170000;          
            $significance = 25000;
            $approvedLoanAmount=ceil($approvedLoanAmount/$significance)*$significance;

            if ($approvedLoanAmount<300000) {
                $approvedLoanAmount=$approvedLoanAmount;               
            } else {
                $approvedLoanAmount=300000;                
            }
            // final emi given to the user to pay monthly
            $approvedLoanEmi = $approvedLoanAmount * (1 + (0.12 * ($requestedTenure / 12))) / $requestedTenure;
            $approvedLoanEmi=(int)round($approvedLoanEmi,0);
        }    

        if ($application->type=="loan" && $treatment_types->contains($application->treatment_type)) {            
            $loanNeededUser = $estimatedCost * 0.85;
            $approvedLoanAmount = min($loanNeededUser, $loanRequired, $maxLoanEligible);
            // final emi given to the user to pay monthly        
            $approvedLoanEmi = $approvedLoanAmount * (1 + (0.0825 * ($requestedTenure / 12))) / $requestedTenure;
            $approvedLoanEmi=(int)round($approvedLoanEmi,0);
        }

        // calculates the months in which emi should be paid back to arogya finance        
        if ($approvedLoanEmi > $monthlyEmiPossible) {
            $approvedLoanTenure = 36;
        } else {
            $approvedLoanTenure = $requestedTenure;
        }
        
        // save calculations
        $application->total_borrowers_income = $totalBorrowerIncome;
        $application->other_expense = $otherExpense;
        $application->calculated_income = $calculatedMonthlyIncome;
        $application->calculated_loan_amount = $approvedLoanAmount;
        $application->calculated_loan_emi = $approvedLoanEmi;
        $application->calculated_loan_tenure = $approvedLoanTenure;

        // refrence hode
        $application->reference_code = $application->id . str_random(6);

        // update the database
        $application->save();
    }

    public function checkMobileDuplication($data)
    {
        $given_mobile_number = collect();
        $match_rows = collect();
        foreach ($data as $key => $value) {
            $borrower_mobile_number = preg_replace('/\s+/', '', $value['borrower_pan_number']);
            $given_mobile_number->push($borrower_mobile_number);
        }
        //dd($given_mobile_number);
        $match_rows=Borrower::where('type','primary')->whereIn('pan_card_number',$given_mobile_number)->get();
        $applications = $match_rows->groupBy('pan_card_number');
                Excel::create('Arogya', function($excel) use ($applications) {

                $excel->sheet('Match PAN', function($sheet) use($applications) {       
                    $arr =array();
                    foreach($applications as $key=>$values) {
                        
                        
                            $data =  array($key);
                            array_push($arr, $data);
                            foreach ($values as $key => $value) {
                            //dd($value->application);
                            if ($value->application!=null) {    
                                 $data =  array(
                                    '',
                                    $value['application_id'],
                                    $value->application->type,
                                    $value->application->status);
                                array_push($arr, $data);
                            }
                        }                           
                    }

                    //set the titles
                    $sheet->fromArray($arr,null,'A1',false,false)->prependRow(array(
                            'PAN','Application_id','Type','Status'
                        )

                    );

                });

            })->export('xlsx');
        //dd($match_rows);
        /*$match_mobile_number = $match_rows->pluck('pan_card_number');
        //dd($match_mobile_number);
        $present_mobile_number = $given_mobile_number->intersect($match_mobile_number);
        //dd($present_mobile_number);
        $not_present_mobile_number = $given_mobile_number->diff($present_mobile_number);
        dd($present_mobile_number->toArray(),$not_present_mobile_number->toArray());*/
    }

    public function checkDisbursedDuplication()
    {   
        $pin_numbers = collect();
        $application_ids = collect();      

        $applications=Application::where('status','disbursed')->where('type','loan')->get();

        $applications = $applications->groupBy('pin_number');
        //dd($applications);
        Excel::create('Checking Disbursed duplication', function($excel) use ($applications) {

        $excel->sheet('Sheet1', function($sheet) use($applications) {       
            $arr =array();
            foreach($applications as $key1=>$values) {
                    /*$data =  array($key);
                    array_push($arr, $data);*/
                    foreach ($values as $key => $value) {
                        //dd($value->documents->count());
                         $data =  array(
                            $key1,
                            $value->id,
                            $value->approved_loan_amount,
                            $value->borrower->first_name.' '.$value->borrower->middle_name.' '.$value->borrower->last_name,
                            $value->cibil_score,
                            $value->documents->count()
                            );
                        array_push($arr, $data);
                    }
                    //dd($arr);
                
            }
            //dd($arr);
            //set the titles
            $sheet->fromArray($arr,null,'A1',false,false)->prependRow(array(
                    'PIN','Application_id','Loan Amount','Borrower Name','CIBIL Score','No. of Documents'
                )

            );

        });

    })->export('xlsx');

    }

    public function checkNameDuplication($data)
    {
        /*$given_names = collect();
        $match_rows = collect();
        $full_names = collect();
        foreach ($data as $key => $value) {
            $borrower_name = preg_replace('/\s+/', ' ', strtolower($value['borrower_first_name']));
            $given_names->push($borrower_name);
        }
        $borrowers = Borrower::where('type','primary')->get();
        foreach ($borrowers as $borrower) {
            $full_names->push(strtolower($borrower->full_name));
        }
        $present_names = $given_names->intersect($full_names);
        $not_present_names = $given_names->diff($present_names);
        dd($present_names->toArray(),$not_present_names->toArray());*/

        $given_names = collect();
        $first_names = collect();
        $match_rows = collect();
        foreach ($data as $key => $value) {
            $borrower_name = preg_replace('/\s+/', ' ',strtolower($value['borrower_first_name']));
            $given_names->push($borrower_name);
        }
        //dd($given_names);
        $borrowers = Borrower::where('type','primary')->get();
        foreach ($borrowers as $borrower) {
            $first_names->push(strtolower($borrower->last_name));
        }
        //dd($first_names);
        $present_names = $given_names->intersect($first_names);
        $not_present_names = $given_names->diff($present_names);
        dd($present_names->toArray(),$not_present_names->toArray());
         
    }

    public function rejectApplications(Request $input)
    {
        $given_ids=collect(["282", "1320", "1366", "1500", "1505", "3178", "3361", "3518", "3932", "4879", "5221", "5420"]);

        $match_rows=Application::whereIn('id',$given_ids)->get();

        foreach($match_rows as $application){
            $application->pin_number="";
            $application->status="rejected";
            $application->save();
        }
        return "Status updated to rejected";
    }

    public function deleteApplications(Request $input)
    {
        $given_ids=collect(["3163", "2078", "2077", "2013", "2012", "2011", "1990", "1988", "1857", "1856", "1855", "1813", "1812", "1811", "1810", "1797", "1795", "1794", "1793", "1290", "1289", "1287", "1286", "1285", "1282", "1160", "1159", "1158", "1157", "1111", "1110", "1056", "1055", "1054", "1053", "1052", "1049", "724", "258", "257", "256", "214", "210", "209", "179", "140", "139", "127"]);

        $applications=Application::whereIn('id',$given_ids)->get();
        foreach($applications as $application){
            $existing_application = Application::find($application->id);
            Application::destroy($existing_application->id);
            $existing_borrowers = $existing_application->borrowers()->delete();
            $existing_patients = $existing_application->patient()->delete();

        }
        return "Applications deleted";
    }

    /*
    * Trim the  pin number of applications
    * 
    */
    public function trimPIN()
    {
        $match_rows=Application::where('pin_number','like','% %')->get();        
        //dd($match_rows->pluck('pin_number'));
        foreach($match_rows as $application){
            $pin_number = preg_replace('/\s+/', '', $application->pin_number);
            $application->pin_number = $pin_number;
            $application->save();
        }
        return "PIN trim done";
    }

    /*
    * Remove the  pin numbers from applications
    * 
    */
    public function removePIN()
    {
        $given_pin=collect(["3177",
"7811",
"2115",
"2161",
"2453",
"3451",
"2111",
"2785",
"2786",
"2787",
"2788",
"3414",
"2545",
"1665",
"2491",
"2513",
"3427",
"5043",
"5162",
"5218",
"3638",
"3746",
"5801",
"986",
"7809",
"3936",
"7668",
"7682",
"7800",
"5188",
"5258",
"5606",
"6010",
"6171",
"7672",
"465",
"466",
"1834",
"3944",
"3974",
"5024",
"7659"]);
        $match_rows=Application::whereIn('id',$given_pin)->get();        
       
        foreach($match_rows as $application){
            $application->pin_number="";
            $application->save();
        }
        return "PIN Removed";
    }

    public function checkDuplicateApplications()
    {
        $given_pins = collect(["AF10042","AF10083","AF10091","AF10101","AF10106","AF10110","AF10125","AF10150","AF10152","AF10177","AF10183","AF10190","AF10196","AF10217","AF10235","AF10254","AF10260","AF10282","AF10330","AF10336","AF10338","AF10346","AF10347","AF10374","AF10382","AF10383","AF10395","AF10425","AF10433","AF10438","AF10439","AF10440","AF10442","AF10453","AF10470","AF10492","AF10499","AF10509","AF10511","AF10517","AF10532","AF10535","AF10549","AF10563","AF10567","AF10578","AF10579","AF10590","AF10593","AF10599","AF10603","AF10604","AF10605","AF10606","AF10607","AF10608","AF10609","AF10611","AF10612","AF10620","AF10621","AF10626","AF10629","AF10640","AF10641","AF10642","AF10643","AF10645","AF10646","AF10647","AF10649","AF10653","AF10654","AF10657","AF10661","AF10666","AF10667","AF10668","AF10669","AF10670","AF10672","AF10673","AF10677","AF10680","AF10682","AF10685","AF10687","AF10690","AF10691","AF10694","AF10699","AF10701","AF10704","AF10707","AF10714","AF10715","AF10716","AF10725","AF10730","AF10731","AF10732","AF10734","AF10739","AF10743","AF10744","AF10746","AF10749","AF10752","AF10755","AF10756","AF10757","AF10758","AF10759","AF10760","AF10761","AF10764","AF10765","AF10769","AF10770","AF10771","AF10778","AF10781","AF10792","AF10797","AF10799","AF10800","AF10803","AF10805","AF10808","AF10816","AF10819","AF10828","AF10830","AF10831","AF10833","AF10834","AF10836","AF10839","AF10840","AF10842","AF10843","AF10844","AF10845","AF10847","AF10849","AF10852","AF10853","AF10867","AF10870","AF10872","AF10873","AF10884","AF10888","AF10889","BF10005","BF10011","BF10012","BF10017","BF10031","BF10036","BF10038","BF10041","BF10042","BF10043","BF10044","BF10050","BF10055","BF10059","BF10065","BF10079","BF10082","BF10085","BF10087","BF10095","BF10096","BF10097","BF10098","BF10103","BF10104","BF10108","BF10110","BF10111","BF10112","BF10116","BF10121","BF10122","BF10130","BF10133","BF10134","BF10139","BF10140","BF10146","BF10149","BF10152","BF10153","BF10154","BF10157","BF10159","BF10164","BF10169","BF10171","BF10172","BF10183","BF10181","BF10185","CF10003","CF10011","DF10043","DF10044","DF10051","DF10053","DF10054","DF10074","DF10075","DF10085","DF10089","DF10110","DF10117","DF10118","DF10139","DF10160","DF10167","DF10171","DF10177","DF10178","DF10180","DF10181","DF10185","DF10187","DF10190","DF10192","DF10193","DF10195","DF10199","DF10201","DF10206","DF10207","DF10208","DF10209","DF10212","DF10213","DF10214","DF10216","DF10218","DF10220","DF10222","DF10227","DF10231","DF10232","DF10233","DF10234","DF10236","DF10237","DF10240","DF10241","DF10244","DF10245","DF10246","DF10249","DF10250","DF10252","DF10254","DF10256","DF10261","DF10262","DF10264","DF10269","DF10272","DF10275","DF10276","DF10280","DF10283","DF10285","DF10288","DF10294","DF10295","DF10296","DF10297","DF10298","GF10018","GF10019","GF10023","GF10025","GF10033","GF10034","GF10036","GF10046","GF10052","GF10053","GF10054","GF10057","GF10062","GF10066","GF10072","GF10073","KF10013","KF10039","KF10087","KF10106","KF10174","KF10194","KF10221","KF10263","KF10264","KF10275","KF10281","KF10287","KF10288","KF10289","KF10292","KF10296","KF10297","KF10313","KF10314","KF10324","KF10326","KF10328","KF10333","KF10335","KF10341","KF10345","KF10347","KF10349","KF10350","KF10353","KF10355","KF10358","KF10362","KF10363","KF10364","KF10366","KF10368","KF10369","KF10376","KF10383","KF10384","KF10385","KF10387","KF10388","KF10389","KF10394","KF10395","KF10397","KF10399","KF10403","KF10406","KF10415","KF10419","KF10420","KF10423","KF10427","KF10430","KF10436","KF10437","KF10438","KF10439","KF10440","KF10442","KF10443","KF10448","KF10450","KF10451","KF10453","KF10456","KF10457","KF10460","KF10461","KF10466","KF10469","KF10470","KF10471","KF10472","KF10473","KF10474","KF10475","KF10477","KF10481","KF10490","KF10491","KF10492","KF10493","KF10495","KF10497","KF10499","KF10503","KF10507","KF10508","KF10509","KF10510","KF10511","KF10514","KF10516","KF10517","KF10518","KF10519","KF10520","KF10522","KF10523","KF10524","KF10527","KF10528","KF10532","KF10533","KF10534","KF10535","KF10537","KF10539","KF10541","KF10542","KF10543","KF10544","KF10545","KF10546","KF10547","KF10548","KF10550","KF10552","KF10553","KF10554","KF10555","KF10557","KF10560","KF10561","KF10562","KF10564","KF10565","KF10566","KF10570","KF10571","KF10572","KF10573","KF10574","KF10581","KF10582","KF10584","KF10586","KF10587","KF10588","KF10589","KF10591","KF10592","KF10594","KF10595","KF10596","KF10599","KF10600","KF10605","NF10015","NF10016","NF10043","NF10045","NF10046","NF10057","NF10058","NF10060","NF10062","NF10063","NF10064","NF10065","NF10067","NF10068","NF10072","NF10079","NF10086","NF10089","NF10091","NF10094","NF10095","NF10097","NF10101","NF10104","NF10105","NF10108","NF10109","NF10112","NF10113","NF10114","NF10118","NF10128","NF10129","NF10140","NF10150","NF10152","NF10158","NF10160","NF10182","NF10185","NF10189","NF10191","NF10202","NF10205","NF10212","NF10218","NF10226","NF10228","PF10009","PF10019","PF10025","PF10031","PF10036","PF10038","PF10043","PF10046","PF10063","PF10078","PF10079","PF10089","PF10090","PF10093","PF10095","PF10096","PF10097","PF10098","PF10099","PF10100","PF10102","PF10103","PF10104","PF10105","PF10110","PF10112","PF10115","PF10117","PF10120","PF10123","PF10124","PF10127","PF10130","PF10131","PF10135","PF10137","PF10138","PF10140","PF10141","PF10143","PF10145","PF10148","PF10149","PF10150","PF10152","PF10158","PF10159","PF10160","PF10167","PF10179","PF10180","PF10184","PF10185","PF10188","PF10190","PF10195","PF10199","PF10201","PF10210","PF10212","PF10213","PF10216","PF10221","PF10228","PF10232","PF10233","PF10256","PF10264","PF10268","PF10270","PF10272","PF10280","PF10283","PF10291","PF10299","PF10304","PF10312","PF10316","PF10321","PF10322","PF10325","PF10330","PF10333","PF10335","PF10336","PF10339","PF10340","PF10342","PF10343","PF10344","PF10348","PF10350","PF10355","PF10359","PF10363","PF10368","PF10372","PF10375","PF10376","PF10377","PF10381","PF10382","PF10384","PF10388","PF10389","PF10398","PF10399","PF10404","PF10413","PF10417","PF10420","PF10426","PF10432","PF10433","PF10439","PF10444","PF10449","PF10459","PF10460","PF10461","PF10464","PF10466","SF10011","SF10016","SF10017","SF10019","SF10026","SF10029","SF10034","SF10040","SF10042","SF10048","SF10050","SF10051","SF10055","SF10056","SF10059","SF10061","SF10066","SF10067","SF10068","SF10070","SF10071","SF10072"]);
        $applications=Application::whereIn('pin_number',$given_pins)->where('type','loan')->get();
        $applications = $applications->groupBy('pin_number');
        //dd($applications->count());
        Excel::create('Check duplicate apps dec', function($excel) use ($applications) {

                $excel->sheet('sheet1', function($sheet) use($applications) {       
                    $arr =array();
                    foreach($applications as $keys=>$values) {
                            foreach ($values as $key => $value) {
                                    $data =  array(
                                    $keys,
                                    $value->id,
                                    $value->status);
                                array_push($arr, $data);                         
                        }                           
                    }

                    //set the titles
                    $sheet->fromArray($arr,null,'A1',false,false)->prependRow(array(
                            'PIN','Application_id','Status'
                        )

                    );

                });

            })->export('xlsx');

    }

    public function sendWelcomeLetter()
    {
        $given_pin=collect(["DF10399","KF10785","KF10764","KF10781","DF10400","KF10777","AF11105","KF10773","NF10290","BF10358","GF10236","BF10350","GF10231","NF10291","NF10243","NF10248","NF10270","NF10276","NF10277","DF10401","AF11184","KF10788","KF10792","AF11195","AF11181"]);
        //dd($given_pin);
        $match_rows=Application::whereIn('pin_number',$given_pin)->where('type','loan')->where('status','disbursed')->get();
        //dd($match_rows->count());        
        
        foreach ($match_rows as $application) {
            $admin = $application->location->admin;
            $borrower = $application->borrower;
            $date = Carbon::now()->format('j F, Y');
            $approved_loan_amount=Terbilang::make($borrower->application->approved_loan_amount);          
            $approved_loan_emi=Terbilang::make($borrower->application->approved_loan_emi);

            $data = ['date'=>$date, 'borrower'=>$borrower,
                     'approved_loan_amount'=>$approved_loan_amount,
                     'approved_loan_emi'=>$approved_loan_emi
                    ];
                    
            $pdf = PDF::loadView('admin.pages.application.sanction_letters.first_letter', $data)->setPaper('a4');
            //return view ('admin.pages.application.sanction_letters.first_letter')->with($data);
            $mandate = true;
            Mail::send('emails.admin.send_first_letter', 
                ['application'=>$application, 'mandate'=>$mandate, 'admin'=>$admin],
                    function ($mail) use ($admin, $application,$pdf)
                    {
                        $mail->to($admin->email, 'Arogya Finance')
                             ->subject($application->pin_number.'_Welcome_Letter')
                             ->attachData($pdf->output(),$application->pin_number.'_Welcome_Letter.pdf');     
                    });            
            $mandate = false;
            Mail::send('emails.admin.send_first_letter', 
                ['application'=>$application, 'mandate'=>$mandate, 'admin'=>$admin],
                    function ($mail) use ($admin, $application,$pdf)
                    {
                        $mail->to($application->borrower->email, 'Arogya Finance')
                             ->subject($application->pin_number.'_Welcome_Letter')
                             ->attachData($pdf->output(),$application->pin_number.'_Welcome_Letter.pdf');     

                    });
        }

        return "Mail Sent";
    }

    /**
     * [assign a reference code to all the application where reference code is empty]
     * @return [string] [success message]
     */
    public function generateReferenceCode()
    {
        $applications = Application::where('reference_code',' ')->get();
        foreach ($applications as $application) {
            $application->reference_code = $application->id . str_random(6);
            $application->save();
        }

        return "Reference Code generated.";
    }

    public function updateLACReferenceCode()
    {
        $card_applications = Application::where('type','card')->get();

        foreach ($card_applications as $card_application) {
            foreach ($card_application->arogyaLoans as $loan) {
                if ($card_application->reference_code==$loan->reference_code) {
                    $loan->reference_code = $loan->id . str_random(6);
                    $loan->save();
                }    
            }    
        }
        return "Loan Against Card Reference Code updated.";
    }

    public function generateIdealRepaymentReport()
    {
        ini_set('max_execution_time', 60000);
        $overdue_month = "2019-03-31";
        $applications =Application::where('type','loan')
            ->whereIn('status',['disbursed','closed'])
            ->where('disbursement_date','<=',$overdue_month)->get();
        //dd($applications->count());
        Excel::create('Income Computation Report', function($excel) use ($applications) {

            $excel->sheet('Repayment Report', function($sheet) use($applications) {
            $overdue_month = "2019-03-31";
            $arr =array();
            foreach($applications as $application) {
                //dd($application);
                $ideal_repayment_schedules = $application->idealRepaymentSchedule();
                $repayments = $ideal_repayment_schedules->filter(
                        function ($data) use ($overdue_month) {
                            return $data['emi_month'] <= $overdue_month;
                        });
                //$repayments = $ideal_repayment_schedules;
                //dd($repayments);
                $advance_emi = $repayments->where('type','advance_emi')->first();
                if($advance_emi) {
                    $advance_emi = $advance_emi;
                } else {
                    $advance_emi = null;
                }
                //dd($repayments->where('type','advance_emi'));

                if($repayments->count()>0) {
                    if($advance_emi!=null) {
                        $data = array (
                        $application->id,
                        $application->pin_number,
                        $application->approved_loan_amount,
                        $application->disbursement_date,
                        $application->valid_from,
                        $application->valid_upto,
                        $application->approved_loan_tenure,
                        $application->interest_rate,
                        $application->subvention,
                        $application->effective_interest_rate,
                        $repayments->sum('emi'),
                        $repayments->sum('principal'),
                        $repayments->sum('interest'),
                        $repayments->last()['outstanding_principal'],
                        $advance_emi['emi'],
                        $advance_emi['principal'],
                        $advance_emi['interest'],
                        
                                              
                        );
                        array_push($arr, $data);
                    } else {
                        $data = array (
                        $application->id,
                        $application->pin_number,
                        $application->approved_loan_amount,
                        $application->disbursement_date,
                        $application->valid_from,
                        $application->valid_upto,
                        $application->approved_loan_tenure,
                        $application->interest_rate,
                        $application->subvention,
                        $application->effective_interest_rate,
                        $repayments->sum('emi'),
                        $repayments->sum('principal'),
                        $repayments->sum('interest'),
                        $repayments->last()['outstanding_principal'],
                        $advance_emi,
                        $advance_emi,
                        $advance_emi          
                        );
                        array_push($arr, $data);
                    }
                } else {
                    if($advance_emi!=null) {
                        $data = array (
                        $application->id,
                        $application->pin_number,
                        $application->approved_loan_amount,
                        $application->disbursement_date,
                        $application->valid_from,
                        $application->valid_upto,
                        $application->approved_loan_tenure,
                        $application->interest_rate,
                        $application->subvention,
                        $application->effective_interest_rate,
                        $ideal_repayment_schedules->sum('emi'),
                        $ideal_repayment_schedules->sum('principal'),
                        $ideal_repayment_schedules->sum('interest'),
                        $ideal_repayment_schedules->last()['outstanding_principal'],
                        $advance_emi['emi'],
                        $advance_emi['principal'],
                        $advance_emi['interest'],
                        
                                              
                        );
                        array_push($arr, $data);
                    } else {
                        $data = array (
                        $application->id,
                        $application->pin_number,
                        $application->approved_loan_amount,
                        $application->disbursement_date,
                        $application->valid_from,
                        $application->valid_upto,
                        $application->approved_loan_tenure,
                        $application->interest_rate,
                        $application->subvention,
                        $application->effective_interest_rate,
                        $ideal_repayment_schedules->sum('emi'),
                        $ideal_repayment_schedules->sum('principal'),
                        $ideal_repayment_schedules->sum('interest'),
                        $ideal_repayment_schedules->last()['outstanding_principal'],
                        $advance_emi,
                        $advance_emi,
                        $advance_emi          
                        );
                        array_push($arr, $data);
                    }
                }
            }
            //dd($arr);
            //set the titles
            $sheet->fromArray($arr,null,'A1',false,false)
                  ->prependRow(array('Application_id','PIN',
                        'Loan Amount','Disbursement Date',
                        'Valid From','Valid Upto','Tenure',
                        'Interest Rate','Subvention',
                        'IRR','Total EMI','Total Principal',
                        'Total Interest','Total outstanding Principal',
                        'Total Adv EMI', 'Total Adv Principal', 'Total Adv Interest'
                    ));
            });
        })->export('xlsx');
    }
}

