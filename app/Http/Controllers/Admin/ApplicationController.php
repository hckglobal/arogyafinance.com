<?php
namespace App\Http\Controllers\Admin;

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

class ApplicationController extends Controller
{

  public function downloadPDF($id)
  {
    $application = Application::find($id);

    $borrower = $application->borrower;

    $date = Carbon::now();
    $approved_loan_amount=Terbilang::make($borrower->application->approved_loan_amount);
      
    $approved_loan_emi=Terbilang::make($borrower->application->approved_loan_emi);
      
    $data = ['date'=>$date, 'borrower'=>$borrower,'approved_loan_amount'=>$approved_loan_amount,
                'approved_loan_emi'=>$approved_loan_emi];

    $type= $application->type;

    if ($type=="card") {
           $pdf = PDF::loadView('pages.sanction_letters.sanction_letter_card', $data)->setPaper('a4');
           return $pdf->download('card.pdf');
        } else {
            $pdf = PDF::loadView('pages.sanction_letters.sanction_letter_loan', $data)->setPaper('a4');
            return $pdf->download('loan.pdf');
        }

  }
    public function downloadCibil()
    {
      $html=file_get_contents();
      $pdf = PDF::loadHtmlFile('https://www.arogyafinance.com/documents/1143/cibil_report.html');

      return $pdf->download('cibil_report.pdf');
    }

    public function borrowerUpdate($id,Request $input) {
        //get application
        $borrower = Borrower::find($id);
        // get colunn name
        $column_name = $input->get('name');
        // get column value
        $new_value = $input->get('value');
        // get admin id
        $admin_id = Auth::user()->id;
        // get old value 
        $old_value = $borrower->{$column_name};

        $field = 'borrower =>'.$column_name;


        //update borrower 
        $borrower->update([$column_name=>$new_value]);
        //log application update
        Log::create(['application_id'=>$borrower->application->id,'admin_id'=>$admin_id,'field'=>$field,'old_value'=>$old_value,'new_value'=>$new_value]);


        return redirect()->back();

    }

    public function downloadMantriPDF($id)
    {
      $application = Application::find($id);

      $borrower = $application->borrower;

      $date = Carbon::now();

      $approved_loan_amount=Terbilang::make($borrower->application->approved_loan_amount);
      
      $approved_loan_emi=Terbilang::make($borrower->application->approved_loan_emi);

      $data = ['date'=>$date, 'borrower'=>$borrower,'approved_loan_amount'=>$approved_loan_amount,
                'approved_loan_emi'=>$approved_loan_emi];

      $type= $application->type;
      
      //return view ('pages.sanction_letters.mantri_sanction_letter_card')->with($data);
 
      if ($type=="card") {
             $pdf = PDF::loadView('pages.sanction_letters.mantri_sanction_letter_card', $data)->setPaper('a4');
             return $pdf->download('card.pdf');
          }
      else {
            $pdf = PDF::loadView('pages.sanction_letters.mantri_sanction_letter_card', $data)->setPaper('a4');
            return $pdf->download('loan.pdf');
        }
    }
}
