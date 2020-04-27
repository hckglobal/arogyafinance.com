<?php

namespace App\Http\Controllers\Website\Application;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Input;
use App\Hospital;
use App\Application;
use Session;
use Redirect;
use App\Lead;
use App\Http\Controllers\Website\Application\PersonalDetailController;

class FinancialDetailController extends Controller
{
    /**
     * Show form for financial details
     * @return
     */
    public function showFinancialDetails($type, $id, Request $input)
    {
        $personal_detail_object = new PersonalDetailController();
        $locale = $personal_detail_object->checkLocal($input);
        app()->setLocale($locale);
        //check if lead is present
        $lead = '';
        if ($input->has('lead_id')) {
            $lead = Lead::find($input->get('lead_id'));
            $application = Application::find($id);
            if($lead->product_id!=''){
                $application->product_id=$lead->product_id;
            }

            if($lead->pin_number!=''){
                $application->pin_number=$lead->pin_number;
            }
            
            $application->save(); 
        }
        //dd($lead->application);
        $hospitals = Hospital::all()->pluck('name');
        
        return view('website.pages.application.financial_details')
                ->with(['type' => $type, 'hospitals' => $hospitals, 'id' => $id,'lead' => $lead, 'locale'=>$locale]);
    }

    /**
     * [postFinancialDetails description]
     * @param  [string]  $type  [type of application(loan/card)]
     * @param  Request $input [Array of form input fields]
     * @return [redirect route]         [redirects to documents uplaod page]
     */
    public function postFinancialDetails($type, $id, Request $input)
    {
        $personal_detail_object = new PersonalDetailController();
        $locale = $personal_detail_object->checkLocal($input);
        app()->setLocale($locale);
        $application = Application::find($id);
        Session::put('borrower_id',$application->borrower->id);
        // step-1 : update application
        $application->update($input->all());
        $this->updateApplicationStatus($application);
        
        // step-2 : update borrower information
        $this->updateBorrowerInfo($application,$input);
        
        // step-3 : save assets
        $this->saveAssets($application, $input);

        // step-4 : save financial details into application
        $application = $this->saveCalulations($application, $input);        

        $redirect_url = "/apply/$type/ask-documents-upload/$id?locale=$locale";

        return redirect($redirect_url);
    }

    /**
     * Update application status after filling the personal detail form 
     * @param  Request $application
     * @return App/Application
    */
    public function updateApplicationStatus($application)
    {     
         $id = $application->id;
         $application = Application::find($id);
         $application->update(Input::only(["loan_required","requested_emi","requested_tenure"]));
         $application->status = "new";
         $application->save();
         return $application;   
    }

    /**
     * Update Borrower Info 
     * @param  $application [description]
     * @param  $input       [description]
     * @return update borrower data
     */
    public function updateBorrowerInfo($application,$input)
    {
        $application->borrower()->update(Input::only(
            ["nature_of_income","borrowers_income","earning_since",
             "source_of_income","name_of_firm","income_itr",
             "other_earnings_type","other_earnings","number_of_dependants"
            ]));
    }

    /**
     * Save Assets 
     * @param  $application 
     * @param  $input 
     * @return App/Asset     
     */
    public function saveAssets($application, Request $input)
    {
        if ($input->has('assets')) {
            foreach ($input->get('assets') as $asset) {
                $application->assets()->create(['name' => $asset]);
            }
        }
    }

    /**
     * Save Calulations for this application
     * @param  [type]  $application [description]
     * @param  Request $input       [description]
     * @return [type]               [description]
     */
    public function saveCalulations($application, Request $input)
    {
        $estimatedCost = $application->estimated_cost;       
        $loanRequired = (int)$input->get('loan_required');
        $borrowersIncome = (int)$input->get('borrowers_income');
        $incomeItr = (int)$input->get('income_itr');
        $currentLoanEmi = (int)$input->get('current_loan_emi');
        $educationExpense = (int)$input->get('education_expenses');
        $houseRent = (int)$input->get('house_rent');
        $otherExpenses = (int)$input->get('other_expenses');
        $numberOfDependants = (int)$input->get('number_of_dependants');
        $otherEarnings = (int)$input->get('other_earnings');
        $monthlyEmiPossible = (int)$input->get('requested_emi');
        $requestedTenure = (int)$input->get('requested_tenure');

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
        // the emi which the user can pay to the loan provider with only 40% risk 15-02-19
        $calculatedMonthlyEmi = ($calculatedMonthlyIncome - $otherExpense) * 0.4;
        
        $treatment_types = collect(["Cardiology (Heart Valves/Surgery)","CRDM (Pace Makers)"]);

        if ($treatment_types->contains($application->treatment_type)) {
            $maxLoanEligible = ($calculatedMonthlyEmi * 36) / 1.2475;
        } else {
            //$maxLoanEligible = ($calculatedMonthlyEmi * 36) / 1.36;
            $maxLoanEligible = ($calculatedMonthlyEmi * 36) / 1.27; //15-02-19

        }

        // gives the min loan amount user can get.change
        if ($application->type=="loan" && !$treatment_types->contains($application->treatment_type)) {            
            //$loanNeededUser = $estimatedCost * 0.75;
            $loanNeededUser = $estimatedCost;    //15-02-19        
            //$approvedLoanAmount = min($loanNeededUser, $loanRequired, $maxLoanEligible,300000);
            $approvedLoanAmount = min($loanNeededUser, $loanRequired, $maxLoanEligible,500000); //15-02-19  
            // final emi given to the user to pay monthly        
            //$approvedLoanEmi = $approvedLoanAmount * (1 + (0.12 * ($requestedTenure / 12))) / $requestedTenure;
            $approvedLoanEmi = $approvedLoanAmount * (1 + (0.08 * ($requestedTenure / 12))) / $requestedTenure;
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
        return $application;
    }    
}
