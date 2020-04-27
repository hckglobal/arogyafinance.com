<?php

namespace App\Http\Controllers\Admin\Application;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Application;
use PDF;
use App\Borrower;
use Terbilang;
use Mail;
use Session;
use Redirect;

class SanctionController extends Controller
{
    /**
     * Download MID for this application
     * @param  [int] $id [application id]
     * @return [PDF File]     
     */
    public function downloadMID($id)
    {   
        $application = Application::find($id);
        $borrower=$application->borrower;
        $age=Carbon::parse($application->patient->date_of_birth)->diffInYears(Carbon::now());

        if ($age < 18) {
            $minor=true;
        } else {
            $minor=false;
        }

        $date = Carbon::now()->format('j F, Y');
        $approved_loan_amount =Terbilang::make($borrower->application->approved_loan_amount);
        $approved_loan_emi =Terbilang::make($borrower->application->approved_loan_emi);
        $title = "Most Important Document";
        $data = ['date'=>$date,'application'=>$application,'borrower'=>$borrower,
                 'approved_loan_amount'=>$approved_loan_amount,'approved_loan_emi'=>$approved_loan_emi,
                 'minor'=>$minor,'title'=>$title
                ];

        $pdf =  PDF::loadView('admin.pages.application.sanction_letters.mid', $data)->setPaper('a4');
        return $pdf->download($application->pin_number.'_Most_Important_Document.pdf');
        return view ('admin.pages.application.sanction_letters.mid')->with($data);
    }

    /**
     * Download DPN for this application
     * @param  [int] $id [application id]
     * @return [PDF File]     
     */
    public function downloadDPN($id)
    {   
        $application = Application::find($id);
        $borrower=$application->borrower;
        $age=Carbon::parse($application->patient->date_of_birth)->diffInYears(Carbon::now());
        
        if ($age < 18) {
            $minor=true;
        } else {
            $minor=false;
        }

        $date = Carbon::now()->format('j F, Y');
        $approved_loan_amount =Terbilang::make($borrower->application->approved_loan_amount);
        $approved_loan_emi =Terbilang::make($borrower->application->approved_loan_emi);
        $title = "Demand Promissory Note";
        $data = ['date'=>$date,'application'=>$application,'borrower'=>$borrower,
                 'approved_loan_amount'=>$approved_loan_amount,'approved_loan_emi'=>$approved_loan_emi,
                 'minor'=>$minor,'title'=>$title
                ];

        $pdf =  PDF::loadView('admin.pages.application.sanction_letters.demand_promissory_note', $data)->setPaper('a4');

        return $pdf->download($application->pin_number.'_Demand_Promissory_Note.pdf');
        return view ('admin.pages.application.sanction_letters.demand_promissory_note')->with($data);
    }

    /**
     * Download Sanction Letter for this application
     * @param  [int] $id [application id]
     * @return [PDF File]     
     */
    public function downloadSanctionLetter($id)
    {
        $application = Application::find($id);
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

        $type= $application->type;

        if ($type=="card") {
            $pdf = PDF::loadView('admin.pages.application.sanction_letters.sanction_letter_card', $data)->setPaper('a4');
            
                return $pdf->download($application->pin_number.'_card.pdf');
                return view ('admin.pages.application.sanction_letters.sanction_letter_card')->with($data);
        } else {
            $pdf = PDF::loadView('admin.pages.application.sanction_letters.sanction_letter_loan', $data)->setPaper('a4');
            
            return $pdf->download($application->pin_number.'_loan.pdf');
            return view ('admin.pages.application.sanction_letters.sanction_letter_loan')->with($data);
        }
    }

    /**
     * Download Mantri for this application
     * @param  [int] $id [application id]
     * @return [PDF File]     
     */
    public function downloadMantri($id)
    {
        $application = Application::find($id);
        $borrower = $application->borrower;
        $date = Carbon::now()->format('j F, Y');
        $approved_loan_amount=Terbilang::make($borrower->application->approved_loan_amount);      
        $approved_loan_emi=Terbilang::make($borrower->application->approved_loan_emi);
        $title = "Sanction Letter";
        $data = ['date'=>$date, 'borrower'=>$borrower,'approved_loan_amount'=>$approved_loan_amount,
                'approved_loan_emi'=>$approved_loan_emi,'title'=>$title
                ];

        $type= $application->type;      
        
        if ($type=="card") {
            $pdf = PDF::loadView('admin.pages.application.sanction_letters.mantri_sanction_letter_card', $data)->setPaper('a4');
            
            return $pdf->download($application->pin_number.'_card.pdf');
        } else {
            $pdf = PDF::loadView('admin.pages.application.sanction_letters.mantri_sanction_letter_card', $data)->setPaper('a4');
            
            return $pdf->download($application->pin_number.'_loan.pdf');
        }
    }

    /**
     * Download LAC for this application
     * @param  [int] $id [application id]
     * @return [PDF File]     
     */
    public function downloadLAC($id)
    {   
        $borrower = Borrower::find($id);
        $date = Carbon::now()->format('j F, Y');
        $title = "Loan Against Card";
        $data = ['date'=>$date, 'borrower'=>$borrower,'title'=>$title];
        $pdf = PDF::loadView('admin.pages.application.sanction_letters.sanction_letter_loan_against_card', $data)->setPaper('a4');
        
        return $pdf->download($borrower->application->pin_number.'_loan.pdf');            
    }

    /**
     * Download Repayment Cheque for this application
     * @param  [int] $id [application id]
     * @return [PDF File]     
     */
    public function downloadRepaymentCheque($id)
    {
        $application = Application::find($id);      
        $borrower=$application->borrower;     
        $date = Carbon::now()->format('j F, Y');
        $approved_loan_amount =Terbilang::make($borrower->application->approved_loan_amount);        
        $approved_loan_emi =Terbilang::make($borrower->application->approved_loan_emi);
        $title = "Repayment Cheque";
        $data = ['date'=>$date,'application'=>$application,'borrower'=>$borrower,
               'approved_loan_amount'=>$approved_loan_amount,'approved_loan_emi'=>$approved_loan_emi,
               'title'=>$title
              ];
        
        $pdf =  PDF::loadView('admin.pages.application.sanction_letters.repayment_cheque', $data)->setPaper('a4');
        
        return $pdf->download($application->pin_number.'_Repayment_Cheque.pdf');
        return view ('admin.pages.application.sanction_letters.repayment_cheque')->with($data); 
    }

    /**
     * Download Medtronic for this application
     * @param  [int] $id [application id]
     * @return [PDF File]     
     */
    public function downloadMedtronic($id)
    {
        $application = Application::find($id);
        $borrower=$application->borrower;
        $date = Carbon::now()->format('j F, Y');
        $approved_loan_amount =Terbilang::make($borrower->application->approved_loan_amount);
        $approved_loan_emi =Terbilang::make($borrower->application->approved_loan_emi);
        $title = "Sanction Letter";
        $data = ['date'=>$date,'application'=>$application,'borrower'=>$borrower,
                 'approved_loan_amount'=>$approved_loan_amount,'approved_loan_emi'=>$approved_loan_emi,
                 'title'=>$title
                ];

        $pdf =  PDF::loadView('admin.pages.application.sanction_letters.sanction_letter_medtronic', $data)->setPaper('a4');
        
        return $pdf->download($application->pin_number.'_Medtronic_Letter.pdf');
        return view ('admin.pages.application.sanction_letters.sanction_letter_medtronic')->with($data);  
    }

    /**
     * Download ACH for this application
     * @param  [int] $id [application id]
     * @return [PDF File]     
     */
    public function downloadACH($id)
    {   
        $application = Application::find($id);
        $borrower=$application->borrower;
        $age=Carbon::parse($application->patient->date_of_birth)->diffInYears(Carbon::now());

        if ($age < 18) {
            $minor=true;
        } else {
            $minor=false;
        }

        $date = Carbon::now()->format('j F, Y');
        $approved_loan_amount =Terbilang::make($borrower->application->approved_loan_amount);
        $approved_loan_emi =Terbilang::make($borrower->application->approved_loan_emi);
        $title = "ACH";
        $data = ['date'=>$date,'application'=>$application,'borrower'=>$borrower,
                 'approved_loan_amount'=>$approved_loan_amount,'approved_loan_emi'=>$approved_loan_emi,
                 'minor'=>$minor,'title'=>$title
                ];

        $pdf =  PDF::loadView('admin.pages.application.sanction_letters.ach', $data)->setPaper('a4');
        return $pdf->download($application->pin_number.'_Most_Important_Document.pdf');
        return view ('admin.pages.application.sanction_letters.ach')->with($data);
    }

    public function downloadFirstLetter($id)
    {
        $application = Application::find($id);
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

        $type= $application->type;

        if ($type=="card") {
            $pdf = PDF::loadView('admin.pages.application.sanction_letters.first_letter', $data)->setPaper('a4');
            
                return $pdf->download($application->pin_number.'_card.pdf');
                return view ('admin.pages.application.sanction_letters.first_letter')->with($data);
        } else {
            $pdf = PDF::loadView('admin.pages.application.sanction_letters.first_letter', $data)->setPaper('a4');
            
            return $pdf->download($application->pin_number.'_loan.pdf');
            return view ('admin.pages.application.sanction_letters.first_letter')->with($data);
        }
    }        
}
