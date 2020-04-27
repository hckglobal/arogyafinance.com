<?php

namespace App\Http\Controllers\Admin\Application;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Application;
use Auth;
use Carbon\Carbon;
use App\Log;
use App\AccountRepaymentSchedule;
use Session;
use App\Traits\Application\RepaymentScheduleTrait;
use App\Http\Controllers\Admin\Application\CollectionController;

class AccountRepaymentController extends Controller
{
    use RepaymentScheduleTrait;
    /**
     * [Add Principal Adjustment To A/C Repayment table]
     */
    public function addPrincipalAdjustment(Request $input)
    {   //dd($input->all());
        $ac_repayment_schedule = AccountRepaymentSchedule::find($input->id);
        $application = $ac_repayment_schedule->application;        
        $principal_adjustment_amount = $input->principal_adjustment_amount;
        $ac_repayment_schedule->principal_adjustment_amount= $principal_adjustment_amount;
        $ac_repayment_schedule->save();

        // Create Log
        $admin_id = Auth::user()->id;
        
        $new_value = 'Added principal adjustment of '.$input->principal_adjustment_amount.' for EMI month '.$ac_repayment_schedule->emi_month;
        
        $old_value = $input->old_value;
        
        $field = 'principal adjustment->'.$ac_repayment_schedule->id;
        
        Log::create(['application_id' => $input->application_id, 
            'admin_id' => $admin_id, 'field' => $field, 'old_value' => $old_value,
            'new_value' => $new_value]);
        
        //Update A/c Repayment Schedule
        $application->updateRepaymentSchedule();

        Session::flash('info','Successfully');
        return redirect()->back();
    }

    public function regenerateAccountRepayment($id)
    {
        $admin_id = Auth::user()->id;
        $application = Application::find($id);
        if($application->accountRepaymentSchedule()->count()) {
            $application->accountRepaymentSchedule()->delete();
            if($application->collections()->where('type','advance_emi')->count()) {
                $application->collections()->where('type','advance_emi')->delete();
            }
            $application->generateAccountRepaymentSchedules();
            $collect_controller_obj = new CollectionController;
            $collect_controller_obj->updateAccountRepaymentCollectionDetail($application);
            Log::create(['application_id' => $application->id, 
            'admin_id' => $admin_id, 'field' => 'A/c Repayment Re-generated', 
            'old_value' => '', 'new_value' => '']);
        }
        Session::flash('info','Repayment Re-generated ');
        return redirect()->back();
    }

    public function addLegalCharges($id,Request $input)
    {
        $application = Application::find($id);
        $old_value = "Legal - ".$application->legal_charges." Waiver - ".$application->wavied_off;
        
        if(isset($input->legal_charges)) {
            $application->legal_charges=$input->legal_charges;
        }
        
        if(isset($input->wavied_off)) {
            $application->wavied_off=$input->wavied_off;
        }

        $application->save();
        $new_value = "Legal - ".$application->legal_charges." Waiver - ".$application->wavied_off;
        $admin_id = Auth::user()->id;

        Log::create(['application_id' => $application->id, 
            'admin_id' => $admin_id, 'field' => 'legal/waived-off charges', 
            'old_value' => $old_value, 'new_value' => $new_value]);

        Session::flash('info','Charges Updated');
        return redirect()->back();
    }

    public function getClosureStatus($id, Request $input, $export=null)
    {
        $application = Application::find($id);
        $admin = Auth::user();
        $role = $admin->roles()->first();
        $closure_date = $input->closure_date;
        if($closure_date==null) {
            $closure_date = Carbon::today()->format('d-m-Y');
        }
        //$overdue_month = Carbon::parse($closure_date)->format('Y-m');
        
        $first_repayment = $application->accountRepaymentSchedule->where('type', 'emi')->first();
        $last_repayment = $application->accountRepaymentSchedule->where('type', 'emi')->last();
        //dd(Carbon::parse($closure_date)->format('Y-m-d'),$first_repayment->emi_month,$last_repayment->emi_month);
        if ((Carbon::parse($closure_date)->format('Y-m-d') >= $first_repayment->emi_month) && (Carbon::parse($closure_date)->format('Y-m-d') <= $last_repayment->emi_month)){
            $overdue_month = Carbon::parse($closure_date)->format('Y-m');
        } elseif ((Carbon::parse($closure_date)->format('Y-m-d') < $first_repayment->emi_month)){
            $overdue_month = Carbon::parse($first_repayment->emi_month)->format('Y-m');
            $closure_date = $first_repayment->emi_month;
        } else {
            $overdue_month = Carbon::parse($last_repayment->emi_month)->format('Y-m');
            $closure_date = $last_repayment->emi_month;
        }
        //dd($overdue_month,$closure_date);
        //get principal outstanding for closure
        $closure_principal_os = $application->getClosurePrincipalOutstanding($overdue_month);
        //dd($closure_principal_os);
        //get overdue for closure
        $closure_overdue = $application->getClosureOverdue($overdue_month);
        //dd($closure_overdue);
        $overdue = $closure_overdue;
        $dpd = round(($closure_overdue/$application->approved_loan_emi),2);
        $outstanding = $closure_principal_os;

        $outstanding_principal = $outstanding->outstanding_principal;

        //get cheque bounce charges for closure
        $no_of_bounced_cheque = $application->getBouncedCheque($closure_date);
        $dishonor_charges = $no_of_bounced_cheque*500;

        //get cheque bounce charges for closure
        $late_payment_charges_data = $application->getClosureLatePaymentCharges($input->closure_date);
        $late_payment_charges = $late_payment_charges_data['late_payment_charges'];
        $total_delay_days = $late_payment_charges_data['total_delay_days'];
        //$outstanding_amount = $late_payment_charges_data['outstanding_amount'];
        $legal_charges = $application->legal_charges;
        if($closure_date) {
            $closure_month = Carbon::parse($closure_date)->format('Y-m-d');
        } else {
            $closure_month = Carbon::today()->format('Y-m-d');      
        }

        //get prepayment charges for closure
        $pre_payment_charges = $application->getPrepaymentCharges($closure_month);
        
        // get totao loan closure charges
        $total_charges = round(($outstanding_principal+$overdue+$pre_payment_charges+$dishonor_charges+$late_payment_charges+$legal_charges),2);

        //get loan closure waived off amount
        $wavied_off = $application->wavied_off;

        //get final loan closure amount
        $closure_amount = round((($outstanding_principal+$overdue+$pre_payment_charges+$dishonor_charges+$late_payment_charges+$legal_charges)-$wavied_off),2);

        //get max waiver amount
        $max_waiver = $this->getMaxWaiver($role,$application,$outstanding_principal,$overdue,$dishonor_charges,$late_payment_charges, $legal_charges, $pre_payment_charges, $total_charges);

        if(!$export){
            return view('admin.pages.application.closure_status')
                 ->with([
                    'application'=>$application,
                    'dpd' => $dpd,
                    'overdue' => $overdue,
                    'outstanding_principal' => $outstanding->outstanding_principal,
                    'no_of_bounced_cheque' => $no_of_bounced_cheque,
                    'dishonor_charges' => $dishonor_charges,
                    'total_delay_days' => $total_delay_days,
                    'late_payment_charges' => $late_payment_charges,
                    'legal_charges' => $legal_charges,
                    'pre_payment_charges' => $pre_payment_charges,
                    'total_charges' => $total_charges,
                    'wavied_off' => $wavied_off,
                    'closure_amount' => $closure_amount,
                    'closure_month' => $closure_month,
                    'input' => $input,
                    'max_waiver' => $max_waiver
                ]);
        } else {
            return [
                'outstanding_principal' => $outstanding->outstanding_principal,
                'overdue' => $overdue,
                'dishonor_charges' => $dishonor_charges,
                'late_payment_charges' => $late_payment_charges,
                'legal_charges' => $legal_charges,
                'pre_payment_charges' => $pre_payment_charges,
                'total_charges' => $total_charges,
            ];
        }
    }

    /**
     * get max waiver amount for loan closure
     *
     * @param Object Role $role
     * @param Object Application $application
     * @param Float ($outstanding_principal,$overdue,$dishonor_charges,$late_payment_charges, $legal_charges, 
     *       $pre_payment_charges, $total_charges)
     * @return Float
     */
    public function getMaxWaiver($role,$application,$outstanding_principal,$overdue,$dishonor_charges,$late_payment_charges, $legal_charges, $pre_payment_charges, $total_charges)
    {
        $waiver_amount = 0;
        $charges = $role->charges;
        if($charges) {
            if($charges->principal_os) {
                $waiver_amount += $this->getPercent($charges->principal_os,$outstanding_principal);
            }

            if($charges->overdue_emi) {
                $waiver_amount += $this->getPercent($charges->overdue_emi,$overdue);
            }

            if($charges->dishonor) {
                $waiver_amount += $this->getPercent($charges->dishonor,$dishonor_charges);
            }

            if($charges->late_payment) {
                $waiver_amount += $this->getPercent($charges->late_payment,$late_payment_charges);
            }

            if($charges->legal) {
                $waiver_amount += $this->getPercent($charges->legal,$legal_charges);
            }

            if($charges->pre_payment) {
                $waiver_amount += $this->getPercent($charges->pre_payment,$pre_payment_charges);
            }
        }

        return $waiver_amount;
    }

    /**
     * get percentage of a particalar charge
     *
     * @param Int $percent
     * @param Float $value
     * @return Float
     */
    public function getPercent($percent,$value)
    {
        return round($value*($percent/100), 2);
    }
}
