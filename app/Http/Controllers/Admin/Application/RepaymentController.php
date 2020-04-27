<?php

namespace App\Http\Controllers\Admin\Application;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Note;
use Session;
use Redirect;
use Zipper;
use Carbon\Carbon;
use App\User;
use App\Application;
use PDF;
use Input;
use App\Borrower;
use App\Log;
use App\Location;
use App\Helpers\SMSProvider;
use App\Helpers\Alerts;
use Terbilang;
use App\RejectionReason;
use App\Product;
use App\Reference;
use App\Hospital;
use App\RepaymentCheque;
use App\FamilyMember;
use App\Document;
use File;
use DB;
use Excel;
use Mail;
use App\RepaymentSchedule;
use App\OutstandingPrincipalReport;
use App\Http\Controllers\Admin\Application\AccountRepaymentController;
use App\Admin;
use App\Helpers\CSVWriter;
use Log as DataLog;

class RepaymentController extends Controller
{
    //Defining Required Field Validator
    protected  $validationRules = [
        'type' => 'required'
    ];

    /**
     * Save Repayment Cheque for this application
     * @param  [int]  $application_id 
     * @param  Request $input          [form data]
     * @return \Illuminate\Http\Response
     */
    public function saveRepaymentCheque($application_id,Request $input) 
    {
        $this->validate($input,$this->validationRules);
        $cheque_series=$input->get('series');
        $cheque_series = $cheque_series ?  $cheque_series :1;
       
        for ($series=0; $series< $cheque_series;$series++) {
            $start_cheque_number =  $input->get('cheque_number');
            $next_cheque_number =  $series == 0 ? $start_cheque_number : $series + $start_cheque_number;
            $size= strlen($next_cheque_number);
            
            switch ($size) {
                case '6':
                    $next_cheque_number=$next_cheque_number;
                    break;
                case '5':
                    $next_cheque_number='0'.$next_cheque_number;              
                    break;
                case '4':
                    $next_cheque_number='00'.$next_cheque_number;                 
                    break;
                case '3':
                    $next_cheque_number='000'.$next_cheque_number;
                    break;
                case '2':
                    $next_cheque_number='0000'.$next_cheque_number;
                    break;
                case '1':
                    $next_cheque_number='00000'.$next_cheque_number;
                    break;
            }
            $cheque_type = $input->get('type');

            //if type is pdc add 1 month to existing date. 
            if ($cheque_type=="pdc") {
                if($input->get('cheque_date')!="") {
                    $cheque_date = Carbon::parse($input->get('cheque_date'))->addMonth($series);    
                } else {
                    $cheque_date = $input->get('cheque_date');
                }
                
            } else {
                $cheque_date = $input->get('cheque_date');
            }            

            $repaymentCheque = RepaymentCheque::create([
                                'application_id'=>$application_id,'borrower_name'=>ucfirst($input->get('borrower_name')),
                                'bank_name'=>ucfirst($input->get('bank_name')),'cheque_number'=>$next_cheque_number,
                                'branch'=>ucfirst($input->get('branch')),'amount'=>$input->get('amount'),
                                'series' =>$input->get('series'),'cheque_date' =>$cheque_date,
                                'type' =>$input->get('type')
                               ]);
        }      
        Session::flash('info','Repayment Cheque added');
        
        return redirect()->back();
    }

    /**
     * Delete Repayment Cheque for this application
     * @param  [int] $id [application id]
     * @return \Illuminate\Http\Response
     */
    public function deleteRepaymentCheque($id)
    {
        RepaymentCheque::destroy($id);
        Session::flash('info','Repayment Cheque deleted');
    
        return redirect()->back();
    }

    /**
     * [pdcSummary  provide pdc for the period of 15 days of each month]
     * @return      \Illuminate\Http\Response
     */
    public function pdcSummary()
    {
        $today = Carbon::today(); //todays date
        //check if todays date is less than 16
        $pdcs=collect();
        if($today->format('d') < 16) {

            //$start_of_month = Carbon::today()->subMonth(1)->startOfMonth();
            $mid_of_month = Carbon::today()->subMonth(1)->startOfMonth()
                            ->average(Carbon::today()->subMonth(1)->endOfMonth());
            $end_of_month = Carbon::today()->subMonth(1)->endOfMonth();
            
            $second_half_of_month_pdcs = RepaymentCheque::where('type','pdc')
                                    ->whereBetween('created_at',
                                                  [ $mid_of_month,
                                                    $end_of_month
                                                  ])
                                    ->get()->sortBy('id');
            $date = $mid_of_month->format('d').' to '.$end_of_month->format('d').' '.$end_of_month->format('F Y');
            $pdcs->push($second_half_of_month_pdcs);
            $data = ['pdcs'=>$pdcs,'date'=>$date];

            $pdf = $this->exportPDC($data);
            Session::flash('info','PDC Report Sent');
            return redirect('/admin/dashboard');
        } else {
            $start_of_month = Carbon::today()->startOfMonth();
            $mid_of_month = Carbon::today()->startOfMonth()->average(Carbon::today()->endOfMonth());
            //$end_of_month = Carbon::today()->endOfMonth();
            
            $first_half_of_month_pdcs = RepaymentCheque::where('type','pdc')
                                    ->whereBetween('created_at',
                                                  [ $start_of_month,
                                                    $mid_of_month
                                                  ])
                                    ->get()->sortBy('id');
            $date = $start_of_month->format('d').' to '.$mid_of_month->format('d').' '.$mid_of_month->format('F Y');
            $pdcs->push($first_half_of_month_pdcs);
            $data = ['pdcs'=>$pdcs,'date'=>$date];

            $pdf = $this->exportPDC($data);
            Session::flash('info','PDC Report Sent');
            return redirect('/admin/dashboard');
        }  
    }

    public function exportPDC($data)
    {
        $date = $data['date'];
        $pdf =  PDF::loadView('admin.pages.application.pdc_report', $data)->setPaper('a4');
        //return $pdf->download('PDC Report for '.$data['date']);
        //return view ('admin.pages.application.pdc_report')->with($data);
        Mail::send('emails.admin.pdc_report', ['date'=>$data['date']],
            function ($mail) use ($pdf,$date)
            {
                $mail->to("prashant@awkword.in", 'Arogya Finance')
                     ->subject("PDC Report")
                     ->attachData($pdf->output(),'PDC for period '.$date.'.pdf');
            }); 
        return $pdf;               
    }

    /**
     * [currentMonthEMI list all the disbursed cases current month pdc cheques]
     * @return [type] [description]
     */
    public function currentMonthEMI(Request $input)
    {      
        return view('admin.pages.emi.index',['input'=>$input]);
    }

    public function generateRepaymentEMIData($application,$data)
    {
        if($data!=null) {
            $emi_data = ['id' => $application->id,
                'pin_number'=>$application->pin_number,
                'borrower_name'=>$application->borrower->first_name.' '.
                              $application->borrower->middle_name.' '.
                              $application->borrower->last_name,
                'emi'=> $application->approved_loan_emi,
                'type' => $data->type,
                'cheque_date' => Carbon::parse($data->cheque_date)->format('d-m-Y'),
                'bank_name' => $data->bank_name,
                'cheque_number' => $data->cheque_number,
                'branch' => $data->branch,
                'amount' => $data->amount
            ];
        } else {
            $emi_data = ['id' => $application->id,
                'pin_number'=>$application->pin_number,
                'borrower_name'=>$application->borrower->first_name.' '.
                              $application->borrower->middle_name.' '.
                              $application->borrower->last_name,
                'emi'=> $application->approved_loan_emi,
                'type' =>'-',
                'cheque_date' => '-',
                'bank_name' => '-',
                'cheque_number' => '-',
                'branch' => '-',
                'amount' => '-'
            ];
        }

        return $emi_data;      
    }

    /**
     * exportCurrentMonthEMI download report of current month pdc
     */
    public function exportCurrentMonthEMI(Request $input)
    {
        $user = Auth::user();
        $current_year_month = Carbon::now()->format('Y-m');
        if($input->has('cheque_date') && $input->cheque_date!='all') {
            $report_month = Carbon::today()->format('Y-m').'-'.$input->cheque_date;
        } else {
            $report_month = Carbon::today()->format('Y-m');
        }

        $header = array('ID','PIN','Borrower Name','EMI','Type','Cheque/ACH Date','Bank Name','Cheque Number/UMRN','Bank Branch/IFSC','Amount');

        $file_name = 'EMI Report - '.$report_month;

        $csv = new CSVWriter($header, $file_name);
        
        $disbursed_loan_applications = $user->applications()->where('status','disbursed')
            ->where('type','loan')
            ->select('id','type','status','valid_from','pin_number','approved_loan_emi');

        if($input->has('cheque_date') && $input->cheque_date!='all') {
            $disbursed_loan_applications = $disbursed_loan_applications
              ->where('valid_from','like','%________'.$input->cheque_date.'%');
        }

        $disbursed_loan_applications->chunk(100,function ($applications) use($csv, $input, $current_year_month) {
                //DataLog::info('application 100 chunk for od report - '.microtime());
                foreach ($applications as $application) {

                    $data = $this->getOverdueAndDPD($application, $current_year_month);
                    $overdues = $data['overdues'];
                    $current_acc_repayment_schedule = $application->accountRepaymentSchedule()
                        ->where('type','emi')->where('emi_month','like',"%".$current_year_month."%")->first();
                  
                    if(isset($current_acc_repayment_schedule)) {
                        $ach = $application->repaymentCheques()->where('type','ach')->first();
                        if(isset($ach)) {
                            $emi_data = $this->generateRepaymentEMIData($application,$ach);
                            $csv->addRow($emi_data);
                        } else {
                            $pdc = $application->repaymentCheques()->where('type','pdc');
                            if($input->has('cheque_date') && $input->cheque_date!='all') {
                                $pdc = $pdc->where('cheque_date','like',"%".$current_year_month."-".$input->cheque_date)->first();
                            } else {
                                $pdc = $pdc->where('cheque_date','like',"%".$current_year_month."%")->first();
                            }
                            if (isset($pdc)) {
                                $emi_data = $this->generateRepaymentEMIData($application,$pdc);
                                $csv->addRow($emi_data);
                            } else {
                                $emi_data = $this->generateRepaymentEMIData($application,$pdc=null);
                                $csv->addRow($emi_data);
                            }
                        }
                    } else {
                        if($overdues>0) {
                            $ach = $application->repaymentCheques()->where('type','ach')->first();
                            if(isset($ach)) {
                                $emi_data = $this->generateRepaymentEMIData($application,$ach);
                                $csv->addRow($emi_data);
                            } else {
                                $pdc = $application->repaymentCheques()->where('type','pdc');
                                if($input->has('cheque_date') && $input->cheque_date!='all') {
                                    $pdc = $pdc->where('cheque_date','like',"%".$current_year_month."-".$input->cheque_date)->first();
                                } else {
                                    $pdc = $pdc->where('cheque_date','like',"%".$current_year_month."%")->first();
                                }
                                if (isset($pdc)) {
                                    $emi_data = $this->generateRepaymentEMIData($application,$pdc);
                                    $csv->addRow($emi_data);
                                } else {
                                    $emi_data = $this->generateRepaymentEMIData($application,$pdc=null);
                                    $csv->addRow($emi_data);
                                }
                            }
                        }
                    }
                }
                //DataLog::info('added 100 application chunk - '.microtime());
            });
        $csv->close();
        //DataLog::info('od report generated - '.microtime());
        Session::flash('info','OD Report Generated');
    }

    /**
     * Update Existing Repayment Cheque Dates
     */
    public function updateRepaymentChequesDate()
    {
      $applications = Application::whereIn('status',['sanctioned','disbursed'])->get(['id','valid_from']);
      foreach ($applications as $application) {
        $valid_from = Carbon::parse($application->getOriginal('valid_from'))->format('Y-m-d');
        $pdcs = $application->repaymentCheques()->where('type','pdc')->get();

        if($pdcs->count()) {
            $i = 0;
          foreach ($pdcs as $pdc) {               
             $pdc->cheque_date=Carbon::parse($application->getOriginal('valid_from'))->addMonthNoOverflow($i);
              $pdc->save();
             $i++; 
          }
        }
      }
      return "updated";   
    }


    /**
     * [Display Ideal Repayment Schedule in blade]
     * @param  [integer] $id [application id]
     * @return [object]     [Application object]
     */
    public function getRepaymentSchedule($id)
    {
        $application = Application::find($id);
        return view('admin.pages.application.repayment_schedule')->with(['application'=>$application]);
    }

    /**
     * [Display Repayment Collection Data in blade]
     * @param  [integer] $id [application id]
     * @return [object]     [Application object]
     */
    public function repaymentCollections($id)
    {
        $application = Application::find($id);
        $collections = $application->collections()->noBounce()->get()->sortBy('emi_payment_date');
        return view('admin.pages.application.repayment_collections')
          ->with(['application'=>$application, 'collections'=>$collections]);
    }

    /**
     * [Display a form to import Collection Data into Arogya System]
     * @return \Illuminate\Http\Response
     */
    public function importRepaymentCollectionsForm()
    {
        $title = "Import Repayment Collections";
        return view('admin.pages.application.import',['title'=>$title]);
    }

    /**
     * [Import Collection Data into Arogya System]
     * @return \Illuminate\Http\Response
     */
    public function importRepaymentCollections(Request $input)
    {   ini_set('max_execution_time', 6000); 
        if ($input->hasFile('sample_file')) {
            $path = $input->file('sample_file')->getRealPath();
            $data = \Excel::load($path)->get();
            $pins = collect();
            if ($data->count()>0) {
                $sheets = $data->toArray();
                foreach ($sheets as $row) {
                    //dd($row['pin']);
                    $application = Application::where('pin_number',$row['pin'])->where('type','loan')->first();
                    //$application = Application::find(preg_replace('/\s+/', '', $row['id']));
                    if ($application) {
                        //$this->updateFlatRate($application, $row);
                        //$this->updatePinNumberAndDate($application, $row);
                        $this->closeApplications($application, $row);
                        //$this->updateBorrowerMobile($application, $row);
                    }
                }
            }
        }
        //dd($pins);
        //Session::flash('info','Flat interest rate updated');
        //Session::flash('info','Interest & Valid From Date updated');
        //Session::flash('info','Repayment Collection imported Successfully');
        //Session::flash('info','Application closed');
        Session::flash('info','Borrower mobile updated');
        return redirect()->back();
    }

    /**
     * [update flatrate of applications]
     * @param  [object] $application
     * @param  [array] $row         [excel row data]
     */
    public function updateFlatRate($application, $row)
    {
        $application->interest_rate=$row['roi'];
        //$application->interest_rate=8.25;  //default medtronic
        $application->approved_loan_emi=$application->flat_interest_rate;
        $application->save();
    }

    /**
     * [update pin number of applications]
     * @param  [object] $application
     * @param  [array] $row         [excel row data]
     */
    public function updatePinNumberAndDate($application, $row)
    {
        //$application->pin_number=$row['pin_number'];
        $application->disbursement_date=$row['disbursement_date'];
        $application->valid_from=$row['valid_from'];
        $application->save();
    }

    /**
     * [Update applications status to closed]
     * @param  [object] $application
     * @param  [array] $row         [excel row data]
     */
    public function closeApplications($application, $row)
    {
        $old_value = $application->status;
        $new_value = $application->status='closed';
        $application->closer_reason_id=$row['reason'];
        $application->closer_date = $row['closer_date']->format('Y-m-d');
        $application->save();
        Log::store($application->id,Auth::user()->id,'status',$old_value,$new_value);
    }

    /**
     * [Update borrower mobile number]
     * @param  [object] $application
     * @param  [array] $row         [excel row data]
     */
    public function updateBorrowerMobile($application, $row)
    {
        if($application->borrower){
            $borrower = $application->borrower;
            $borrower->mobile_number = $row['mobile_number'];
            $borrower->save();
        }
    }

    public function getAccountRepaymentSchedule($id,$export=null)
    {
        $application = Application::find($id);
        $ac_repayment_schedules = $application->accountRepaymentSchedule;
        $overdue_month = Carbon::now()->format('Y-m');
        //$overdue_month = '2017-11';
        if($ac_repayment_schedules->count()) {
          $data = $this->getOverdueAndDPD($application, $overdue_month);
          $overdues = $data['overdues'];
          $dpd = $data['dpd'];
          $bounced_cheque = $this->getBouncedCheque($application);
        } else {
          $overdues = 0;
          $dpd = 0;
          $bounced_cheque =0;
        }
        
        $collections = $application->collections()->accountCollection()->get()->sortBy('emi_payment_date');
        //dd($ac_repayment_schedules);
        if(!$export){
            return view('admin.pages.application.account_repayment_schedule')
             ->with(['application'=>$application,'overdues'=>$overdues,
                     'dpd'=>$dpd,
                     'collections'=>$collections, 
                     'ac_repayment_schedules'=>$ac_repayment_schedules,
                     'bounced_cheque'=>$bounced_cheque]);
        } else {
            return [ 'collections'=>$collections,'overdues'=>$overdues,
                    'ac_repayment_schedules'=>$ac_repayment_schedules];
        }

    }

    public function getOverdueAndDPD($application, $overdue_month/*, $start_time*/)
    {
        $first_emi = $application->accountRepaymentSchedule()->first();

        // time - 0.030 | delta = 0.024         
        // time - 0.018 | delta = 0.012 ()
        //$end_time =  microtime(true) - $start_time;
        //dd($end_time);

        $last_emi = $application->accountRepaymentSchedule->last();
        // time - 0.018 | delta = 0.012 ()
        //$end_time =  microtime(true) - $start_time;
        //dd($end_time);

        /*$current_emi = $application->accountRepaymentSchedule()
            ->where('emi_month','like','%'.Carbon::parse($overdue_month)->format('Y-m').'%')
            ->first();*/
        $current_emi = $application->accountRepaymentSchedule
            ->first(function ($key, $value) use($overdue_month) {
                if(Carbon::parse($value->emi_month)->format('Y-m')==Carbon::parse($overdue_month)->format('Y-m')) {
                    return $value;
                }
            });
        // time - 0.077
        //$end_time =  microtime(true) - $start_time;
        //dd($end_time);

        if($current_emi) {
            /*$repayment_months = $application->accountRepaymentSchedule()->whereDate('emi_month','<=',$current_emi->emi_month);*/
            $repayment_months = $this->getReapymentMonths($application, $current_emi->emi_month);
            /*$repayment_months = $application->accountRepaymentSchedule
            ->filter(function ($value) use($current_emi) {
                    return Carbon::parse($value->emi_month)->format('Y-m') <= Carbon::parse($current_emi->emi_month)->format('Y-m');
                }
            );*/
            // time - 0.090
            //$end_time =  microtime(true) - $start_time;
            //dd($end_time,$repayment_months);

            //dd($repayment_months);
            //dd($repayment_months->get());
            /*$current_repayment_months = $application->accountRepaymentSchedule()
                ->where('emi_month',$current_emi->emi_month)->first();*/
            $current_repayment_months = $current_emi;

            //dd($current_repayment_months);
            /*$positive_outstanding = $application->accountRepaymentSchedule()->whereDate('emi_month','<=',$current_emi->emi_month)->where('outstanding_principal','>=',0);
            dd($positive_outstanding->get());*/
            $positive_outstanding = $repayment_months->filter(function ($value) {
                return $value->outstanding_principal >= 0;
            });

            // time - 0.090
            //$end_time =  microtime(true) - $start_time;
            //dd($end_time);
            /*$negative_outstanding = $application->accountRepaymentSchedule()->whereDate('emi_month','<=',$current_emi->emi_month)->where('outstanding_principal','<',0)->first();*/
            $negative_outstanding = $repayment_months->first(function ($key, $value) {
                return $value->outstanding_principal < 0;
            });

            $current_date = Carbon::now()->endOfMonth()->format('Y-m-d');
            if($positive_outstanding) {
                //$current_date = '2017-11-30';
                if($negative_outstanding) {
                    $collection_tobe_done = $positive_outstanding->sum('emi')+$negative_outstanding->emi;
                } else {
                    $collection_tobe_done = $positive_outstanding->sum('emi');
                }
              
                /*$principal_adjustment = $application->accountRepaymentSchedule()->whereDate('emi_month','<=',$current_emi->emi_month)->sum('principal_adjustment_amount');*/
                $principal_adjustment = $repayment_months->sum('principal_adjustment_amount');

                //dd($principal_adjustment);
                $collected_amount = $application->collections()->accountCollection()->where('emi_payment_date','<=',$current_date)/*->get()*/->sum('amount_received');
                // time - 0.090
                //$end_time =  microtime(true) - $start_time;
                if($collected_amount==null) {
                    $collected_amount=0;
                }
                //dd($end_time,$collected_amount);
                $total_collection = $collected_amount+$principal_adjustment;
                //dd($total_collection);
                //dd($collection_tobe_done,$collected_amount,$principal_adjustment);
                $overdues = round(($collection_tobe_done-$total_collection));
                $dpd = round(($overdues/$application->approved_loan_emi),2);
                //dd($overdues);
            } else {
                //$current_date = Carbon::now()->endOfMonth()->format('Y-m-d');
                //$current_date = '2017-11-30';
                $collection_tobe_done = $repayment_months->sum('emi');
                $collected_amount = $application->collections()->accountCollection()->where('emi_payment_date','<=',$current_date)/*->get()*/->sum('amount_received');
                if($collected_amount==null) {
                    $collected_amount = 0;
                }
                $overdues = round(($collection_tobe_done-$collected_amount));
                $dpd = round(($overdues/$application->approved_loan_emi),2);
            }
            /*if(Carbon::parse($current_emi->emi_month)->format('d')<Carbon::now()->format('d')) {

                $repayment_months = $application->accountRepaymentSchedule()->whereDate('emi_month','<=',$current_emi->emi_month)->get();
                $current_repayment_months = $application->accountRepaymentSchedule()
                    ->where('emi_month',$current_emi->emi_month)->first();

                } else {

                $repayment_months = $application->accountRepaymentSchedule()
                  ->whereBetween('emi_month',[$first_emi->emi_month,Carbon::parse($current_emi->emi_month)->subMonth(1)])->get();

                $current_repayment_months = $application->accountRepaymentSchedule()
                  ->where('emi_month',Carbon::parse($current_emi->emi_month)->subMonth(1))->first();
            }*/
        } else {
            $current_date = Carbon::parse($overdue_month)->format('Y-m-d');
            //$current_date = Carbon::now()->endOfMonth()->format('Y-m-d');
            //$current_date = '2017-11-30';
            if($current_date<$first_emi->emi_month){
                $repayment_months = collect();
                $current_repayment_months = null;
                $overdues =0;
                $dpd = 0;
                $collected_amount = 0;
            } else {
                $repayment_months = $this->getReapymentMonths($application, $last_emi->emi_month);
                //$repayment_months = $application->accountRepaymentSchedule()->whereDate('emi_month','<=',$last_emi->emi_month);
                //dd($repayment_months->get());
                // time - 0.090
                //$end_time =  microtime(true) - $start_time;
                //dd($end_time,$repayment_months);

                /*$current_repayment_months = $application->accountRepaymentSchedule()->where('emi_month',$last_emi->emi_month)->first();*/
                $current_repayment_months = $last_emi;

                /*$positive_outstanding = $application->accountRepaymentSchedule()->whereDate('emi_month','<=',$last_emi->emi_month)->where('outstanding_principal','>=',0);*/
                //dd($positive_outstanding->get());
                $positive_outstanding = $repayment_months->filter(function ($value) {
                    return $value->outstanding_principal >= 0;
                });
                //dd($positive_outstanding);
                /*$negative_outstanding = $application->accountRepaymentSchedule()->whereDate('emi_month','<=',$last_emi->emi_month)->where('outstanding_principal','<',0)->first();*/
                $negative_outstanding = $repayment_months->first(function ($key, $value) {
                    return $value->outstanding_principal < 0;
                });
                //dd($negative_outstanding);
                if($positive_outstanding) {
                    //$current_date = Carbon::now()->endOfMonth()->format('Y-m-d');
                    //$current_date = '2017-11-30';
                    if($negative_outstanding) {
                        $collection_tobe_done = $positive_outstanding->sum('emi')+$negative_outstanding->emi;
                    } else {
                        $collection_tobe_done = $positive_outstanding->sum('emi');
                    }
                    //dd($collection_tobe_done);
                    /*$principal_adjustment = $application->accountRepaymentSchedule()->whereDate('emi_month','<=',$last_emi->emi_month)->get()->sum('principal_adjustment_amount');*/
                    $principal_adjustment = $repayment_months->sum('principal_adjustment_amount');
                    //dd($principal_adjustment);

                    //dd($principal_adjustment);
                    $collected_amount = $application->collections()->accountCollection()->where('emi_payment_date','<=',$current_date)/*->get()*/->sum('amount_received');
                    if($collected_amount==null) {
                        $collected_amount=0+$principal_adjustment;
                    } else {
                        $collected_amount=$collected_amount+$principal_adjustment;
                    }
                    $overdues = round(($collection_tobe_done-$collected_amount));
                    $dpd = round(($overdues/$application->approved_loan_emi),2);
                } else {
                    //$current_date = Carbon::now()->endOfMonth()->format('Y-m-d');
                    //$current_date = '2017-11-30';
                    //$collection_tobe_done = $application->accountRepaymentSchedule()->whereDate('emi_month','<=',$last_emi->emi_month)->sum('emi');
                    $collection_tobe_done = $repayment_months->sum('emi');
                    $collected_amount = $application->collections()->accountCollection()->where('emi_payment_date','<=',$current_date)/*->get()*/->sum('amount_received');
                    if($collected_amount==null) {
                        $collected_amount = 0;
                    }
                    $overdues = round(($collection_tobe_done-$collected_amount));
                    $dpd = round(($overdues/$application->approved_loan_emi),2);
                }
            }        
        }
        $bounced_charges = $application->collections()
            ->bounce()
            ->where('amount_received','<=',0)
            ->where('emi_payment_date','<=',Carbon::parse($overdue_month)->format('Y-m-d'))
            ->count();
        $requested_month_payment = '';
        $requested_month_date = '';
        $amount_due= '';
        /*$till_date_amount_due = $application->accountRepaymentSchedule()
            ->whereDate('emi_month','<=',Carbon::parse($overdue_month)->format('Y-m-d'))
            ->get();*/
        $till_date_amount_due = $this->getReapymentMonths($application, Carbon::parse($overdue_month)->format('Y-m-d'));    
        //dd($till_date_amount_due);
        if($till_date_amount_due->count()) {
            $amount_due = $till_date_amount_due->sum('emi');
        }
        //dd($amount_due);
        
        /*$collection_for_month = $application->accountRepaymentSchedule()
            ->where('type','emi')
            ->where('emi_month','like',Carbon::parse($overdue_month)->format('Y-m').'%')
            ->get();*/
        //dd($collection_for_month);
        /*$collection_for_month = $application->accountRepaymentSchedule
            ->where('type', 'emi')
            ->first(function ($key, $value) use($overdue_month) {
            if(Carbon::parse($value->emi_month)->format('Y-m')==Carbon::parse($overdue_month)->format('Y-m')) {
                return $value;
            }
        });*/
        //dd($current_emi,$collection_for_month);
        if($current_emi) {
            $requested_month_payment = $current_emi->amount_received;
            $requested_month_date = $current_emi->emi_payment_date;
        }
      
        //dd($requested_month_payment,$requested_month_date,$current_emi);
        $location = '';
        if($application->location) {
            $location = $application->location->name;
        }
      
        $punchBy = '';
        if($application->admin_id) {
            $user = Admin::find($application->admin_id);
            if($user->hasRole(['counsellor'])) {
                $punchBy = $user->first_name.' '.$user->last_name;
            }
        }

        if($current_repayment_months!=null) {
            $principal = $current_repayment_months->principal;
            $interest = $current_repayment_months->interest;
            $outstanding_principal = $current_repayment_months->outstanding_principal;
        } else {
            $principal = 0;
            $interest = 0;
            $outstanding_principal = 0;
        }

        $od_report =  [
            'application_id'=>$application->id,
            'pin_number'=>$application->pin_number,
            'loan_amount'=>$application->approved_loan_amount,
            'emi'=>$application->approved_loan_emi,
            'no_of_advance_emi'=>$application->advance_emi,
            'valid_from'=>$application->getOriginal('valid_from'),
            'valid_upto'=>$application->getOriginal('valid_upto'),
            'disbursement_date'=>$application->disbursement_date,
            'interest_rate'=>$application->interest_rate,
            'tenure'=>$application->approved_loan_tenure,
            'overdue_amount'=>$overdues,
            'principal'=>$principal,
            'interest'=>$interest,
            'outstanding_principal'=>$outstanding_principal,
            'overdue_in_months'=>$dpd,
            'total_collection'=>$collected_amount,
            'amount_due'=>$amount_due,
            'processing_fee'=>round($application->processing_fee_amount),
            'document_charge'=>$application->documentation_charge_gst,
            'bounced_charges'=>$bounced_charges,
            'requested_month_payment'=>$requested_month_payment,
            'requested_month_date'=>$requested_month_date,
            'location'=>$location,
            'punchBy'=>$punchBy,
            'status'=>$application->status,
            'borrower_name'=>$application->borrower->first_name.' '.$application->borrower->last_name,
            'borrower_mobile'=>$application->borrower->mobile_number,
            'borrower_address'=>$application->borrower->address_line_1.' '.$application->borrower->address_line_1,
            'contract_value'=>$application->approved_loan_emi*$application->approved_loan_tenure,
            'total_bounced_charges'=>$bounced_charges*500
        ];


        /*$od = OutstandingPrincipalReport::where('application_id',$application->id)
            ->first();
        if($od){
          $od->update($od_report);
        } else {
          OutstandingPrincipalReport::create($od_report);
        }*/
        //dd($od_report);
        return ['dpd'=>$dpd,'overdues'=>$overdues,'od_report'=>$od_report];
    }

    public function getReapymentMonths($application, $emi_date)
    {
        $repayment_months = $application->accountRepaymentSchedule
            ->filter(function ($value) use($emi_date) {
                    return Carbon::parse($value->emi_month)->format('Y-m') <= Carbon::parse($emi_date)->format('Y-m');
                }
            );

        return $repayment_months;
    }

    public function exportCollections($id)
    {
        $application = Application::find($id);
        $data = $this->getAccountRepaymentSchedule($id,$export="yes");
        Excel::create($application->pin_number.'_Collections', function($excel) use($application, $data) {
            $excel->sheet('Sheet1', function($sheet) use($application, $data) {
                $collections = $data['collections'];
                $ac_repayment_schedules = $data['ac_repayment_schedules'];
                $overdue = $data['overdues'];
                $arr =array();
                $data=array('');
                array_push($arr,$data);
                $data=array('Month at', 'Type', 'EMI Month', 'EMI', 'Principal', 
                  'Interest', 'outstanding Principal', 
                  'Amount Received', 'EMI Payment Date','Delay Charges');
                array_push($arr,$data);
                if($application->advance_emi) {
                    $month_at = 0;
                } else {
                    $month_at = 1;                    
                }
                foreach ($ac_repayment_schedules as $ac_repayment_schedule) {
                    $collection_data['month_at'] = $month_at++;
                    $collection_data['type'] = $ac_repayment_schedule['type'];
                    $collection_data['emi_month'] = Carbon::parse($ac_repayment_schedule['emi_month'])->format('d-m-Y');
                    $collection_data['emi'] = $ac_repayment_schedule['emi'];
                    $collection_data['principal'] = $ac_repayment_schedule['principal'];
                    $collection_data['interest'] = $ac_repayment_schedule['interest'];
                    $collection_data['outstanding_principal'] = $ac_repayment_schedule['outstanding_principal'];                    
                    $collection_data['amount_received'] = 0;
                    $collection_data['emi_payment_date'] = '';
                    $collection_data['delay_charges'] = $ac_repayment_schedule['delay_charges'];
                    array_push($arr, $collection_data);
                }
                $row_first = 3;
                foreach ($collections as $collection) {
                    $sheet->cell('H'.$row_first, function($cell) use($collection,$row_first){
                          // manipulate the cell
                          $cell->setValue($collection->amount_received);
                    });
                    $sheet->cell('I'.$row_first, function($cell) use($collection,$row_first){
                        // manipulate the cell
                        $cell->setValue(Carbon::parse($collection->emi_payment_date)->format('d-m-Y'));
                    });
                    
                    $row_first++;
                }
                //dd($sheet);
                $sheet->fromArray($arr,null,'A1',false,false)
                    ->prependRow(array('','PIN',$application->pin_number,'','Overdue',
                        $overdue));
            });
        })->export('xlsx');
    }

    public function generateOutstandingPrincipalReport()
    {
        $applications =Application::where('type','loan')->where('status','disbursed')->get();
        /*$applications =Application::where('id',9397)->get();*/
        $overdue_month = Carbon::now()->format('Y-m');
        //$overdue_month = '2019-03';
        $arr =array();
        foreach($applications as $application) {
            $this->getOverdueAndDPD($application, $overdue_month);
        }
        return "OverduerReport generated successfully";
    }


    /**
     * Get Numbers of bocued cheque
     */
    public function getBouncedCheque($application)
    {
        if($application->collections) {
            $bounced_cheque = $application->collections()
                ->where('type','bounce')
                //->where('amount_received','<',0)
                ->count();
        } else {
            $bounced_cheque = 0;
        }
        
        return $bounced_cheque;
    }

    public function importACHData(Request $input)
    {
        $import_error = collect();
        if ($input->hasFile('sample_file')) {
            $path = $input->file('sample_file')->getRealPath();
            $data = \Excel::load($path)->get();
            if ($data->count()>0) {
                $sheets = $data->toArray();
                $chunks = array_chunk($sheets, 100);
                foreach ($chunks as $chunk) {
                    foreach ($chunk as $row) {
                        //dd($row);
                        $pin = preg_replace('/\s+/', '', $row['pin_number']);
                        if(!empty($pin)){
                            $application =Application::where('pin_number',$pin)->where('type','loan')->first();
                            if($application) {
                                if($application->type=='loan') {
                                    if($application->status=='disbursed' || $application->status=='closed') {
                                        $data = [
                                            'application_id' => $application->id,
                                            'borrower_name' => ucfirst($row['borrower_name']),
                                            'bank_name' => ucfirst($row['bank_name']),
                                            'branch' => ucfirst($row['branch']),
                                            'amount' => $row['amount'],
                                            'series' => 1,
                                            'cheque_date' => $row['cheque_date'],
                                            'cheque_number' => $row['cheque_number'],
                                            'type' => 'ach'
                                        ];
                                        RepaymentCheque::create($data);
                                    } else {
                                        $import_error->push(['pin_number' => $row['pin_number'],
                                            'error' => "Failed to import ACH for PIN - ".$row['pin_number']." Application current status - ".ucfirst($application->status)
                                        ]);
                                    }
                                } else {
                                    $import_error->push(['pin_number' => $row['pin_number'], 
                                        'error' => "Failed to import ACH for PIN - ".$row['pin_number']." Application type is ".ucfirst($application->type)]);
                                }
                            } else {
                                $import_error->push(['pin_number' => $row['pin_number'], 
                                'error' => "Application with PIN - ".$row['pin_number']." doesn't exists."]);
                            }
                        }
                    }
                }
            }
        } else {
            $import_error->push(['pin_number' => '', 
                'error' => "Please select a valid file to import ACH data."]);
        }

        if($import_error->count()) {
            Session::flash('message',"Failed to import ACH data");
            return view('admin.pages.emi.import_error', 
                ['import_error'=>$import_error]
            );
        } else {
            Session::flash('info','ACH Data imported.');
            return redirect()->back();
        }
    }

    /**
     * export loan closure
     */
    public function exportClosure($id,Request $input)
    {
        $application = Application::find($id);
        $data = $this->getAccountRepaymentSchedule($id,$export="yes");
        Excel::create($application->pin_number.'_Collections', function($excel) use($application, $data, $input) {
            $excel->sheet('Sheet1', function($sheet) use($application, $data, $input) {
                $collections = $data['collections'];
                $ac_repayment_schedules = $data['ac_repayment_schedules'];
                $overdue = $data['overdues'];
                $arr =array();
                $data=array('');
                array_push($arr,$data);
                $data=array('Month at', 'Type', 'EMI Month', 'EMI', 'Principal', 
                  'Interest', 'outstanding Principal', 
                  'Amount Received', 'EMI Payment Date','Delay Charges');
                array_push($arr,$data);
                if($application->advance_emi) {
                    $month_at = 0;
                } else {
                    $month_at = 1;                    
                }
                foreach ($ac_repayment_schedules as $ac_repayment_schedule) {
                    $collection_data['month_at'] = $month_at++;
                    $collection_data['type'] = $ac_repayment_schedule['type'];
                    $collection_data['emi_month'] = Carbon::parse($ac_repayment_schedule['emi_month'])->format('d-m-Y');
                    $collection_data['emi'] = $ac_repayment_schedule['emi'];
                    $collection_data['principal'] = $ac_repayment_schedule['principal'];
                    $collection_data['interest'] = $ac_repayment_schedule['interest'];
                    $collection_data['outstanding_principal'] = $ac_repayment_schedule['outstanding_principal'];                    
                    $collection_data['amount_received'] = 0;
                    $collection_data['emi_payment_date'] = '';
                    $collection_data['delay_charges'] = $ac_repayment_schedule['delay_charges'];
                    array_push($arr, $collection_data);
                }
                $row_first = 9;
                foreach ($collections as $collection) {
                    $sheet->cell('H'.$row_first, function($cell) use($collection,$row_first){
                          // manipulate the cell
                          $cell->setValue($collection->amount_received);
                    });
                    $sheet->cell('I'.$row_first, function($cell) use($collection,$row_first){
                        // manipulate the cell
                        $cell->setValue(Carbon::parse($collection->emi_payment_date)->format('d-m-Y'));
                    });
                    
                    $row_first++;
                }
                $this->getLoanBasicDetail($sheet,$input,$application);
                $this->getLoanClosureDetail($sheet,$input,$application);

                /*$sheet->cell('H1', function($cell) use($input){
                        // manipulate the cell
                        $cell->setValue(Carbon::parse($input->closure_date)->format('j-F-Y'));
                    });*/
                //dd($sheet);
                $sheet->fromArray($arr,null,'A7',false,false)
                    /*->prependRow(array('Lo','PIN',$application->pin_number,'','Overdue',
                        $overdue))*/;
            });
        })->export('xlsx');
    }

    /**
     * add loan basic detail to excel sheet
     */
    public function getLoanBasicDetail($sheet,$input,$application)
    {
        $sheet->setCellValue('A1', 'LOAN STATEMENT DATED');
        $sheet->setCellValue('B1', Carbon::today()->format('j-M-Y'));
        $sheet->setCellValue('A2', 'PIN');
        $sheet->setCellValue('B2', $application->pin_number);

        $sheet->setCellValue('A3', 'Customer Name');
        $sheet->setCellValue('B3', $application->borrower->full_name);

        $sheet->setCellValue('A4', 'Sanctioned Loan amount');
        $sheet->setCellValue('B4', $application->approved_loan_amount);

        $sheet->setCellValue('A5', 'Tenure');
        $sheet->setCellValue('B5', $application->approved_loan_tenure);

        $sheet->setCellValue('A6', 'EMI Amount');
        $sheet->setCellValue('B6', $application->approved_loan_emi);
    }

    /**
     * add loan closure detail to excel sheet
     */
    public function getLoanClosureDetail($sheet,$input,$application)
    {
        $start_row_count = $application->accountRepaymentSchedule->count()+10;

        //fetch closure detail
        $acc_repayment_obj = new AccountRepaymentController;
        $closure_detail = $acc_repayment_obj->getClosureStatus($application->id, $input, $export='yes');
        
        $sheet->row($start_row_count, 
            ['Principal OS', $closure_detail['outstanding_principal']]
        );
        $sheet->row(++$start_row_count, 
            ['Overdue/EMI', $closure_detail['overdue']]
        );
        $sheet->row(++$start_row_count, 
            ['Bounced charges', $closure_detail['dishonor_charges']]
        );
        $sheet->row(++$start_row_count, 
            ['Late Payment  Charge', $closure_detail['late_payment_charges']]
        );
        $sheet->row(++$start_row_count, 
            ['Legal Charges', $closure_detail['legal_charges']]
        );
        $sheet->row(++$start_row_count, 
            ['Pre closure penalty', $closure_detail['pre_payment_charges']]
        );
        $sheet->row(++$start_row_count, 
            ['Final amount', $closure_detail['total_charges']]
        );

        //set note after loan closure detail
        $sheet->row($start_row_count+2, function ($row) {
            $row->setFontWeight('bold');
        });
        $sheet->row($start_row_count+2, ['NOTE: Amount valid till '.Carbon::parse($input->closure_date)->format('j-M-Y').'.']);
    }
}