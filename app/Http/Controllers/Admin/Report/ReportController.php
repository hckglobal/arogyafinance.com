<?php

namespace App\Http\Controllers\Admin\Report;

use Illuminate\Http\Request;
use  App\Borrower;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Application;
use Excel;
use Carbon\Carbon;
use App\Mandate;
use App\OutstandingPrincipalReport;
use DB;
use App\Http\Controllers\Admin\Application\RepaymentController;
use App\Http\Controllers\Admin\Application\AccountRepaymentController;
use Session;
use App\Admin;
use App\Log;
use App\Helpers\CSVWriter;
use App\Helpers\Stopwatch;
use Log as DataLog;
use Auth;

class ReportController extends Controller
{
    /**
     * Display a listing of the report.
     * @return \Illuminate\Http\Response
     */
    public function index(Request $input,$status) 
    {
        $applications = Application::latest();
        $applications=$applications->where('status',$status);
        //see if start date is present
        if ($input->has('start-date')) {
            $start_date = $input->get('start-date');
            $applications = $applications->whereDate('created_at','>=',$start_date);
        }

        //see if end date is present
       if ($input->has('end-date')) {
            $end_date = $input->get('end-date');
            $applications = $applications->whereDate('created_at','<=',$end_date);
        }
        
        $applications=$applications->get();
        return view ('admin.pages.report.index')->with(['applications'=>$applications,'status'=>$status]);
    }

    /**
     * Export Report
     * @param  Request $input  
     * @param  [string]  $status 
     * @return [Excel File]          
     */
    public function export(Request $input,$status)
    {
        Excel::create('report', function($excel) use ($input,$status) {
            $excel->sheet('Sheet1', function($sheet) use($input,$status) {
                $applications = Application::latest();
                $applications=$applications->where('status',$status);
                //see if start date is present
                if ($input->has('start-date')) {        
                    $start_date = $input->get('start-date');
                    $applications = $applications->whereDate('created_at','>=',$start_date);
                }

                //see if end date is present
               if ($input->has('end-date')) {                
                  $end_date = $input->get('end-date');
                  $applications = $applications->whereDate('created_at','<=',$end_date);
                }
                
                $applications=$applications->get();
                $arr =array();
                foreach($applications as $application) {
                    $data =  array(
                              $application->id,
                              $application->pin_number,
                              $application->borrower->first_name.' '.$application->borrower->last_name,
                              $application->borrower->email,
                              $application->borrower->mobile_number
                              );
                    array_push($arr, $data);                
                }
                //set the titles
                $sheet->fromArray($arr,null,'A1',false,false)->prependRow(array(
                    'Application ID','PIN Number','Borrower Name','Email ID','Mobile Number'
                )
            );
        });

        })->export('xlsx');
    }

    /**
     * Pshycometric Test Result 
     * @return \Illuminate\Http\Response
     */
    public function pshycometricResult()
    {
        $borrowers=Borrower::latest();
        $borrowers=$borrowers->paginate(20);
        return view('admin.pages.report.pshycometric')->with(['borrowers'=>$borrowers]);
    }

    /**
     * Export Pshycometric Test Report 
     * @param  Request $input 
     * @return Excel File        
     */
    public function exportPshycometric(Request $input)
    {
        Excel::create('PshycometricReport', function($excel) use ($input) {
            $excel->sheet('Sheet1', function($sheet) use($input) {
            $borrowers=Borrower::all();
            //see if start date is present
            if ($input->has('start-date')) {        
                $start_date = $input->get('start-date');
                $borrowers = $borrowers->whereDate('created_at','>=',$start_date);
            }

            //see if end date is present
            if ($input->has('end-date')) {
                $end_date = $input->get('end-date');
                $borrowers = $borrowers->whereDate('created_at','<=',$end_date);
            }
            
            $borrowers=$borrowers->get();
            $arr =array();

            foreach ($borrowers as $borrower) {
                $data =  array($borrower->first_name.' '.$borrower->last_name,
                $borrower->score('ability').' '.$borrower->result('ability'),
                $borrower->score('integrity').' '.$borrower->result('integrity'),
                $borrower->score('intention').' '.$borrower->result('intention'),
                $borrower->score('risk').' '.$borrower->result('risk'),
                $borrower->score('total').' '.$borrower->result('total'));
                      
                array_push($arr, $data);
            }
            //set the titles
            $sheet->fromArray($arr,null,'A1',false,false)->prependRow(array(
                    'Borrower Name','Ability Score','Integrity Score','Intention Score','Risk Score','Total Score'
                )
            );
        });
        })->export('xlsx');
    }

    /**
     * Get Incomplete Applications 
     * @return \Illuminate\Http\Response
     */
    public function getIncompleteApplications() 
    {   
        $borrowers = Borrower::where('email','')->orWhereNull('email')->get();
        return view('admin.pages.report.email_exception')
             ->with(['borrowers'=>$borrowers,'status'=>'Email Exceptions']);
    }

    /**
     * Export Incomplete Applications 
     * @param  Request $input 
     * @return Excel File         
     */
    public function exportIncompleteApplications(Request $input)
    {
        Excel::create('EmailExceptions Report', function($excel) use ($input) {
            $excel->sheet('Sheet1', function($sheet) use($input) {
            $borrowers = Borrower::latest();
            $borrowers = Borrower::where('email','')->orWhereNull('email');
            //see if start date is present
            if ($input->has('start-date')) {
                $start_date = $input->get('start-date');
                $borrowers = $borrowers->whereDate('created_at','>=',$start_date);
            }

            //see if end date is present
            if ($input->has('end-date')) {
                $end_date = $input->get('end-date');
                $borrowers = $borrowers->whereDate('created_at','<=',$end_date);
            }
            
            $borrowers=$borrowers->get();
            $arr =array();
            
            foreach ($borrowers as $borrower) {
                if($borrower->application) {
                    $data =  array(
                            $borrower->application->id,
                            $borrower->application->pin_number,
                            $borrower->first_name.' '.$borrower->last_name,
                            $borrower->email,
                            $borrower->mobile_number
                            );
                        array_push($arr, $data);
                } else {  
                    $data =  array(
                              'Application id not available',
                              'PIN Number not available',
                              $borrower->first_name.' '.$borrower->last_name,
                              $borrower->email,
                              $borrower->mobile_number
                              );
                        array_push($arr, $data);    
                }  
            }
            //set the titles
            $sheet->fromArray($arr,null,'A1',false,false)->prependRow(array(
                    'Application ID','PIN Number','Borrower Name','Email ID','Mobile Number'
                )
            );
        });
        })->export('xlsx');
    }

    /**
     * Lead Result 
     * @param  Request $input 
     * @return \Illuminate\Http\Response         
     */
    public function leadResult(Request $input)
    {
        $applications = Application::latest();
        $applications=$applications->where('status','lead');
        //see if start date is present
        if ($input->has('start-date')) {
            $start_date = $input->get('start-date');
            $applications = $applications->whereDate('created_at','>=',$start_date);
        }

        //see if end date is present
        if ($input->has('end-date')) {
            $end_date = $input->get('end-date');
            $applications = $applications->whereDate('created_at','<=',$end_date);
        }
        
        $applications=$applications->get();
        return view ('admin.pages.report.application_leads')->with(['applications'=>$applications]);
    }

    /**
     * Export Lead 
     * @param  Request $input 
     * @return Excel File        
     */
    public function exportLead(Request $input)
    {
        Excel::create('Leads Report', function($excel) use ($input) {
            $excel->sheet('Sheet1', function($sheet) use($input) {
            $applications = Application::latest();
            $applications=$applications->where('status','lead');
            //see if start date is present
            if ($input->has('start-date')) {
                $start_date = $input->get('start-date');
                $applications = $applications->whereDate('created_at','>=',$start_date);
            }

            //see if end date is present
            if ($input->has('end-date')) {
                $end_date = $input->get('end-date');
                $applications = $applications->whereDate('created_at','<=',$end_date);
            }
            
            $applications=$applications->get();
            $arr =array();
       
            foreach ($applications as $application) {
                if ($application->borrower) {
                    $data =  array(
                                $application->id,
                                $application->pin_number,
                                $application->borrower->first_name.' '.$application->borrower->last_name,
                                $application->borrower->email,
                                $application->borrower->mobile_number
                                );
                            array_push($arr, $data);
                } else {
                    $data =  array(
                                $application->id,
                                $application->pin_number,
                                'Borrower name not available',
                                'Borrower email not available',
                                'Borrower mobile number not available',
                                );
                            array_push($arr, $data);    
                }  
            }
            //set the titles
            $sheet->fromArray($arr,null,'A1',false,false)->prependRow(array(
                    'Application ID','PIN Number','Borrower Name','Email ID','Mobile Number'
                )
            );
        });
        })->export('xlsx');
    }

    /**
     * Disbursed Result 
     * @param  Request $input 
     * @return \Illuminate\Http\Response           
     */
    public function disbursedResult(Request $input)
    {
        $applications = Application::latest();
        $applications=$applications->where('status','disbursed');
        //see if start date is present
        if ($input->has('start-date')) {
            $start_date = $input->get('start-date');
            $applications = $applications->whereDate('disbursement_date','>=',$start_date);
        }

        //see if end date is present
        if ($input->has('end-date')) {
            $end_date = $input->get('end-date');
            $applications = $applications->whereDate('disbursement_date','<=',$end_date);
        }

        $applications=$applications->get();
        return view ('admin.pages.report.application_disbursed')->with(['applications'=>$applications]);
    }

    /**
     * Export Disbursed 
     * @param  Request $input
     * @return Excel File       
     */
    public function exportDisbursed(Request $input)
    {
        Excel::create('Disbursed report', function($excel) use ($input) {
            $excel->sheet('Sheet1', function($sheet) use($input) {
            $applications = Application::latest();
            $applications=$applications->where('status','disbursed');
            //see if start date is present
            if ($input->has('start-date')) {
                $start_date = $input->get('start-date');
                $applications = $applications->whereDate('disbursement_date','>=',$start_date);
            }

            //see if end date is present
            if($input->has('end-date')){
                $end_date = $input->get('end-date');
                $applications = $applications->whereDate('disbursement_date','<=',$end_date);
            }
            
            $applications=$applications->get();
            $arr =array();
            
            foreach ($applications as $application) {
                $data = array(
                            $application->id,
                            $application->pin_number,
                            $application->borrower->first_name.' '.$application->borrower->last_name,
                            $application->borrower->email,
                            $application->borrower->mobile_number
                            );
                        array_push($arr, $data);                
            }
            //set the titles
            $sheet->fromArray($arr,null,'A1',false,false)->prependRow(array(
                    'Application ID','PIN Number','Borrower Name','Email ID','Mobile Number'
                )
            );
        });
        })->export('xlsx');
    }

    public function exportENACH()
    {
        Excel::create('ENACH Report', function($excel) {
            $excel->sheet('Sheet1', function($sheet) {
                $mandates = Mandate::latest()->get();
                $arr =array();

                foreach ($mandates as $mandate) {
                        $data = array(
                                    $mandate->application_id,
                                    $mandate->application->pin_number,   
                                    $mandate->mandate_id,   
                                    $mandate->type,
                                    $mandate->status,
                                    $mandate->message,
                                    $mandate->partner_entity_status,
                                    $mandate->umrn
                                );
                        array_push($arr, $data);                
                    }
                //set the titles
                $sheet->fromArray($arr,null,'A1',false,false)->prependRow(array('Application ID', 'PIN', 'Mandate ID', 'Type', 'Status', 'Message', 'Partner Entity Status','UMRN')
                );
                });
        })->export('xlsx');
    }

    /**
     * [generate overdue report]
     */
    public function generateOverDues()
    {   
        ini_set('max_execution_time', 6000); 
        $od_reports = OutstandingPrincipalReport::all();
        Excel::create('Overdue Report', function($excel) use ($od_reports) {
            $excel->sheet('sheet1', function($sheet) use($od_reports) {       
                $arr =array();
                foreach($od_reports as $od_report) {                        
                    $data =  [
                    'id'=>$od_report->application_id,
                    'pin_number'=>$od_report->pin_number,
                    'loan_amount'=>$od_report->loan_amount,
                    'emi'=>$od_report->emi,
                    'no_of_advance_emi'=>$od_report->no_of_advance_emi,
                    'valid_from'=>$od_report->valid_from,
                    'valid_upto'=>$od_report->valid_upto,
                    'disbursement_date'=>$od_report->disbursement_date,
                    'interest_rate'=>$od_report->interest_rate,
                    'tenure'=>$od_report->tenure,
                    'overdue_amount'=>$od_report->overdue_amount,
                    'interest'=>$od_report->interest,
                    'principal'=>$od_report->principal,
                    'outstanding_principal'=>$od_report->outstanding_principal,
                    'overdue_in_months'=>$od_report->overdue_in_months,
                    'total_collection'=>$od_report->total_collection,
                    'processing_fee'=>$od_report->processing_fee,
                    'document_charge'=>$od_report->document_charge];
                    array_push($arr, $data);                            
                }
                $sheet->row($od_reports->count()+2, array(
                    'Summary',
                    '',
                    '',
                    $od_reports->sum('loan_amount'),
                    $od_reports->sum('emi'),
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    $od_reports->sum('overdue_amount'),
                    $od_reports->sum('interest'),
                    $od_reports->sum('principal'),
                    $od_reports->sum('outstanding_principal'),
                    $od_reports->sum('total_collection'),
                    $od_reports->sum('processing_fee'),
                    $od_reports->sum('document_charge')
                ));

                //set the titles
                $sheet->fromArray($arr,null,'A1',false,false)
                    ->prependRow(array('Application Id','PIN','Loan Amount','EMI','No. Advance EMI',
                        'Valid From','Valid Upto','Disbursement Date','Interest Rate','Tenure','overdue Amount',
                        'Interest','Principal','Outstanding principal','Overdue in Months','Total Collection','Processing Fee','Documentation Charge'));
            });
        })->export('xlsx');
    }


    /**
     * get today's disbursement applications detail 
     * @return \Illuminate\Http\Response
     */
    public function getTodaysDisbursementApplications(Request $input)
    {
        $title = "Today's Disbursement";
        $applications = Application::whereHas('documents', function ($query) {
                            $query->where('type', 'disbursement-documents');
                        })
                        ->where('type','loan')
                        ->where('status','sanctioned')
                        ->get();
        if($input->has('export')) {
            $this->exportTodaysDisbursementApplications($applications);
        } else {
            return view('admin.pages.application.todays_disbursement')->with(['title'=>$title, 'applications'=>$applications]);
        }        
    }

    /**
     * Export today's disbursement applications detail in xlsx file
     * @return \Illuminate\Http\Response
     */
    public function exportTodaysDisbursementApplications($applications)
    {
        Excel::create("Today's Disbursement Report", function($excel) use($applications) {
            $excel->sheet('Sheet1', function($sheet) use($applications) {
                $arr =array();
                $data=array('');
                array_push($arr,$data);
                $data=array('ID', 'PIN', 'Borrower Name', 'Loan to be disbursed to', 'Loan Amount', 
                            'Tenure', 'EMI', 'Advance EMI', 'Disbursement Date', 'Product','Location');
                array_push($arr,$data);

                foreach ($applications as $application) {
                    $data = array(
                                $application->id,
                                $application->pin_number,   
                                $application->borrower->first_name.' '.$application->borrower->last_name,   
                                $application->approved_hospital_name,   
                                $application->approved_loan_amount,
                                $application->approved_loan_tenure,
                                $application->approved_loan_emi,
                                $application->advance_emi,
                                $application->disbursement_date,
                                $application->product->name,
                                $application->location->name
                            );
                    array_push($arr, $data);                
                }
                
                $sheet->fromArray($arr,null,'A1',false,false)
                      ->prependRow(array('','Total Applications :',$applications->count(),'','Total Amount :',$applications->sum('approved_loan_amount')
                        ));
            });
        })->export('xlsx');
    }

    /**
     * Export closure report detail in xlsx file
     * @return \Illuminate\Http\Response
     */
    public function closureReport($today)
    {
        $user = Auth::user();
        $month = Carbon::parse($today)->format('F-Y');

        $header = array('ID', 'PIN','Status', 'Approved Loan Amount', 'EMI Month', 'EMI', 'Principal', 'Interest', 'Outstanding Principal', 'Amount Received', 'EMI Payment Date');
        
        $file_name = 'Closure Report-'.$month;
        $csv = new CSVWriter($header, $file_name);

        $user->applications()
            ->join('account_repayment_schedules', function ($join) use($today) {
                $join->on('applications.id', '=', 'account_repayment_schedules.application_id')
                     ->where('account_repayment_schedules.type', '=','emi')
                     ->where('account_repayment_schedules.emi_month', 'like', '%'.$today->format('Y-m').'%')
                     ->where('account_repayment_schedules.outstanding_principal', '<=', '0');
            })
            ->whereIn('applications.status',['disbursed','closed'])
            ->where('applications.type','loan')
            ->select('applications.id','applications.pin_number','applications.status',
                'applications.approved_loan_amount','account_repayment_schedules.emi_month',
                'account_repayment_schedules.emi','account_repayment_schedules.principal',
                'account_repayment_schedules.interest',
                'account_repayment_schedules.outstanding_principal',
                'account_repayment_schedules.amount_received',
                'account_repayment_schedules.emi_payment_date')
            ->chunk(100,function ($applications) use($csv) {
                foreach ($applications as $application) {
                    $data = array(
                        $application->id,
                        $application->pin_number,   
                        $application->status,   
                        $application->approved_loan_amount,
                        $application->emi_month,
                        $application->emi,
                        $application->principal,
                        $application->interest,
                        $application->outstanding_principal,
                        $application->amount_received,
                        $application->emi_payment_date
                    );
                   $csv->addRow($data);
                }
            });  
        $csv->close();
        Session::flash('info','Closure Report Generated');
    }

    /**
     * Display filter to select date for od report.
     * @return \Illuminate\Http\Response
     */
    public function viewOdReportFilter(Request $input) 
    {
        return view ('admin.pages.report.od_report_filter',['input'=>$input]);
    }

    /**
     * Export the od report.
     * @return \Illuminate\Http\Response
     */
    public function odReport(Request $input) 
    {
        $stopwatch = new Stopwatch();

        $user = Auth::user();
        $overdue_month = Carbon::parse($input->end_date)->format('Y-m');
        $input->closure_date = $input->end_date;
        $header = array(
            'ID','PIN','Location','Allocated to','Status','Borrower Name','Borrower Mobile',
            'Borrower Address','Loan Amount','EMI Amount','Tenure','Disbursement Date','Valid From','Valid Upto','Contract value',
            'Amount Due','Amount Collected',Carbon::parse($input->end_date)->format('F, y').' payment amount',Carbon::parse($input->end_date)->format('F, y').' payment date',
            'Legal status','Overdue Amount','Overdue in Months','ChequeBounce Charges', 
        );
        
        $file_name = 'OD Report -'.Carbon::parse($overdue_month)->format('j F, Y');

        $csv = new CSVWriter($header, $file_name);
   
        $repay_ctrl = new RepaymentController;
        $arp_ctrl = new AccountRepaymentController;

        $user->applications()->whereIn('status',['disbursed','closed'])->where('type','loan')
            ->chunk(1000,function ($applications) use($csv, $overdue_month,$repay_ctrl,$input,$arp_ctrl) {
                foreach($applications as $i=>$application) {
                    $od_data = $repay_ctrl->getOverdueAndDPD($application, $input->end_date);
                    $csv_row =  [
                        'id'=>$od_data['od_report']['application_id'],
                        'pin_number'=>$od_data['od_report']['pin_number'],
                        'location'=>$od_data['od_report']['location'],
                        'allocated_to'=>$od_data['od_report']['punchBy'],
                        'status'=>$od_data['od_report']['status'],
                        'borrower_name'=>$od_data['od_report']['borrower_name'],
                        'borrower_mobile'=>$od_data['od_report']['borrower_mobile'],
                        'borrower_address'=>$od_data['od_report']['borrower_address'],
                        'loan_amount'=>$od_data['od_report']['loan_amount'],
                        'emi_amount'=>$od_data['od_report']['emi'],
                        'tenure'=>$od_data['od_report']['tenure'],
                        'disbursement_date'=>$od_data['od_report']['disbursement_date'],
                        'valid_from'=>$od_data['od_report']['valid_from'],
                        'valid_upto'=>$od_data['od_report']['valid_upto'],
                        'contract_value'=>$od_data['od_report']['contract_value'],
                        'amount_due'=>$od_data['od_report']['amount_due'],
                        'total_collection'=>$od_data['od_report']['total_collection'],
                        'requested_month_payment'=>$od_data['od_report']['requested_month_payment'],
                        'requested_month_date'=>$od_data['od_report']['requested_month_date'],
                        'legal_status' =>'',
                        'overdue_amount'=>$od_data['od_report']['overdue_amount'],
                        'overdue_in_months'=>$od_data['od_report']['overdue_in_months'],
                        'cheque_bounced'=>$od_data['od_report']['total_bounced_charges'],
                    ];
                    //todo uncomment
                    $csv->addRow($csv_row);
                }
            });
        $csv->close();
        Session::flash('info','OD Report Generated');
    }

    /**
     * Display filter to select date for od report.
     * @return \Illuminate\Http\Response
     */
    public function viewClosureReportFilter(Request $input) 
    {
        return view ('admin.pages.report.closure_report_filter',['input'=>$input]);
    }

    /**
     * Export the od report.
     * @return \Illuminate\Http\Response
     */
    public function closureReportData(Request $input) 
    {
        $user = Auth::user();
        $today = Carbon::parse($input->end_date);
        $month = Carbon::parse($today)->format('F-Y');

        $header = array('ID', 'PIN','Status', 'Approved Loan Amount', 'EMI Month', 'EMI', 'Principal', 'Interest', 'Outstanding Principal', 'Amount Received', 'EMI Payment Date');
        
        $file_name = 'Closure Report-'.$month;
        $csv = new CSVWriter($header, $file_name);
        $user->applications()
            ->join('account_repayment_schedules', function ($join) use($today) {
                $join->on('applications.id', '=', 'account_repayment_schedules.application_id')
                     ->where('account_repayment_schedules.type', '=','emi')
                     ->where('account_repayment_schedules.emi_month', 'like', '%'.$today->format('Y-m').'%')
                     ->where('account_repayment_schedules.outstanding_principal', '<=', '0');
            })
            ->whereIn('applications.status',['disbursed','closed'])
            ->where('applications.type','loan')
            ->select('applications.id','applications.pin_number','applications.status',
                'applications.approved_loan_amount','account_repayment_schedules.emi_month',
                'account_repayment_schedules.emi','account_repayment_schedules.principal',
                'account_repayment_schedules.interest',
                'account_repayment_schedules.outstanding_principal',
                'account_repayment_schedules.amount_received',
                'account_repayment_schedules.emi_payment_date')
            ->chunk(100,function ($applications) use($csv) {
                foreach ($applications as $application) {
                    $data = array(
                        $application->id,
                        $application->pin_number,   
                        $application->status,   
                        $application->approved_loan_amount,
                        $application->emi_month,
                        $application->emi,
                        $application->principal,
                        $application->interest,
                        $application->outstanding_principal,
                        $application->amount_received,
                        $application->emi_payment_date
                    );
                   $csv->addRow($data);
                }
            });  
        $csv->close();

        Session::flash('info','Closure Report Generated');
    }

    /**
     * Display filter to select date for Data dump report.
     * @return \Illuminate\Http\Response
     */
    public function viewDataDumpReportFilter(Request $input) 
    {
        return view ('admin.pages.report.data_dump_report_filter',['input'=>$input]);
    }

    /**
     * Generate Data Dump report.
     * @return \Illuminate\Http\Response
     */
    public function dataDumpReport(Request $input) 
    {
        $user = Auth::user();
        $applications = $user->applications();
        if($input->start_date!=null && $input->end_date!=null) {
            $report_month = 'DataDump Report '.Carbon::parse($input->start_date)->format('Y-m-d').' to '.Carbon::parse($input->end_date)->format('Y-m-d');

        } elseif($input->start_date!=null && $input->end_date==null) {
            $report_month = 'DataDump Report till '.Carbon::parse($input->start_date)->format('Y-m-d');
        } elseif($input->start_date==null && $input->end_date!=null) {
            $report_month = 'DataDump Report till '.Carbon::parse($input->end_date)->format('Y-m-d');
        } else {
            $report_month = 'DataDump Report';
        }
        //dd($report_month);
        
        if ($input->has('start_date') && $input->start_date!=null) {
                $start_date = Carbon::parse($input->start_date)->format('Y-m-d');
                $applications = $applications->whereDate('applications.disbursement_date','>=',$start_date);
        }
        
        if ($input->has('end_date') && $input->end_date!=null) {
                $end_date = Carbon::parse($input->end_date)->format('Y-m-d');
                $applications = $applications->whereDate('applications.disbursement_date','<=',$end_date);
        }
        //dd($applications->count(),$applications->toSQL(),Carbon::parse($input->end_date)->format('Y-m-d'));
        $applications = $applications
            ->leftjoin('borrowers', function ($join) {
                $join->on('applications.id', '=', 'borrowers.application_id')
                     ->where('borrowers.type', '=','primary');
            })
            ->leftjoin('patients', function ($join) {
                $join->on('applications.id', '=', 'patients.application_id');
            })
            ->leftjoin('locations', function ($join) {
                $join->on('locations.id', '=', 'applications.location_id');
            })
            ->leftjoin('products', function ($join) {
                $join->on('products.id', '=', 'applications.product_id');
            })
            ->leftjoin('rejection_reasons', function ($join) {
                $join->on('rejection_reasons.id', '=', 'applications.rejection_reason_id');
            })
            ->select('applications.id','applications.type','applications.cibil_score','applications.hospital_name',
                     'applications.approved_hospital_name','applications.total_borrowers_income','applications.calculated_income',
                     'applications.calculated_loan_amount','applications.calculated_loan_emi','applications.calculated_loan_tenure',
                     'applications.approved_loan_amount','applications.approved_loan_emi','applications.approved_loan_tenure',
                     'applications.treatment_type','applications.estimated_cost','applications.loan_required','applications.status',
                     'applications.other_expense','applications.requested_tenure','applications.requested_emi',
                     'applications.interest_rate','applications.subvention','applications.processing_fee','applications.pin_number',
                     'applications.reference_code','applications.created_at','applications.updated_at','applications.referrer_id',
                     'applications.referrer_company_id','applications.valid_from','applications.valid_upto',
                     'applications.disbursement_date',DB::raw('products.name as product'),DB::raw('locations.name as location'),'applications.card_no',
                     DB::raw('rejection_reasons.text as reject_reason'),'applications.partner_reference_code','applications.arogya_card_id',
                     'applications.rejection_note','applications.enable_psychometric_test','applications.test_language',
                     'applications.documentation_charge','applications.advance_emi','applications.dmi_status',
                     'applications.dmi_issue_date','applications.dmi_sent','applications.self_patient','applications.merchant',
                     'applications.mode_of_payment','applications.foir','applications.bank_customer_name','applications.bank_name',
                     'applications.bank_account_number','applications.lead_id','applications.bank_account_type',
                     'applications.bank_ifsc_code','applications.closer_reason_id','applications.closer_note','applications.closer_date',
                     'applications.ndc_sent',
                     'borrowers.id as borrower_id','borrowers.type as borrower_type',
                     'borrowers.first_name as borrower_first_name',
                     'borrowers.middle_name as borrower_middle_name',
                     'borrowers.last_name as borrower_last_name',
                     'borrowers.date_of_birth as borrower_date_of_birth',
                     'borrowers.gender as borrower_gender',
                     'borrowers.mobile_number as borrower_mobile_number',
                     'borrowers.email as borrower_email',
                     'borrowers.residence_type as borrower_residence_type',
                     'borrowers.city as borrower_city',
                     'borrowers.state as borrower_state',
                     'borrowers.pincode as borrower_pincode',
                     'borrowers.address_line_1 as borrower_address_line_1',
                     'borrowers.address_line_2 as borrower_address_line_2',
                     'borrowers.marital_status as borrower_marital_status',
                     'borrowers.borrowers_income as borrower_borrowers_income',
                     'borrowers.earning_since as borrower_earning_since',
                     'borrowers.nature_of_income as borrower_nature_of_income',
                     'borrowers.source_of_income as borrower_source_of_income',
                     'borrowers.employer_details as borrower_employer_details',
                     'borrowers.name_of_firm as borrower_name_of_firm',
                     'borrowers.income_itr as borrower_income_itr',
                     'borrowers.current_loan_emi as borrower_current_loan_emi',
                     'borrowers.education_expenses as borrower_education_expenses',
                     'borrowers.house_rent as borrower_house_rent',
                     'borrowers.number_of_dependants as borrower_number_of_dependants',
                     'borrowers.other_earnings as borrower_other_earnings',
                     'borrowers.other_earnings_type as borrower_other_earnings_type',
                     'borrowers.monthly_emi_possible as borrower_monthly_emi_possible',
                     'borrowers.id_proof_type as borrower_id_proof_type',
                     'borrowers.id_proof_number as borrower_id_proof_number',
                     'borrowers.pan_card_number as borrower_pan_card_number',
                     'borrowers.aadhar_card_number as borrower_aadhar_card_number',
                     'borrowers.created_at as borrower_created_at',
                     'borrowers.updated_at as borrower_updated_at',
                     'borrowers.alternate_number as borrower_alternate_number',
                     'borrowers.relation_with_patient as borrower_relation_with_patient',
                     'borrowers.residing_since as borrower_residing_since',
                     'borrowers.permanent_address as borrower_permanent_address',
                     'borrowers.permanent_city as borrower_permanent_city',
                     'borrowers.permanent_state as borrower_permanent_state',
                     'borrowers.permanent_pincode as borrower_permanent_pincode',
                     'patients.id as patient_id',
                     'patients.first_name as patient_first_name',
                     'patients.middle_name as patient_middle_name',
                     'patients.last_name as patient_last_name',
                     'patients.date_of_birth as patient_date_of_birth',
                     'patients.gender as patient_gender',
                     'patients.mobile_number as patient_mobile_number',
                     'patients.created_at as patient_created_at',
                     'patients.updated_at as patient_updated_at',
                     'patients.address_line_1 as patient_address_line_1',
                     'patients.address_line_2 as patient_address_line_2',
                     'patients.city as patient_city',
                     'patients.state as patient_state',
                     'patients.pincode as patient_pincode',
                     'patients.pan_card as patient_pan_card',
                     'patients.aadhar_card as patient_aadhar_card',
                     'patients.driving_id as patient_driving_id',
                     'patients.voting_id as patient_voting_id',
                     'patients.residing_since as patient_residing_since',
                     'patients.marital_status as patient_marital_status',
                     'patients.permanent_address as patient_permanent_address',
                     'patients.permanent_city as patient_permanent_city',
                     'patients.permanent_state as patient_permanent_state',
                     'patients.permanent_pincode as patient_permanent_pincode'
            );

        $header = array('id','type','cibil_score','hospital_name','approved_hospital_name','total_borrowers_income','calculated_income','calculated_loan_amount','calculated_loan_emi','calculated_loan_tenure','approved_loan_amount','approved_loan_emi','approved_loan_tenure','treatment_type','estimated_cost','loan_required','status','other_expense','requested_tenure','requested_emi','interest_rate','subvention','processing_fee','pin_number','reference_code','created_at','updated_at','referrer_id','referrer_company_id','valid_from','valid_upto','disbursement_date','product','location','card_no','rejection_reason','partner_reference_code','arogya_card_id','rejection_note','enable_psychometric_test','test_language','documentation_charge','advance_emi','dmi_status','dmi_issue_date','dmi_sent','self_patient','merchant','mode_of_payment','foir','bank_customer_name','bank_name','bank_account_number','lead_id','bank_account_type','bank_ifsc_code','closer_reason_id','closer_note','closer_date','ndc_sent','borrower_id','borrower_type','borrower_first_name','borrower_middle_name','borrower_last_name','borrower_date_of_birth','borrower_gender','borrower_mobile_number','borrower_email','borrower_residence_type','borrower_city','borrower_state','borrower_pincode','borrower_address_line_1','borrower_address_line_2','borrower_marital_status','borrower_borrowers_income','borrower_earning_since','borrower_nature_of_income','borrower_source_of_income','borrower_employer_details','borrower_name_of_firm','borrower_income_itr','borrower_current_loan_emi','borrower_education_expenses','borrower_house_rent','borrower_number_of_dependants','borrower_other_earnings','borrower_other_earnings_type','borrower_monthly_emi_possible','borrower_id_proof_type','borrower_id_proof_number','borrower_pan_card_number','borrower_aadhar_card_number','borrower_created_at','borrower_updated_at','borrower_alternate_number','borrower_relation_with_patient','borrower_residing_since','borrower_permanent_address','borrower_permanent_city','borrower_permanent_state','borrower_permanent_pincode','patient_id','patient_first_name','patient_middle_name','patient_last_name','patient_date_of_birth','patient_gender','patient_mobile_number','patient_created_at','patient_updated_at','patient_address_line_1','patient_address_line_2','patient_city','patient_state','patient_pincode','patient_pan_card','patient_aadhar_card','patient_driving_id','patient_voting_id','patient_residing_since','patient_marital_status','patient_permanent_address','patient_permanent_city','patient_permanent_state','patient_permanent_pincode'
        );

        $file_name = $report_month;
        $csv = new CSVWriter($header, $file_name);
        $applications->chunk(100,function ($applications) use($csv) {
            foreach ($applications as $key => $application) {
                $application_data =  array(
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
                    $application->product,
                    $application->location,
                    $application->card_no,
                    $application->reject_reason,
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
                    $application->lead_id,
                    $application->bank_account_type,
                    $application->bank_ifsc_code,
                    $application->closer_reason_id,
                    $application->closer_note,
                    $application->closer_date,
                    $application->ndc_sent,
                    $application->borrower_id,
                    $application->borrower_type,
                    $application->borrower_first_name,
                    $application->borrower_middle_name,
                    $application->borrower_last_name,
                    $application->borrower_date_of_birth,
                    $application->borrower_gender,
                    $application->borrower_mobile_number,
                    $application->borrower_email,
                    $application->borrower_residence_type,
                    $application->borrower_city,
                    $application->borrower_state,
                    $application->borrower_pincode,
                    $application->borrower_address_line_1,
                    $application->borrower_address_line_2,
                    $application->borrower_marital_status,
                    $application->borrower_borrowers_income,
                    $application->borrower_earning_since,
                    $application->borrower_nature_of_income,
                    $application->borrower_source_of_income,
                    $application->borrower_employer_details,
                    $application->borrower_name_of_firm,
                    $application->borrower_income_itr,
                    $application->borrower_current_loan_emi,
                    $application->borrower_education_expenses,
                    $application->borrower_house_rent,
                    $application->borrower_number_of_dependants,
                    $application->borrower_other_earnings,
                    $application->borrower_other_earnings_type,
                    $application->borrower_monthly_emi_possible,
                    $application->borrower_id_proof_type,
                    $application->borrower_id_proof_number,
                    $application->borrower_pan_card_number,
                    $application->borrower_aadhar_card_number,
                    $application->borrower_created_at,
                    $application->borrower_updated_at,
                    $application->borrower_alternate_number,
                    $application->borrower_relation_with_patient,
                    $application->borrower_residing_since,
                    $application->borrower_permanent_address,
                    $application->borrower_permanent_city,
                    $application->borrower_permanent_state,
                    $application->borrower_permanent_pincode,
                    $application->patient_id,
                    $application->patient_first_name,
                    $application->patient_middle_name,
                    $application->patient_last_name,
                    $application->patient_date_of_birth,
                    $application->patient_gender,
                    $application->patient_mobile_number,
                    $application->patient_created_at,
                    $application->patient_updated_at,
                    $application->patient_address_line_1,
                    $application->patient_address_line_2,
                    $application->patient_city,
                    $application->patient_state,
                    $application->patient_pincode,
                    $application->patient_pan_card,
                    $application->patient_aadhar_card,
                    $application->patient_driving_id,
                    $application->patient_voting_id,
                    $application->patient_residing_since,
                    $application->patient_marital_status,
                    $application->patient_permanent_address,
                    $application->patient_permanent_city,
                    $application->patient_permanent_state,
                    $application->patient_permanent_pincode
                    );
                $csv->addRow($application_data);
            }
        });
        $csv->close();
        Session::flash('info','Data Dump Report Generated');
    }


    /**
     * Display filter to select date for CIBIL dump report.
     * @return \Illuminate\Http\Response
     */
    public function viewCibilDumpReportFilter(Request $input) 
    {
        return view ('admin.pages.report.cibil_dump_report_filter',['input'=>$input]);
    }

    /**
     * Generate CIBIL Data Dump Report.
     *
     * @return \Illuminate\Http\Response
     */
    public function cibilDumpReport(Request $input)
    {   
        $user = Auth::user();
        $start_date = Carbon::parse($input->start_date)->format('Y-m-d');
        $end_date = Carbon::parse($input->end_date)->format('Y-m-d');
        $report_month = 'CIBIL Dump Report '.Carbon::parse($input->start_date)->format('Y-m-d').' to '.Carbon::parse($input->end_date)->format('Y-m-d');
        $header = array(
                        'Consumer Name',
                        'Date of Birth',
                        'Gender',
                        'IncomeTaxIDNumber',
                        'Passport Number',
                        'Passport Issue Date',
                        'Passport Expiry Date',
                        'Voter ID Number',
                        'Driving License Number',
                        'Driving License Issue Date',
                        'Driving License Expiry Date',
                        'Ration Card Number',
                        'Universal ID Number',
                        'Additional ID #1',
                        'Additional ID #2',
                        'Telephone No.Mobile',
                        'Telephone No.Residence',
                        'Telephone No.Office',
                        'Extension Office',
                        'Telephone No.Other ',
                        'Extension Other',
                        'Email ID 1',
                        'Email ID 2',
                        'Address Line 1',
                        'State Code 1',
                        'PIN Code 1',
                        'Address Category 1',
                        'Residence Code 1',
                        'Address Line 2',
                        'State Code 2',
                        'PIN Code 2',
                        'Address Category 2',
                        'Residence Code 2',
                        'Current/New Member Code',
                        'Current/New Member Short Name',
                        'Curr/New Account No',
                        'Account Type',
                        'Ownership Indicator',
                        'Date Opened/Disbursed',
                        'Date of Last Payment',
                        'Date Closed',
                        'Date Reported',
                        'High Credit/Sanctioned Amt',
                        'Current  Balance',
                        'Amt Overdue',
                        'No of Days Past Due',
                        'Old Mbr Code',
                        'Old Mbr Short Name',
                        'Old Acc No',
                        'Old Acc Type',
                        'Old Ownership Indicator',
                        'Suit Filed / Wilful Default',
                        'Writtenoff and Settled Status',
                        'Asset Classification',
                        'Value of Collateral',
                        'Type of Collateral',
                        'Credit Limit',
                        'Cash Limit',
                        'Rate of Interest',
                        'RepaymentTenure',
                        'EMI Amount',
                        'Written off Amount (Total) ',
                        'Written off Principal Amount',
                        'Settlement Amt',
                        'Payment Frequency',
                        'Actual Payment Amt',
                        'Occupation Code',
                        'Income',
                        'Net/Gross Income Indicator',
                        'Monthly/Annual Income Indicator',
                        'Error'
                    );
        $file_name = $report_month;
        $csv = new CSVWriter($header, $file_name);

        $user->applications()->where('type','loan')
            ->whereIN('status',['disbursed','closed'])
            ->whereBetween('disbursement_date',[$start_date,$end_date])
            ->chunk(100,function ($applications) use($csv) {
                foreach ($applications as $application) {
                    $borrowers = $application->borrowers;
                    $patient = $application->patient;
                    foreach ($borrowers as $borrower) {
                        $borrower_data = array(
                            $borrower->first_name.' '.$borrower->middle_name.' '.$borrower->last_name,
                            Carbon::parse($borrower->getOriginal('date_of_birth'))->format('dmY'),
                            $borrower->gender,
                            $borrower->pan_card_number,
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            $borrower->aadhar_card_number,
                            '',
                            '',
                            $borrower->mobile_number,
                            '',
                            '',
                            '',
                            $borrower->alternate_number,
                            '',
                            $borrower->email,
                            '',
                            $borrower->address_line_1.' '.$borrower->address_line_2,
                            $borrower->state,
                            $borrower->pincode,
                            '02',
                            $borrower->residence_type,
                            '',
                            $borrower->state,
                            '',
                            '',
                            '',
                            'NB70010001',
                            'RAMTIRTH LEASING',
                            $application->pin_number,
                            '00',
                            $borrower->type,
                            Carbon::parse($application->getOriginal('disbursement_date'))->format('dmY'),
                            '',
                            Carbon::parse($application->getOriginal('valid_upto'))->format('dmY'),
                            Carbon::now()->format('dmY'),
                            $application->approved_loan_amount,
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '00',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            $application->approved_loan_tenure,
                            $application->approved_loan_emi,
                            '',
                            '',
                            '',
                            '03',
                            '',
                            $borrower->nature_of_income,
                            $borrower->borrowers_income,
                            'N',
                            'M',
                            ''
                        );
                        $csv->addRow($borrower_data);
                    }

                    $patient_data =  array(
                        $patient->first_name.' '.$patient->middle_name.' '.$patient->last_name,
                        Carbon::parse($patient->date_of_birth)->format('dmY'),
                        $patient->gender,
                        $patient->pan_card,
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        $patient->aadhar_card,
                        '',
                        '',
                        $patient->mobile_number,
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        $patient->address_line_1.' '.$patient->address_line_2,
                        $patient->state,
                        $patient->pincode,
                        '02',
                        '',
                        '',
                        $patient->state,
                        '',
                        '',
                        '',
                        'NB70010001',
                        'RAMTIRTH LEASING',
                        $application->pin_number,
                        '00',
                        'co-borrower',
                        Carbon::parse($application->getOriginal('disbursement_date'))->format('dmY'),
                        '',
                        Carbon::parse($application->getOriginal('valid_upto'))->format('dmY'),
                        Carbon::now()->format('dmY'),
                        $application->approved_loan_amount,
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '00',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        $application->approved_loan_tenure,
                        $application->approved_loan_emi,
                        '',
                        '',
                        '',
                        '03',
                        '',
                        '',
                        '',
                        'N',
                        'M',
                        ''
                    );
                    $csv->addRow($patient_data);
                }
            });
        $csv->close();
        Session::flash('info','CIBIL Dump Report Generated');
    }

    /**
     * Display filter to select date for CIBIL log report.
     * @return \Illuminate\Http\Response
     */
    public function viewCibilLogReportFilter(Request $input) 
    {
        return view ('admin.pages.report.cibil_log_report_filter',['input'=>$input]);
    }

    /**
     * Generate CIBIL Data Dump Report.
     *
     * @return \Illuminate\Http\Response
     */
    public function cibilLogReport(Request $input)
    {   
        $start_date = Carbon::parse($input->start_date)->format('Y-m-d');
        $end_date = Carbon::parse($input->end_date)->format('Y-m-d');

        Excel::create('CIBIL Log Report', function($excel) use ($input) {
            $applications = Application::latest();
            //see if start date is present
            if ($input->has('start_date')) {
                $applications = $applications->whereDate('created_at','>=',Carbon::parse($input->get('start_date'))->format('Y-m-d'));
            }

            //see if end date is present
            if ($input->has('end_date')) {
                $applications = $applications->whereDate('created_at','<=',Carbon::parse($input->get('end_date'))->format('Y-m-d'));
            }

            $excel->sheet('CIBIL Data Report', function($sheet) use($applications) {

                $applications=$applications->get();
                $arr =array();
                foreach($applications as $application) {
                    $data =  array(
                        $application->id,
                        $application->pin_number,
                        $application->type,
                        $application->cibil_score,
                        $application->getCibilControlNumber(),
                        $application->status,
                        $application->approved_loan_amount,
                        $application->approved_loan_emi,
                        $application->approved_loan_tenure,
                        $application->getOriginal('created_at')
                    );
                    array_push($arr, $data);                
                }
                //set the titles
                $sheet->fromArray($arr,null,'A1',false,false)->prependRow(array(
                    'Application ID', 'PIN', 'Type', 'CIBIL Score', 'Control Number', 'Status', 
                    'Approved Loan Amount', 'Approved Loan EMI', 'Approved Loan Tenure', 'Created At'
                    )
                );
            });

            $excel->sheet('CIBIL Log Data', function($sheet) use($applications) {
                $logs = Log::whereIn('field', ['cibil_score','application =>cibil_score'])->whereIn('application_id', $applications->get()->pluck('id'))->get();

                $arr =array();
                foreach($logs as $log) {
                    $data =  array(
                        $log->application_id,
                        $log->admin->first_name.' '.$log->admin->last_name,
                        $log->field,
                        $log->old_value,
                        $log->new_value,
                        $log->note,
                        $log->getOriginal('created_at')
                    );
                    array_push($arr, $data);                
                }
                //set the titles
                $sheet->fromArray($arr,null,'A1',false,false)->prependRow(array(
                    'Application ID', 'User', 'Field', 'Old Value', 'New Value', 'Note', 'Created At'
                    )
                );
            });

        })->export('xlsx');
        Session::flash('info','CIBIL Log Report Generated');
    }


    /**
     * Display filter to select date for Application status report.
     * @return \Illuminate\Http\Response
     */
    public function viewApplicationStatusFilter(Request $input) 
    {
        return view ('admin.pages.report.application_status_log_filter',['input'=>$input]);
    }

    public function applicationStatusReport(Request $input)
    {
        // For Systema Report only
        /*$systema_user = Admin::where('email','praveen.selvam@sistema.co.in')->first();
        $applications = $systema_user->applications()->get();*/
        $user = Auth::user();
        $applications = $user->applications()->where('type','loan');
        if ($input->has('start_date')) {
            $applications->whereDate('created_at','>=',Carbon::parse($input->get('start_date'))->format('Y-m-d'));
        }

        //see if end date is present
        if ($input->has('end_date')) {
            $applications->whereDate('created_at','<=',Carbon::parse($input->get('end_date'))->format('Y-m-d'));
        }

        //$applications = $applications->get();
        $report_month = 'Application Status Report '.Carbon::parse($input->start_date)->format('Y-m-d').' to '.Carbon::parse($input->end_date)->format('Y-m-d');
        
        $header = array('ID', 'PIN','Status','Application Date','verified Date', 
                    'sanctioned Date', 'Disbursement Date', 'CIBIL Score', 'Product', 'Partner Ref Code', 'Punch By User');
        $file_name = $report_month;
        $csv = new CSVWriter($header, $file_name);

        $applications->chunk(100,function ($applications) use($csv) {
            foreach ($applications as $application) {
                $verification_date = $this->fetchStatusDate($application,'verified');
                $sanction_date = $this->fetchStatusDate($application,'sanctioned');
                $disbursement_date = $this->fetchStatusDate($application,'disbursed');
                $product = $application->product;
                if($product) {
                    $product_name = $product->name;
                } else {
                    $product_name = 'N/A';
                }
                if($application->admin_id) {
                    $punchBy = ucfirst($application->punchBy->first_name.' '.$application->punchBy->last_name);
                } else {
                    $punchBy = 'N/A';
                }
                $data = array(
                    $application->id,
                    $application->pin_number,
                    $application->status,
                    $application->created_at,
                    $verification_date, 
                    $sanction_date,
                    $disbursement_date,
                    $application->cibil_score,
                    $product_name,
                    $application->partner_reference_code,
                    $punchBy

                );
                $csv->addRow($data);
            }
        });
        $csv->close();
        Session::flash('info','Application Status Report Generated');
    }

    public function fetchStatusDate($application,$status)
    {
        $status_date = $application->logs()
                        ->where('field','status')
                        ->where('new_value',$status)
                        ->latest()
                        ->first();
        if($status_date) {
            return  Carbon::parse($status_date
                ->getOriginal('created_at'))->format('j F, Y h:i A');
        } else {
            return 'N/A';
        }
    }

    /**
     * Display filter to select date for Income Computation.
     * @return \Illuminate\Http\Response
     */
    public function viewIncomeComputationFilter(Request $input) 
    {
        return view ('admin.pages.report.income_computation_filter',['input'=>$input]);
    }


    /**
     * Generate Income Computation Report based on the filter date.
     * @return \Illuminate\Http\Response
     */
    public function incomeComputationReport(Request $input) 
    {
        $user = Auth::user();
        $overdue_month = Carbon::parse($input->end_date)->format('Y-m-d');

        $header = array('Application_id','PIN','Status',
                        'Loan Amount','Disbursement Date',
                        'Valid From','Valid Upto','Tenure',
                        'Interest Rate','Subvention',
                        'IRR','Total EMI','Total Principal',
                        'Total Interest','Total outstanding Principal',
                        'Total Adv EMI', 'Total Adv Principal', 'Total Adv Interest'
                    );    
        
        $file_name = 'Income Computation Report-'.$overdue_month;
        $csv = new CSVWriter($header, $file_name);

        $user->applications()->where('type','loan')
            ->whereIn('status',['disbursed','closed'])
            ->where('disbursement_date','<=',$overdue_month)
                ->chunk(100,function ($applications) use($csv,$overdue_month) {
               foreach($applications as $application) {
                    $ideal_repayment_schedules = $application->idealRepaymentSchedule();
                    $repayments = $ideal_repayment_schedules->filter(
                        function ($data) use ($overdue_month) {
                            return $data['emi_month'] <= $overdue_month;
                        });
                    
                    if($repayments->count()>0) {
                        $advance_emi = $repayments->where('type','advance_emi')->first();
                        if($advance_emi) {
                            $advance_emi = $advance_emi;
                        } else {
                            $advance_emi = null;
                        }
                        if($advance_emi!=null) {
                            $data = array (
                            $application->id,
                            $application->pin_number,
                            $application->status,
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
                            $advance_emi['interest']         
                            );
                            $csv->addRow($data);
                            //array_push($arr, $data);
                        } else {
                            $data = array (
                            $application->id,
                            $application->pin_number,
                            $application->status,
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
                            $csv->addRow($data);
                            //array_push($arr, $data);
                        }
                    } else {
                        $advance_emi = $ideal_repayment_schedules->where('type','advance_emi')->first();
                        if($advance_emi) {
                            $advance_emi = $advance_emi;
                        } else {
                            $advance_emi = null;
                        }
                        //dd($ideal_repayment_schedules->first()['emi']);
                        /*if($application->id==8547){
                            dd($advance_emi,$ideal_repayment_schedules);
                        }*/
                        if($advance_emi!=null) {
                            $data = array (
                            $application->id,
                            $application->pin_number,
                            $application->status,
                            $application->approved_loan_amount,
                            $application->disbursement_date,
                            $application->valid_from,
                            $application->valid_upto,
                            $application->approved_loan_tenure,
                            $application->interest_rate,
                            $application->subvention,
                            $application->effective_interest_rate,
                            $ideal_repayment_schedules->first()['emi'],
                            $ideal_repayment_schedules->first()['principal'],
                            $ideal_repayment_schedules->first()['interest'],
                            $ideal_repayment_schedules->first()['outstanding_principal'],
                            $advance_emi['emi'],
                            $advance_emi['principal'],
                            $advance_emi['interest']
                            );
                            $csv->addRow($data);
                            //array_push($arr, $data);
                        } else {
                            $data = array (
                            $application->id,
                            $application->pin_number,
                            $application->status,
                            $application->approved_loan_amount,
                            $application->disbursement_date,
                            $application->valid_from,
                            $application->valid_upto,
                            $application->approved_loan_tenure,
                            $application->interest_rate,
                            $application->subvention,
                            $application->effective_interest_rate,
                            0,
                            0,
                            0,
                            $application->approved_loan_amount,
                            $advance_emi,
                            $advance_emi,
                            $advance_emi          
                            );
                            $csv->addRow($data);
                            //array_push($arr, $data);
                        }
                    }
                    //dd('inside loop');
                    //$csv->addRow($data);
                }
            });    

        $csv->close();
        Session::flash('info','Income Computation Report Generated');

    }

    /**
     * Display filter to select date for Approval authority report.
     * @return \Illuminate\Http\Response
     */
    public function viewApprovalLogFilter(Request $input) 
    {
        return view ('admin.pages.report.approval_log_filter',['input'=>$input]);
    }

    /**
     * Get the approval log report
     */
    public function approvalLogReport(Request $input)
    {
        $user = Auth::user();
        $report_month = 'Approval Log Report '.Carbon::parse($input->start_date)->format('Y-m-d').' to '.Carbon::parse($input->end_date)->format('Y-m-d');        

        $header = array('ID', 'User ID','PIN','Status', 'Jose Sir Notes');
        
        $file_name = $report_month;

        $csv = new CSVWriter($header, $file_name);

        Log::whereHas('application', function($query) use($input, $csv, $user) {
                $query->whereHas('notes', function($query) use($input, $csv, $user) {
                    $query->where('admin_id',1);
                });
                $query->whereDate('disbursement_date','>=',Carbon::parse($input->get('start_date'))->format('Y-m-d'))
                    ->whereDate('disbursement_date','<=',Carbon::parse($input->get('end_date'))->format('Y-m-d'))
                    ->whereIn('id',[$user->applications()->pluck('id')]);
                })
            ->where('field','status')->where('new_value', 'sanctioned')->chunk(100, 
                function ($logs) use($csv) {
                    foreach ($logs as $log) {
                    $notes = $log->application->notes
                            ->where('admin_id',1)
                            ->pluck('text')
                            ->toArray();
                    // Loop over array and add "@att.com" to the end of the phone numbers
                    foreach ($notes as $key => $value) {
                        $count = $key+1;
                        $notes[$key] = 'Note - '.$count.' : '.$value;
                    }
                    // join array with a comma
                    $notes_data = implode(",", $notes);

                    $data = array(
                        $log->application_id,
                        $log->admin_id,
                        $log->application->pin_number,
                        $log->application->status,
                        $notes_data
                    );
                   $csv->addRow($data);
                }
            });  
        $csv->close();
        Session::flash('info','Approval Log Report Generated');
    }

    /**
     * Display filter to select date for Penalty report.
     * @return \Illuminate\Http\Response
     */
    public function viewPenaltyFilter(Request $input) 
    {
        return view ('admin.pages.report.penalty_filter',['input'=>$input]);
    }

    /**
     * Export the penalty report.
     * @return \Illuminate\Http\Response
     */
    public function penaltyReport(Request $input) 
    {
        $user = Auth::user();
        
        $overdue_month = Carbon::parse($input->closure_date)->format('Y-m');
        
        $header = array('ID', 'PIN', 'Late Payment Charges', 'Dishonor Charges', 'Status', 'NDC Send');

        $file_name = 'Penalty Report - '.Carbon::parse($overdue_month)->format('F, Y');

        $csv = new CSVWriter($header, $file_name);
        
        $user->applications()->where('type','loan')->whereIn('status',['disbursed', 'closed'])->take(100)
            ->chunk(100,function ($applications) use($csv, $overdue_month, $input) {
                foreach($applications as $application) {
                    $closure_date = $input->closure_date;
                    
                    if($closure_date==null) {
                        $closure_date = Carbon::today()->format('d-m-Y');
                    }
                    
                    $first_repayment = $application->accountRepaymentSchedule->where('type', 'emi')->first();
                    $last_repayment = $application->accountRepaymentSchedule->where('type', 'emi')->last();

                    if ((Carbon::parse($closure_date)->format('Y-m-d') >= $first_repayment->emi_month) && (Carbon::parse($closure_date)->format('Y-m-d') <= $last_repayment->emi_month)){
                        $overdue_month = Carbon::parse($closure_date)->format('Y-m');
                    } elseif ((Carbon::parse($closure_date)->format('Y-m-d') < $first_repayment->emi_month)){
                        $overdue_month = Carbon::parse($first_repayment->emi_month)->format('Y-m');
                        $closure_date = $first_repayment->emi_month;
                    } else {
                        $overdue_month = Carbon::parse($last_repayment->emi_month)->format('Y-m');
                        $closure_date = $last_repayment->emi_month;
                    }

                    $no_of_bounced_cheque = $application->getBouncedCheque($closure_date);
                    $dishonor_charges = $no_of_bounced_cheque*500;
                    $late_payment_charges_data = $application->getClosureLatePaymentCharges($input->closure_date);
                    $late_payment_charges = $late_payment_charges_data['late_payment_charges'];
                    $ndc_status = "No";
                    if($application->ndc_sent=="1") {
                        $ndc_status = "Yes";
                    }
                    $csv_row =  [
                        'id'=>$application->id,
                        'pin_number'=>$application->pin_number,
                        'late_payment_charges'=>$late_payment_charges,
                        'dishonor_charges'=>$dishonor_charges,
                        'status' => $application->status,
                        'ndc_send' => $ndc_status
                    ];
                    $csv->addRow($csv_row);
                }
            });
        $csv->close();

        Session::flash('info','Penalty Report Generated');
    }
}   
