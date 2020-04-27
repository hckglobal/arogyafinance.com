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
use Mail;
use \Milon\Barcode\DNS1D;
use App\CloserReason;
use App\Admin;
use App\OutstandingPrincipalReport;
use Log as DataLog;
use Exception;
use App\Http\Controllers\Website\Ingenico\IngenicoController;

class ApplicationController extends Controller
{
    /**
     * Display all the application
     * @param  [string] $type     [loan/card]
     * @param  [string] $category [one/two/three/four/others]
     * @param  [string] $status   [new]
     * @return \Illuminate\Http\Response
     */
    public function index($type,$category,$status)
    {
        if($status=="lead"){
            $title = 'Parital '.ucfirst($type).' Applications';
        } else {
            $title = ucfirst($status).' '.ucfirst($type).' Applications';
        }

        if ($category=="one" || $category =="two" || $category=="three" || $category=="four" || $category=="none") {
            $filter = 'category'.ucfirst($category);
        } else {
            $filter = $category;
        }

        $applications = Auth::user()->applications()->where('type',$type)
                        ->$filter()->where('status',$status)->get();

        return view ('admin.pages.application.index')
              ->with(['category'=>$category,'applications'=>$applications, 'title'=>$title]);
    }

    /**
     * Application show 
     * @param  [string] $type [loan,card]
     * @param  [int] $id   [application id]
     * @return \Illuminate\Http\Response
     */
    public function show($type,$id)
    {
        $application = Application::find($id);
        if ($application->type=="card") {
            $sanction_label="approve";
        } else {
            $sanction_label="sanction";
        }
        $locations = Location::all(); 
        $rejection_reasons = RejectionReason::all(); 
        $products = Product::all(); 
        $hospitals = Hospital::all();
        $title = ucfirst($application->type).' Application Detail'; 
        $status_log = $application->logs->where('new_value',$application->status)->last();
        $sanction_date = $application->logs->where('new_value','sanctioned')->last();
        $sanction_expired = "";
        if($sanction_date) {
            $current_date = Carbon::now();
            $sanctioned_date_diff = Carbon::parse($sanction_date->updated_at)->diffInDays($current_date);
            
            if($sanctioned_date_diff>31) {
                $sanction_expired = 'Sanction expired';
            }
        }

        if ($status_log) {
            $status_update_date = $status_log->updated_at;
        } else {
            $status_update_date ="";
        }
        
        $closer_reasons = CloserReason::all();
        $status = $application->status;
        $revert_stages = array();
        switch ($status) {
          case 'verified':
            array_push($revert_stages, 'New');
            break;
          case 'sanctioned':
            array_push($revert_stages, 'New','Verified');
            break;
          case 'disbursed':
            array_push($revert_stages, 'New','Verified','Sanctioned');
            break;
          case 'rejected':
            array_push($revert_stages, 'New');
            break;
        }
        
        // get the updated mandate status
        $mandate_obj = new IngenicoController();
        if($application->mandate) {
            $mandate_status = $mandate_obj->getMandateStatus($application);
            $mandate_umrn = $application->mandate->umrn;
        } elseif($application->ingenicoMandate) {
            $data = $mandate_obj->getMandateUpdatedStatus($application);
            $mandate = $data['mandate'];
            $mandate_status = $mandate->status;
            $mandate_umrn = $mandate->umrn;
        } else {
            $mandate_status = 'N/A';
            $mandate_umrn = 'N/A';
        }


        return view ('admin.pages.application.show')
            ->with(['application'=>$application, 'title'=>$title,
                    'status_update_date'=>$status_update_date, 'locations'=>$locations,
                    'rejection_reasons'=>$rejection_reasons,'products'=>$products,
                    'hospitals'=>$hospitals,'sanction_label'=>$sanction_label, 
                    'closer_reasons'=>$closer_reasons,'revert_stages'=>$revert_stages,
                    'sanction_expired'=>$sanction_expired, 'status' => $status,
                    'mandate_status'=>$mandate_status, 'mandate_umrn' => $mandate_umrn
                ]);   
    }

    /**
     * Destroy Application
     * @param  [string] $type [loan/card]
     * @param  [int] $id   [application id]
     * @return \Illuminate\Http\Response
     */
    public function destroy($type,$id)
    {
        $application = Application::find($id);
        if($application->borrowers->count()) {
            $application->borrowers()->delete();
            Application::destroy($id);
        } else {
            Application::destroy($id);
        }        
        Session::flash('info','Application deleted successfully');
        return redirect()->back();
    }

    /**
     * Store Notes for this application
     * @param  Request $input [form data]
     * @return \Illuminate\Http\Response
     */
    public function storeNotes(Request $input)
    {
        Note::create($input->all());
        Session::flash('info','Note added to application');
        return redirect()->back();
    }

    /**
     * Summary of Application 
     * @param  [int] $id [application id]
     * @return \Illuminate\Http\Response
     */
    public function summaryApplication($id)
    {
        $application = Application::find($id);
        $title = ucfirst($application->type).'Application Detail';
        $data = ['title'=>$title,'application'=>$application];
        $pdf = PDF::loadView('admin.pages.application.summary', $data)->setPaper('a4');
        
        //return $pdf->download($application->id.'_Application Summary.pdf');
        return view('admin.pages.application.summary')->with(['application' => $application,'title' => $title]);
    }

    /**
     * Update Application Status 
     * @param  [string]  $status 
     * @param  [int]  $id     [application id]
     * @param  Request $input  [form data]
     * @return \Illuminate\Http\Response
     */
    public function updateApplicationStatus($status,$id,Request $input)
    {
        //get application
        $application = Application::find($id);
        //get input
        $rejection_reason_id = $input->get('rejection_reason_id');
        $rejection_note = $input->get('rejection_note');
        //get old status
        $old_status = $application->status;
        if ($status == "rejected") {
            $application->update(["rejection_reason_id"=>$rejection_reason_id,"rejection_note"=>$rejection_note]);

            // create log for application status change
            $this->createApplicationLog($application, $old_status);
        }        
        //update status
        //if status disbursed set the disburstment date
        if ($status == 'disbursed') {
            $today_date  = Carbon::today();
            $advance_emi_deduct = $input->advance_emi_deduct ? 1 : 0;
            $subvention_deduct = $input->subvention_deduct ? 1 : 0;
            $document_processing_fee_deduct = $input->document_processing_fee_deduct ? 1 : 0;
            $application->update(['status'=>$status, 'disbursement_date'=>$today_date, 'advance_emi_deduct'=>$advance_emi_deduct,
                'subvention_deduct'=>$subvention_deduct, 'document_processing_fee_deduct'=>$document_processing_fee_deduct
                ]);

            // create log for application status change
            $this->createApplicationLog($application, $old_status);
            //generate A/c Repayment for the application
            $application->generateAccountRepaymentSchedules();            

            if ($application->type=='loan') {                
                $pdf = $this->getFirstLetterPDF($application);
                $this->sendFirstLetterToFC($application,$pdf);
                $this->sendFirstLetterToHospital($application);
                $this->sendFirstLetterToPartner($application);
            }            
        } elseif ($status == "sanctioned") {
            $application->update(['status'=>$status]);
            // create log for application status change
            $this->createApplicationLog($application, $old_status);
            $pdf = $this->getSanctionedLetterPDF($application);
            $this->sendSanctionLetterToFC($application,$pdf);
            $this->sendSanctionLetterToHospital($application,$pdf);
            $this->sendSanctionLetterToPartner($application,$pdf);   
        } elseif ($status == "verified") {
            $application->update(['status'=>$status]);
            // create log for application status change
            $this->createApplicationLog($application, $old_status);
            $admins = $application->location->admins;
            foreach ($admins as $admin) {
                if($admin->roles->first()->name=="counsellor"){
                    try {
                        Mail::send('emails.admin.send_verify_letter', 
                            ['application'=>$application,'admin'=>$admin],
                                function ($mail) use ($application, $admin) {
                                $mail->to('jay.modi@arogyafinance.com', 'Arogya Finance')
                                    ->subject('Verify Application');
                            }
                        );
                    } catch (\Exception $e) {
                        DataLog::useFiles(storage_path().'/logs/mail.log');
                        DataLog::info('catch = '.$e->getMessage());
                    }
                }                
            }            
        } else {
            $application->update(['status'=>$status]);
            // create log for application status change
            $this->createApplicationLog($application, $old_status);
        }
        
        //send sms
        $this->sendSMSToBorrower($application);    
      
        return redirect()->back();
    }

    /**
     * Send SMS To Borrower 
     * @param  [object] $application 
     * @return \Illuminate\Http\Response
     */
    public function sendSMSToBorrower($application) 
    {
        $borrower = $application->borrowers()->first();
        $status = $application->status;
        $phone_number = $borrower->mobile_number;

        switch ($status) {
            case "sanctioned":
                $message = Alerts::MESSAGEONLOANSANCTION($application);
                break;
            /*case "disbursed":
                $message = Alerts::MESSAGEONLOANDISBURSAL($application);
                break;*/
            case "partially_disbursed":
                $message = Alerts::MESSAGEONPARTIALLOANDISBURSAL($application);
                break;
            case "completely_disbursed":
                $message = Alerts::MESSAGEONCOMPLETELOANDISBURSAL($application);
                break;
            default: $message = false;
                break;
        }

        if ($message) {
            SMSProvider::send($phone_number,$message);
        }
    }

    /**
     * Send Arogya Card for this application
     * @param  [int] $id [application id]
     * @return \Illuminate\Http\Response
     */
    public function sendArogyaCard($id)
    {   
        $application = Application::find($id);
        $barcode = new DNS1D();

        Mail::queue('emails.admin.send_arogya_card', ['application' => $application],
                function ($mail) use($application,$barcode)
                {                       
                    $barcode= $barcode->getBarcodeHTML($application->card_no, "C128",2,25);
                    $data = ['application'=>$application,'barcode'=>$barcode]; 
                    $pdf = PDF::loadView('admin.pages.application.sanction_letters.send_arogya_card',$data)->setPaper('a4');
                    $mail->to('manglesh.pal@arogyafinance.com', $application->borrower->first_name . ' ' . $application->borrower->last_name)
                         ->subject('Download Your Arogya Card')
                         ->attachData($pdf->output(),$application->pin_number.'_Arogya_Card.pdf');
                }); 

        Session::flash('info','Arogya Card Sent');
        
        return redirect()->back();       
    }

    /**
     * Download Arogya Card for this application
     * @param  [int] $id [applicaiton id]
     * @return \Illuminate\Http\Response
     */
    public function downloadArogyaCard($id)
    {   
        $application = Application::find($id);
        $barcode = collect([]);
        $data = ['application'=>$application,'barcode'=>$barcode];  
        $pdf = PDF::loadView('admin.pages.application.sanction_letters.send_arogya_card',$data)->setPaper('a4');
        
        return $pdf->download($application->pin_number.'_Arogya_Card.pdf');  
        return view('admin.pages.application.sanction_letters.send_arogya_card')->with($data);     
    }

    /**
     * Show Test Result for this application
     * @param  [int] $id [borrower id]
     * @return \Illuminate\Http\Response
     */
    public function showResult($id)
    {
        $title = "Test Result";        
        $borrower=Borrower::find($id);

        return view('admin.pages.application.test-result')->with(['borrower'=>$borrower]);
    }

    /**
     * Download This Application in PDF format 
     * @param  [int] $id [application id]
     * @return PDF File
     */
    public function downloadApplication($id)
    {
        $application = Application::find($id);
        $borrower = $application->borrower;
        $date = Carbon::now();
        $title = ' Applications';
        $data = ['date'=>$date, 'borrower'=>$borrower,'title'=>$title,'application'=>$application];
        $pdf = PDF::loadView('admin.pages.print', $data)->setPaper('a4');
        
        return $pdf->download('Application_'.$application->id.'.pdf');
    }

    public function closeApplication($id, Request $input)
    {
        //dd($input->all());
        $application = Application::find($id);
        $old_value = $application->status;
        $new_value = $application->status='closed';
        $application->update($input->all());
        $application->closer_date = Carbon::parse($input->closer_date)->format('Y-m-d');
        
        $application->save();
        Log::store($application->id,Auth::user()->id,'status',$old_value,$new_value);
        $od_report = OutstandingPrincipalReport::where('application_id',$application->id)->first();
        if($od_report) {
          OutstandingPrincipalReport::destroy($od_report->id);
        }
        Session::flash('info','Application closed');
        
        return redirect()->back(); 
    }

    public function sendNoDueCertificate($id)
    {
        $application = Application::find($id);
        $borrower = $application->borrower;
        $date = Carbon::now()->format('j F, Y');
        $approved_loan_amount=Terbilang::make($borrower->application->approved_loan_amount);          
        $approved_loan_emi=Terbilang::make($borrower->application->approved_loan_emi);
        $title = "No Dues Certificate";
        $data = ['date'=>$date, 'borrower'=>$borrower,
                 'approved_loan_amount'=>$approved_loan_amount,
                 'approved_loan_emi'=>$approved_loan_emi,
                 'title'=>$title
                ];
        $admins = $application->location->admins;
        //dd($admin);        
        $pdf = PDF::loadView('admin.pages.application.sanction_letters.no_dues_certificate', $data)->setPaper('a4');
        //return view('admin.pages.application.sanction_letters.no_dues_certificate')->with($data);  
        $send_to_fc = true;
        foreach ($admins as $admin) {
            Mail::send('emails.admin.send_no_dues_certificate', 
            ['application'=>$application, 'borrower'=>$borrower, 'admin'=>$admin, 'send_to_fc'=>$send_to_fc],
                function ($mail) use ($borrower, $application,$pdf, $admin,$send_to_fc)
                {
                    $mail->to($admin->email/*'prashant@awkword.in'*/, 'Arogya Finance')
                         ->subject($application->pin_number.'_No_Dues_Certificate')
                         ->attachData($pdf->output(),$application->pin_number.'_No_Dues_Certificate.pdf');     
                });
        }
        
        $send_to_fc = false;
        Mail::send('emails.admin.send_no_dues_certificate', 
            ['application'=>$application, 'borrower'=>$borrower, 'send_to_fc'=>$send_to_fc],
                function ($mail) use ($borrower, $application,$pdf, $admin,$send_to_fc)
                {
                    $mail->to($borrower->email/*'prashant@awkword.in'*/, 'Arogya Finance')
                         ->subject($application->pin_number.'_No_Dues_Certificate')
                         ->attachData($pdf->output(),$application->pin_number.'_No_Dues_Certificate.pdf');     
                });

        $application->ndc_sent=1;
        $application->save();

        Session::flash('info','NDC Sent');
        
        return redirect()->back();
    }

    /**
     * Generate Sanction Letter PDF
     */
    public function getSanctionedLetterPDF($application)
    {
        $borrower = $application->borrower;            
        $date = Carbon::now()->format('j F, Y');
        $approved_loan_amount=Terbilang::make($borrower->application->approved_loan_amount);          
        $approved_loan_emi=Terbilang::make($borrower->application->approved_loan_emi);
        $title = "Sanction Letter";
        $data = ['date'=>$date, 'borrower'=>$borrower,
                 'approved_loan_amount'=>$approved_loan_amount,
                 'approved_loan_emi'=>$approved_loan_emi,
                 'title'=>$title
                ];
        $pdf = PDF::loadView('admin.pages.application.sanction_letters.sanction_letter_'.$application->type, $data)->setPaper('a4'); 

        return $pdf;
    }

    /**
     * Generate First Letter PDF
     */
    public function getFirstLetterPDF($application)
    {
        $borrower = $application->borrower;
        $date = Carbon::now()->format('j F, Y');
        $approved_loan_amount=Terbilang::make($borrower->application->approved_loan_amount);
        $approved_loan_emi=Terbilang::make($borrower->application->approved_loan_emi);
        $title = "First Letter";
        $data = ['date'=>$date, 'borrower'=>$borrower,
                 'approved_loan_amount'=>$approved_loan_amount,
                 'approved_loan_emi'=>$approved_loan_emi,
                 'title'=>$title
                ];                
        $pdf = PDF::loadView('admin.pages.application.sanction_letters.first_letter', $data)->setPaper('a4');

        return $pdf;
    }

    /**
     * Send Sanction Letter Email to Arogya FC
     */
    public function sendSanctionLetterToFC($application,$pdf)
    {
        $admins = $application->location->admins;
        foreach ($admins as $admin) {
            try {
                Mail::send('emails.admin.send_sanction_letter', 
                ['admin'=>$admin,'application'=>$application], function ($mail) 
                use ($admin,$application,$pdf) {
                    $mail->to($admin->email, 'Arogya Finance')
                        ->subject($application->pin_number.'_Sanction_Letter')
                        ->attachData($pdf->output(),$application->pin_number.'_Sanction_Letter.pdf');
                });
            } catch (\Exception $e) {
                DataLog::useFiles(storage_path().'/logs/mail.log');
                DataLog::info('catch = '.$e->getMessage());
            }
        }        
    }

    /**
     * Send Sanction Letter Email to Hospital
     */
    public function sendSanctionLetterToHospital($application,$pdf)
    {
        $hospital_detail = Hospital::where('name',$application->hospital_name)
            ->where('email_notification',1)->first();
        if(isset($hospital_detail)) {
            $admin = $hospital_detail;
            try {
                Mail::send('emails.admin.send_sanction_letter_to_hospital_and_sistema', ['admin'=>$admin,'application'=>$application],
                    function ($mail) use ($admin,$application,$pdf)
                    {
                        $mail->to($admin->email, 'Arogya Finance')
                             ->subject('Sanction Letter for '.ucfirst($application->patient->first_name).' '.ucfirst($application->patient->last_name))
                             ->attachData($pdf->output(),$application->referrer_code.'_Sanction_Letter.pdf');
                });
            } catch (\Exception $e) {
                DataLog::useFiles(storage_path().'/logs/mail.log');
                DataLog::info('catch = '.$e->getMessage());
            }
        }
    }

    /**
     * Send Sanction Letter Email to Partner-Sistema
     */
    public function sendSanctionLetterToPartner($application,$pdf)
    {
        $hospital_detail = Hospital::where('name',$application->hospital_name)->first();
        if(isset($hospital_detail)) {
            if($hospital_detail->hospital_referrer!=null) {
                $partner = Admin::where('referrer_code',$hospital_detail->hospital_referrer)
                    ->where('email_notification',1)->first();
            }          
        } else {
            $partner = Admin::where('referrer_code',$application->partner_reference_code)
            ->where('email_notification',1)->first();
        }
        //dd($partner->applications->contains('id',$application->id));
        if(isset($partner)) {
            $partner_applications = $partner->applications;
            //dd($partner_applications->count()>0);
            if($partner_applications->count()>0) {
                if($partner_applications->contains('id',$application->id)) {
                    $admin = $partner;
                    try {
                        Mail::send('emails.admin.send_sanction_letter_to_hospital_and_sistema', ['admin'=>$admin,'application'=>$application], function ($mail) 
                            use ($admin,$application,$pdf) {
                            $mail->to($admin->email, 'Arogya Finance')
                                ->subject('Sanction Letter for '.ucfirst($application->patient->first_name).' '.ucfirst($application->patient->last_name))
                                ->attachData($pdf->output(),$application->referrer_code.'_Sanction_Letter.pdf');
                        });
                    } catch (\Exception $e) {
                        DataLog::useFiles(storage_path().'/logs/mail.log');
                        DataLog::info('catch = '.$e->getMessage());
                    }
                }
            }            
        }
    }

    /**
     * Send First Letter Email to Arogya FC
     */
    public function sendFirstLetterToFC($application,$pdf)
    {
        $admins = $application->location->admins;
        $mandate = true;
        foreach ($admins as $admin) {
            try {
                Mail::send('emails.admin.send_first_letter', ['application'=>$application,
                    'mandate'=>$mandate, 'admin'=>$admin], function ($mail) use ($admin, 
                        $application, $pdf) {
                        $mail->to($admin->email, 'Arogya Finance')
                            ->subject($application->pin_number.'_Welcome_Letter')
                            ->attachData($pdf->output(),$application->pin_number.'_Welcome_Letter.pdf');     
                });
            } catch (\Exception $e) {
                DataLog::useFiles(storage_path().'/logs/mail.log');
                DataLog::info('catch = '.$e->getMessage());
            }
        }       
    }

    /**
     * Get Disbursed Amount for this application
     */
    public function getDisbursedAmount($application)
    {
        $approved_loan_amount = $application->approved_loan_amount;
        $advance_emi_amount = $application->advance_emi*$application->approved_loan_emi;
        $subvention_amount = $approved_loan_amount*($application->subvention/100);
        $disbursed_amount = (($approved_loan_amount - $advance_emi_amount) - $subvention_amount);
        return $disbursed_amount;
    }

    /**
     * Send First Letter Email to Hospital
     */
    public function sendFirstLetterToHospital($application)
    {
        $disbursed_amount = $this->getDisbursedAmount($application);
        $hospital_detail = Hospital::where('name',$application->hospital_name)
            ->where('email_notification',1)->first();
        if(isset($hospital_detail)) {
            if($hospital_detail->hospital_referrer!=null) {
                $partner_detail = Admin::where('referrer_code',$hospital_detail->hospital_referrer)->first();
            } else {
                $partner_detail = null;
            }
            $this->sendFirsLetterMailToHospital($application,$hospital_detail,
                $partner_detail,$disbursed_amount);
            $this->sendFirsLetterMailToFC($application,$hospital_detail,
                $partner_detail,$disbursed_amount);      
        }
    }

    /**
     * Send First Letter Mail to Hospital
     */
    public function sendFirsLetterMailToHospital($application,$hospital_detail,
        $partner_detail,$disbursed_amount) {
        try {
            Mail::send('emails.admin.send_first_letter_to_hospital_and_sistema', 
                ['application'=>$application,'hospital_detail'=>$hospital_detail,
                 'partner_detail'=>$partner_detail,
                 'disbursed_amount'=>$disbursed_amount], function ($mail) 
                 use ($hospital_detail, $application) {
                    $mail->to($hospital_detail->email, 'Arogya Finance')
                        ->subject('Disbursement of Medical Loan for '.ucfirst($application->patient->first_name).' '.ucfirst($application->patient->last_name
                            )
                        );
            });
        } catch (\Exception $e) {
            DataLog::useFiles(storage_path().'/logs/mail.log');
            DataLog::info('catch = '.$e->getMessage());
        }
    }

    /**
     * Send First Letter Mail to FC
     */
    public function sendFirsLetterMailToFC($application,$hospital_detail,
        $partner_detail,$disbursed_amount) {
        $admins = $application->location->admins;

        foreach ($admins as $admin) {
            try {
                Mail::send('emails.admin.send_first_letter_to_hospital_and_sistema', 
                    ['application'=>$application,'hospital_detail'=>$hospital_detail,
                     'partner_detail'=>$partner_detail,
                     'disbursed_amount'=>$disbursed_amount], function ($mail) 
                    use ($hospital_detail, $application, $admin) {
                        $mail->to($admin->email, 'Arogya Finance')
                            ->subject('Disbursement of Medical Loan for '.ucfirst($application->patient->first_name).' '.ucfirst($application->patient->last_name
                                )
                            );
                });
            } catch (\Exception $e) {
                DataLog::useFiles(storage_path().'/logs/mail.log');
                DataLog::info('catch = '.$e->getMessage());
            }
        }
    }


    /**
     * Send First Letter Email to Hospital
     */
    public function sendFirstLetterToPartner($application)
    {
        $disbursed_amount = $this->getDisbursedAmount($application);
        $hospital_detail = Hospital::where('name',$application->hospital_name)->first();
        if(isset($hospital_detail)) {
            if($hospital_detail->hospital_referrer!=null) {
                $partner = Admin::where('referrer_code',$hospital_detail->hospital_referrer)
                    ->where('email_notification',1)->first();
            }          
        } else {
            $partner = Admin::where('referrer_code',$application->partner_reference_code)
            ->where('email_notification',1)->first();
        }
        if(isset($partner)) {
            $partner_applications = $partner->applications;
            if($partner_applications->count()>0) {
                if($partner_applications->contains('id',$application->id)) {
                    $partner_detail = $partner;
                    $hospital_detail = Hospital::where('name',$application->hospital_name)->first();
                    if(isset($hospital_detail)) {
                        $this->sendFirsLetterMailToPartner($application,$hospital_detail,
                            $partner_detail,$disbursed_amount);
                    }
                }
            }            
        }
    }

    /**
     * Send First Letter Mail to Sistema
     */
    public function sendFirsLetterMailToPartner($application,$hospital_detail,
        $partner_detail,$disbursed_amount) {
        try {
            Mail::send('emails.admin.send_first_letter_to_hospital_and_sistema', 
                ['application'=>$application,'hospital_detail'=>$hospital_detail,
                 'partner_detail'=>$partner_detail,
                 'disbursed_amount'=>$disbursed_amount], function ($mail) 
                 use ($hospital_detail, $application, $partner_detail) {
                    $mail->to($partner_detail->email, 'Arogya Finance')
                        ->subject('Disbursement of Medical Loan for '.ucfirst($application->patient->first_name).' '.ucfirst($application->patient->last_name
                            )
                        );
            });
        } catch (\Exception $e) {
            DataLog::useFiles(storage_path().'/logs/mail.log');
            DataLog::info('catch = '.$e->getMessage());
        }
    }

    /**
     * [revertApplicationStatus description]
     * @param  [integer]  $id    [Application]
     * @param  Request $input [status]
     * @return \Illuminate\Http\Response
     */
    public function revertApplicationStatus($id, Request $input)
    {
        $application = Application::find($id);
        $old_value = $application->status;
        $new_value = lcfirst($input->status);
        $application->status=$new_value;
        $application->advance_emi_deduct=0;
        $application->subvention_deduct=0;
        $application->document_processing_fee_deduct=0;
        $application->save();
        
        Log::store($application->id,Auth::user()->id,'status',$old_value,$new_value);
        Session::flash('info','Application Stage updated');

        return redirect()->back(); 
    }

    /**
     * store create application log ]
     * @param  [integer]  $id    [Application]
     * @param  Request $input [status]
     * @return \Illuminate\Http\Response
     */
    public function createApplicationLog($application, $old_status)
    {
        $new_status = $application->status;
        $admin_id = Auth::user()->id;
        $column_name = "status";
        
        Log::create(['application_id' => $application->id, 'admin_id' => $admin_id, 
            'field' => $column_name, 'old_value' => $old_status, 'new_value' => $new_status]);
    }

    /**
     * [Display a form to close multiple application]
     * @return \Illuminate\Http\Response
     */
    public function closeApplicationsInBulkForm()
    {
        $title = "Close Applications";
        return view('admin.pages.application.import',['title'=>$title]);
    }

    /**
     * [close Applications In Bulk]
     * @return \Illuminate\Http\Response
     */
    public function closeApplicationsInBulk(Request $input)
    {   ini_set('max_execution_time', 6000); 
        if ($input->hasFile('sample_file')) {
            $path = $input->file('sample_file')->getRealPath();
            $data = \Excel::load($path)->get();
            $pins = collect();
            if ($data->count()>0) {
                $sheets = $data->toArray();
                foreach ($sheets as $row) {
                    $application = Application::where('pin_number',$row['pin'])->where('type','loan')->first();
                    if ($application) {
                        $this->closeApplications($application, $row);
                    }
                }
            }
        }

        Session::flash('info','Application closed');
        return redirect()->back();
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
     * [Mark application as poonawalla and update the partner_reference_code as poonawalla]
     * @param  [int] id of application
     * @return \Illuminate\Http\Response
     */
    public function sendApplicationToPoonawala($id)
    {
        $application = Application::find($id);
        $old_value = $application->partner_reference_code;
        $application->partner_reference_code = 'poonawalla';
        $application->save();

        $new_value = 'poonawalla';

        Log::store($application->id,Auth::user()->id,'partner_reference_code',$old_value,$new_value);
    
        Session::flash('info','Sent to poonawalla');

        return redirect()->back();

    }
}
