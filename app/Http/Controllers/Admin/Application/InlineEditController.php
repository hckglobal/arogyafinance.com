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
use App\Collection;

class InlineEditController extends Controller
{
    /**
     * Update borrower detail
     * @param  [int]  $id    [applicaiton id]
     * @param  Request $input [form data]
     * @return \Illuminate\Http\Response
     */
    public function updateBorrower($id,Request $input) 
    {
        //get borrower
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
        $borrower->update([$column_name => $new_value]);
        //log application update
        Log::create(['application_id' => $borrower->application->id, 'admin_id' => $admin_id,
                     'field' => $field, 'old_value' => $old_value, 'new_value' => $new_value]);

        return redirect()->back();
    }

    /**
     * Update Family Detail
     * @param  [int]  $id    Application Id
     * @param  Request $input form data
     * @return \Illuminate\Http\Response
     */
    public function updateFamily($id,Request $input) {
        //get application
        $application = Application::find($id);
        // get colunn name
        $column_name = $input->get('name');
        // get column value
        $new_value = $input->get('value');
        // get admin id
        $admin_id = Auth::user()->id;
        // get old value 
        $old_value = $application->{$column_name};
        $field = 'application =>'.$column_name;
        $application->update([$column_name=>$new_value]);
        //log application update
        Log::create(['application_id' => $id, 'admin_id' => $admin_id, 'field' => $field, 
                     'old_value' => $old_value, 'new_value' => $new_value]);

        return redirect()->back();
    }

    /**
     * Update Patient Detail
     * @param  [int]  $id    Application Id
     * @param  Request $input form data
     * @return \Illuminate\Http\Response
     */
    public function updatePatient($id,Request $input) 
    {
        //get application
        $application = Application::find($id);
        // get colunn name
        $column_name = $input->get('name');
        // get column value
        $new_value = $input->get('value');
        // get admin id
        $admin_id = Auth::user()->id;
        // get old value 
        $old_value = $application->patient->{$column_name};
        $field = 'patient => '.$column_name;
        //update application 
        $application->patient()->update([$column_name=>$new_value]);
        //log application update
        Log::create(['application_id' => $id, 'admin_id' => $admin_id, 'field' => $field, 
                     'old_value'=>$old_value, 'new_value' => $new_value]);
        
        return redirect()->back();
    }

    /**
     * Update Repayment Cheque Detail
     * @param  [int]  $id    Repayment Id
     * @param  Request $input form data
     * @return \Illuminate\Http\Response
     */
    public function updateRepaymentCheque($id,Request $input) 
    {
        //get Repayment
        $repayment = RepaymentCheque::find($id);
        $application_id= $repayment->application->id;
        // get colunn name
        $column_name = $input->get('name');
        // get column value
        $new_value = $input->get('value');
        // get admin id
        $admin_id = Auth::user()->id;
        // get old value 
        $old_value = $repayment->{$column_name};
        $field = 'repaymentCheques => '.$column_name;
        //update application 
        $repayment->update([$column_name=>$new_value]);
        //log application update
        Log::create(['application_id' => $application_id, 'admin_id' => $admin_id, 'field' => $field, 
                     'old_value'=>$old_value, 'new_value' => $new_value]);
        
        return redirect()->back();
    }

    /**
     * Delete  Borrower Detail
     * @param  [int]  $id    Borrower Id
     * @return \Illuminate\Http\Response
     */
    public function deleteBorrower($id)
    {
        //get Repayment
        $borrower = Borrower::find($id);
        $application_id= $borrower->application->id;
        // get colunn name
        $column_name = "Borrower_Id = ".$id;
        // get column value
        $new_value = "Borrower_Id = ".$id." deleted";
        // get admin id
        $admin_id = Auth::user()->id;
        // get old value 
        $old_value = $id;
        $field = 'Borrower_Id';

        Borrower::destroy($id);
        //log application update
        Log::create(['application_id' => $application_id, 'admin_id' => $admin_id, 'field' => $field, 
                     'old_value'=>$old_value, 'new_value' => $new_value]);
        Session::flash('info','Borrower deleted');
        return redirect()->back();
    }    
}
