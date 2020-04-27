<?php

namespace App\Traits\Application;
use Exception;
use Carbon\Carbon;
use App\AccountRepaymentSchedule;

trait RepaymentScheduleTrait {

    public function generateAccountRepaymentSchedules()
    {

        /**
        1.Truncate Existing A/c Repayment
        2. Truncate Existing Collection
        3.Enter Adv EMI
        4.Enter Repayment Schedule
        */
        $this->enterAdvanceEMI();
        $this->enterAccRepaymentSchedule();
    }


    /**
     * Delete the record of a/c repayment schedule
     */
    public function truncateACCRepaymentSchedule($type)
    {
        $this->accountRepaymentSchedule()->where('type',$type)->delete();
    }

    /**
     * Enter Advance EMI detail into A/c Repayment Schedule
     */
    public function enterAdvanceEMI()
    {
        $this->truncateACCRepaymentSchedule("advance_emi");
        if($this->advance_emi!=0) {
            $amount = $this->approved_loan_amount;
            $interest = $this->effective_interest_rate/100;
            /*if($interest>=0){
                $interest = $interest;
            } else {
                $interest = 0;
            }*/
            $advance_emi = collect();
            for ($i=0; $i < $this->advance_emi ; $i++) {
                $data =array();
                $emi = $this->advance_emi*$this->approved_loan_emi;
                $interest_rate = round(($amount*$interest)/12,2);
                if($interest_rate<10){
                    $interest_rate = 0;
                }
                $principal = $this->flat_interest_rate-$interest_rate;
                array_push($data, $this->flat_interest_rate);
                array_push($data, $interest_rate);
                array_push($data, $principal);
                $amount = $amount-$principal;
                array_push($data, $amount);
                $advance_emi->push($data);            
            }

            $data = ['application_id'=>$this->id,
                     'type'=>'advance_emi',
                     'emi_month'=>Carbon::parse($this->getOriginal('valid_from'))->format('Y-m-d'),
                     'emi'=>$advance_emi->sum(0),'interest'=>$advance_emi->sum(1), 
                     'principal'=>$advance_emi->sum(2),
                     'outstanding_principal'=>$this->approved_loan_amount-$advance_emi->sum(2),
                     'amount_received'=>$advance_emi->sum(0),
                     'emi_payment_date'=>Carbon::parse($this->getOriginal('valid_from'))->format('Y-m-d')
                    ];        
            AccountRepaymentSchedule::create($data);
            if($this->collections()->where('type','advance_emi')->count()) {
                $this->collections()->where('type','advance_emi')->delete();
            }
            $collection_data = array();
            $collection_data['application_id'] = $data['application_id'];
            $collection_data['emi_payment_date'] = $data['emi_month'];
            $collection_data['amount_received'] =$data['amount_received'];
            $collection_data['narration'] = 'Advance EMI Collected';
            $collection_data['type'] = 'advance_emi';
            $collection = $this->collections()->create($collection_data);           
        }    
    }

    /**
     * Generate the A/c Repayment Schedule for this application
     */
    public function enterAccRepaymentSchedule()
    {
        $this->truncateACCRepaymentSchedule("emi");

        $amount = $this->getOutstandingPrincipalAmount();

        for ($i=0; $i < $this->approved_loan_tenure-$this->advance_emi ; $i++) {
            $emi_month = Carbon::parse($this->getOriginal('valid_from'))
                ->addMonthNoOverflow($i)
                ->format('Y-m-d');
            $emi_amount = $this->flat_interest_rate;
            $type="emi";
            $this->saveRepaymentBreakDown($type,$emi_month,$emi_amount,$amount,0,null);

        }
       
    }

    /**
     * Get the EMI Breakdown for a particular month.
     */
    public function saveRepaymentBreakDown($type,$emi_month,$emi_amount,$amount,$collection_amount,$emi_payment_date)
    {
        $repayment= [];
        $repayment['application_id']=$this->id;
        $repayment['type']=$type;
        $repayment['emi_month']=$emi_month;
        $repayment['emi']=$emi_amount;
        $repayment['amount_received']=$collection_amount;
        $repayment['emi_payment_date']=$emi_payment_date;
        $month = Carbon::parse($emi_month)->addMonthNoOverflow(1);

        $interest_rate = $this->effective_interest_rate/100;
        $repayment['interest']= round(($this->getOutstandingPrincipalAmount($month)*$interest_rate)/12,2);
        if($repayment['interest']<10){
            $repayment['interest'] = 0;
        }
        // Calculating Principal Amount
        $repayment['principal']=($repayment['emi']-$repayment['interest']);
        
        if($type=="advance_emi") {
            $repayment['outstanding_principal']=($this->approved_loan_amount-$repayment['principal']);        
        } else {
            $repayment['outstanding_principal']=($this->getOutstandingPrincipalAmount($month)-$repayment['principal']);

        }
        $amount = $repayment['outstanding_principal']-$repayment['principal'];
        
        AccountRepaymentSchedule::create($repayment);
        
        return $amount;

    }

    /**
     * get the oustanding for a particular month
     */
    public function getOutstandingPrincipalAmount($month=null)
    {
        if(!$month) {
            $month = Carbon::now()->format('Y-m-d');
        }

        $repayments = $this->accountRepaymentSchedule()->whereDate('emi_month','<=',$month)->get()->last();
        
        if($repayments) {
            $outstanding_principal = $repayments->outstanding_principal;
            $principal_adjustments = $repayments->principal_adjustment_amount;
            $total_outstanding = ($outstanding_principal - $principal_adjustments);

        } else {
            $total_outstanding = $this->approved_loan_amount;
        }       

        return $total_outstanding;
    }

    /**
     * Update Repayment Schedule
     */
    public function updateRepaymentSchedule()
    {
        $interest_rate = $this->effective_interest_rate/100;
        $acc_repayments = $this->accountRepaymentSchedule()->get();
        foreach ($acc_repayments as $key=>$acc_repayment) {
            if($acc_repayment->type=="emi") {
                if($acc_repayments[$key]->outstanding_principal==$this->approved_loan_amount-$acc_repayment->principal) {
                    $amount = $this->approved_loan_amount;
                } else {
                    $amount = $acc_repayments[$key-1]->outstanding_principal;
                }
                $acc_repayment->interest = round((($amount)*$interest_rate)/12,2);
                $acc_repayment->principal = ($acc_repayment->emi-$acc_repayment->interest)+$acc_repayment->principal_adjustment_amount;
                $acc_repayment->outstanding_principal = $amount - $acc_repayment->principal;
            }
            
        $acc_repayment->save(); 
       }

    }
}
