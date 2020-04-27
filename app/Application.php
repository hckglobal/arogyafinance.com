<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Traits\Application\RepaymentScheduleTrait;
use Storage;
use Log as DataLog;
use PHPHtmlParser\Dom;

class Application extends Model
{
    use RepaymentScheduleTrait;

    protected $fillable = 
        ['type','product_id','valid_from','valid_upto','location_id','cibil_score','hospital_name',
         'approved_hospital_name','other_expense','total_borrowers_income','calculated_income',
         'calculated_loan_amount','calculated_loan_emi','calculated_loan_tenure','approved_loan_amount',
         'approved_loan_emi','approved_loan_tenure','residence_proof','income_proof','treatment_type',
         'estimated_cost', 'loan_required','status','requested_tenure','requested_emi','interest_rate',
         'subvention','processing_fee','pin_number','reference_code','referrer_id',
         'referrer_company_id','rejection_reason_id','partner_reference_code','card_no',
         'rejection_note','documentation_charge','advance_emi','dmi_status','dmi_issue_date',
         'dmi_sent','disbursement_date','self_patient','merchant','mode_of_payment','foir',
         'bank_customer_name','bank_name','bank_account_number','lead_id','bank_account_type',
         'bank_ifsc_code','closer_reason_id','closer_note','closer_date','ndc_sent','admin_id',
         'advance_emi_deduct','subvention_deduct','document_processing_fee_deduct','legal_charges', 'wavied_off'
        ];
    //protected $dates =['valid_from','valid_upto'];
    protected $with =['patient','borrower'];
    protected $appends =['effective_interest_rate','psychometric_test_result'];

    /**
    * CIBIL score category one score
    */
    const CIBIL_SCORE_CAT_1 = 750;

    /**
    * CIBIL score category two score
    */
    const CIBIL_SCORE_CAT_2 = 700;

    /**
    * CIBIL score category three score
    */
    const CIBIL_SCORE_CAT_3 = 650;

    /**
    *  calculation of flat rate
    */
    const FINANCIAL_MAX_ITERATIONS = 128;

    /**
    * calculation of flat rate
    */
    const FINANCIAL_PRECISION = 1.0e-08;

    /**
      * Get loans form
      * @param   $query
      * @return Form
      */
    public function scopeLoan($query)
    {
        return $query->where('type', 'loan');
    }

    /**
      * Get card form
      * @param   $query
      * @return Form
      */
    public function scopeCard($query)
    {
        return $query->where('type', 'card');
    }

    /**
     * scope Category on3
     * @param   $query
     * @return Form
     */
    public function scopeCategoryOne($query)
    {
        return $query->where('cibil_score', '>=', self::CIBIL_SCORE_CAT_1);
    }

    /**
     * scope Category two
     * @param   $query
     * @return Form
     */
    public function scopeCategoryTwo($query)
    {
        return $query->where('cibil_score', '<=', self::CIBIL_SCORE_CAT_1-1)->where('cibil_score', '>=',  self::CIBIL_SCORE_CAT_2);
    }

    /**
     * scope Category three
     * @param   $query
     * @return Form
     */
    public function scopeCategoryThree($query)
    {
        return $query->where('cibil_score', '<=',   self::CIBIL_SCORE_CAT_2-1)->where('cibil_score', '>=', self::CIBIL_SCORE_CAT_3);
    }

    /**
     * scope Category four
     * @param   $query
     * @return Form
     */
    public function scopeCategoryFour($query)
    {
        return $query->WhereIn('cibil_score', [-1, 0]);
    }

    /**
     * scope Category none
     * @param   $query
     * @return Form
     */
    public function scopeCategoryNone($query)
    {
        return $query->where(function($query){
                    $query->whereBetween('cibil_score',[-100,-99])
                    ->orwhereBetween('cibil_score',[1,649]);
                });
    }

    public function scopeVerified($query)
    {
    	return $query->where('status','verified');
    }

    public function scopeNew($query)
    {
    	return $query->where('status','new');
    }

    public function scopeRejected($query)
    {
    	return $query->where('status','rejected');
    }

    public function scopeSanctioned($query)
    {
    	return $query->where('status','sanctioned');
    }

    public function scopeDisbursed($query)
    {
        return $query->where('status','disbursed');
    }

    public function scopeLead($query)
    {
        return $query->where('status','lead');
    }

    public function scopeClosed($query)
    {
        return $query->where('status','closed');
    }

   /**
     * Get the family members for the application
     */
    public function familyMembers()
    {
        return $this->hasMany('App\FamilyMember');
    }

    /**
     * Get the borrowers for the application
     */

    public function borrowers()
    {
    	return $this->hasmany('App\Borrower');
    }


    public function answers()
    {
      return $this->hasmany('App\Answer');
    }

    /**
     * psychometric test result for this application
    */
    public function psychometricTest()
    {
        return $this->hasmany('App\PsychometricTest');
    }

    /**
     * Get the patient for the application
     */

    public function patient()
    {
    	return $this->hasOne('App\Patient');
    }

    /**
     * Get the referrer for the Application
     */

    public function referrer()
    {
        return $this->belongsTo('App\Referrer');
    }

    /**
     * Get the notes for the application
     */

    public function notes()
    {
    	return $this->hasMany('App\Note')->where('type','internal');
    }

    /**
     * Get the notes for the application
     */

    public function partnerNotes()
    {
        return $this->hasMany('App\Note')->where('type','partner');
    }

    /**
     * Get the documents for the application
     */

    public function documents()
    {
    	return $this->hasMany('App\Document');
    }

    /**
     * Get the borrower for the application
     */
    public function borrower()
    {
        return $this->hasMany('App\Borrower')->where('type','primary');
    }

    /**
     * Get the coborrower for the application
     */
    public function coborrower()
    {
        return $this->hasMany('App\Borrower')->where('type','co-borrower');
    }

    /**
     * Get the guarantor for the application
     */
    public function guarantor()
    {
        return $this->hasMany('App\Borrower')->where('type','guarantor');
    }

    /**
     * Get the loans for the application
     */
    public function logs()
    {
        return $this->hasMany('App\Log');
    }

    public function transaction() {
        return $this->hasOne('App\Transaction');
    }

    public function getBorrowerAttribute()
    {
        return $this->borrower()->first();
    }

    public function arogyaCard()
    {
        return $this->belongsTo('App\Application','arogya_card_id');
    }
    public function rejectionReason()
    {
        return $this->belongsTo('App\RejectionReason');
    }
    public function closerReason()
    {
        return $this->belongsTo('App\CloserReason');
    }
    public function arogyaLoans()
    {
        return $this->hasMany('App\Application','arogya_card_id');
    }

    /**
     * Get the merchant name for the application
     */
    public function merchantName()
    {
        return $this->hasOne('App\Merchant');
    }

    /**
     * Get the merchant_documents for the application
     */
    public function merchantDocument()
    {
        return $this->hasOne('App\MerchantDocument');
    }

    /*
    * Get the admins for the form
    */
    public function admins()
    {
      //see if this city has admins
      $city = City::where('name',$this->city)->first();

      // see if we serve the city
      if($city!=null){
        //get the city admin
        $admins = City::where('name',$this->borrower->city)->first()->admins;
      }else{
        $admins = State::where('name',$this->borrower->state)->first()->admins;
      }

      return $admins;
    }


    /**
     * The assets of the form
     * @return
     */
     public function assets()
    {
        return $this->hasMany('App\Asset');
    }

    /**
     * Repayment schedules for this application.
     * @return
     */
     public function repaymentSchedules()
    {
        return $this->hasMany('App\RepaymentSchedule');
    }

    /**
     * Collections for this application.
     * @return
     */
     public function Collections()
    {
        return $this->hasMany('App\Collection');
    }


    /**
     * Mandate for this application.
     * @return
     */
     public function mandate()
    {
        return $this->hasOne('App\Mandate')->where('provider', 'digio');
    }

    /**
     * Ingenico mandate for this application.
     * @return
     */
     public function ingenicoMandate()
    {
        return $this->hasOne('App\Mandate')->where('provider', 'ingenico');
    }


    public function lead()
    {
        return $this->belongsTo('App\Lead','lead_id');
    }

    public function accountRepaymentSchedule()
    {
        return $this->hasMany('App\AccountRepaymentSchedule');
    }
    
    public function punchBy()
    {
        return $this->belongsTo('App\Admin','admin_id');
    }

    /**
     * Get the closure for the application
     */
    public function applicationClosure()
    {
        return $this->hasOne('App\ApplicationClosure');
    }

    /**
     * The category of the form
     * @return string category
     */
    public function category()
    {   
        $cibil = $this->cibil_score;

        if ($cibil>=self::CIBIL_SCORE_CAT_1) {
            return 'One';
        } elseif ($cibil<=self::CIBIL_SCORE_CAT_1 -1 && $cibil>= self::CIBIL_SCORE_CAT_2) {
            return 'Two';
        } elseif ($cibil<=self::CIBIL_SCORE_CAT_2 -1 && $cibil>= self::CIBIL_SCORE_CAT_3) {
            return 'Three';
        } elseif ($cibil==-1 || $cibil==0) {
            return 'Four';
        } else {
            return 'Uncategorized';
        }
    }

    /**
     * Check if psychometric test is require based on application category
     * @return string yes or no
     */
    public function requireTest()
    {   
        $category = $this->category();
        if ($category =='One' || $category =='Two') {
            return 'No';
        } else {
            return 'Yes';
        }
    }


    public function hasDocument($type)
        {
            if($this->documents()->where('type',$type)->count()>0){

                return true;

            }else{

                return false;
            }
        }


        public function remainingDocumentsCount()
        {
            $count = 0;
            if (!$this->hasDocument('id-proof')) $count++;
            
            if (!$this->hasDocument('address-proof')) $count++;
            
            if($this->category()=="Three" || $this->category()=="Four" || $this->category()=="Uncategorized"){
                if (!$this->hasDocument('bank-statement')) $count++;
                if (!$this->hasDocument('income-proof')) $count++;  
                if (!$this->hasDocument('residence-ownership-proof') && !(stripos($this->borrower->residence_type, 'owned')===false)) $count++;          
            }
            
            if (!$this->hasDocument('photo')) $count++;
            
            return $count;
        }

        public function getDocument($type)
        {
            return $this->documents()->where('type',$type)->first();
        }
        
        
        public function getFlatInterestRateAttribute(){

            $amount =$this->approved_loan_amount;
            $tenure_mnt =$this->approved_loan_tenure;
            $tenure_yr=$tenure_mnt/12;
            $percent_rate   =$this->interest_rate;
        	$rate=$percent_rate/100;

        	if($amount>0 && $tenure_yr>0){
			     $i = 
			    ($amount+$amount* $tenure_yr * $rate)/
			    ($tenure_yr*12);
                
			    return round($i,2) ;

		   } else {
		        return "Approved loan amount not entered, please enter it first";
	       }
        }


        public function getEffectiveInterestRateAttribute()
        {
            $amount =$this->approved_loan_amount;
            $tenure_mnt =$this->approved_loan_tenure;
            $tenure_yr=$tenure_mnt/12;
            $percent_rate =$this->interest_rate;
            $rate=$percent_rate/100;
            $emi_fir =$this->flat_interest_rate;
            if ($amount>0 && $tenure_yr>0) { 
                return round($this->RATE($tenure_yr*12,-$emi_fir,$amount)*1200, 5);
            } else{

               return "Approved loan amount not entered, please enter it first";  
            }
            
        }



    /**
     * Rate function
     * @param [type]  $nper  [description]
     * @param [type]  $pmt   [description]
     * @param [type]  $pv    [description]
     * @param float   $fv    [description]
     * @param integer $type  [description]
     * @param float   $guess [description]
     */
    function RATE($nper, $pmt, $pv, $fv = 0.0, $type = 0, $guess = 0.1) {

        $rate = $guess;
        if (abs($rate) < self::FINANCIAL_PRECISION) {
            $y = $pv * (1 + $nper * $rate) + $pmt * (1 + $rate * $type) * $nper + $fv;
        } else {
            $f = exp($nper * log(1 + $rate));
            $y = $pv * $f + $pmt * (1 / $rate + $type) * ($f - 1) + $fv;
        }
        $y0 = $pv + $pmt * $nper + $fv;
        $y1 = $pv * $f + $pmt * (1 / $rate + $type) * ($f - 1) + $fv;

        // find root by secant method
        $i  = $x0 = 0.0;
        $x1 = $rate;
        while ((abs($y0 - $y1) > self::FINANCIAL_PRECISION) && ($i < self::FINANCIAL_MAX_ITERATIONS)) {
            $rate = ($y1 * $x0 - $y0 * $x1) / ($y1 - $y0);
            $x0 = $x1;
            $x1 = $rate;

            if (abs($rate) < self::FINANCIAL_PRECISION) {
                $y = $pv * (1 + $nper * $rate) + $pmt * (1 + $rate * $type) * $nper + $fv;
            } else {
                $f = exp($nper * log(1 + $rate));
                $y = $pv * $f + $pmt * (1 / $rate + $type) * ($f - 1) + $fv;
            }

            $y0 = $y1;
            $y1 = $y;
            ++$i;
        }
        return $rate;
    }   //  function RATE()

     public function getEffectiveEmiAttribute()
     { 
        $flat_interest_rate=$this->interest_rate/1200;
         $tenure_mnt =$this->approved_loan_tenure;
         $amount = $this->approved_loan_amount;
         if ($amount>0 && $tenure_mnt>0 && $flat_interest_rate>0) {
             return $this->pmt($flat_interest_rate,$tenure_mnt,$amount);
         }
         
     }

     public function getProcessingFeeAmountAttribute()
     {
        $loan   =  $this->approved_loan_amount ? $this->approved_loan_amount : 0;
        $processing_fee = $this->processing_fee ? $this->processing_fee : 0;

        $amount = ($loan * ($processing_fee/100));

        $amount_with_gst = ($amount * 0.18) + $amount;

        $amount_with_gst = round($amount_with_gst);

        return $amount_with_gst;

     }

     public function getDocumentationChargeGstAttribute()
     {
        $amount   =  $this->documentation_charge ? $this->documentation_charge : 0;
        
        $amount_with_gst = ($amount * 0.18) + $amount;

        $amount_with_gst = round($amount_with_gst);

        return $amount_with_gst;

     }
    /**
     * PHP Version of PMT in Excel.
     *
     * @param float $flat_interest_rate
     *   Interest rate.
     * @param integer $tenure_mnt
     *   Loan length in months.
     * @param float $amount
     *   The loan amount.
     *
     * @return float
     *   The Effective EMI.
     */
    function pmt($flat_interest_rate, $tenure_mnt, $amount) {
      $effective_amount = $flat_interest_rate * -$amount * pow((1 + $flat_interest_rate), $tenure_mnt) / (1 - pow((1 + $flat_interest_rate), $tenure_mnt));
      return round($effective_amount);
    }

    public function getLastUpdateAttribute()
    {
        
        $application_timestamp=$this->getOriginal('updated_at');
        if ($this->borrower) {
            $borrower_timestamp=$this->borrower->getOriginal('updated_at');
        } else {
            $borrower_timestamp="";
        }
        
        
        if($this->type=="loan" && $this->patient)
        {
        $patient_timestamp=$this->patient->getOriginal('updated_at');
        $latest_timestamp=max($application_timestamp,$borrower_timestamp,$patient_timestamp);
        $latest_timestamp=Carbon::parse($latest_timestamp)->format('j F, Y');
        return $latest_timestamp;
        }
        else
        {

            $latest_timestamp=max($application_timestamp,$borrower_timestamp);
            $latest_timestamp=Carbon::parse($latest_timestamp)->format('j F, Y');
            return $latest_timestamp;
        }
      
    }

    public function product() {
            return $this->belongsTo('App\Product','product_id');
    }
    public function references() {
        return $this->hasMany('App\Reference');
    }
        
    public function getSanctionDateAttribute()
    {
        $date=$this->logs()->where('new_value','sanctioned')->latest()->first();
        if($date){
            
            return $date->created_at;
        }else{
            $date = Carbon::now()->format('j F, Y');
            return $date;
        }
        
      
    }

    /**
     * check if application has repayment cheque and bank detail
     */
    public function checkDisbursable()
    {
        $application = Application::find($this->id);
        if(!$application->repaymentCheques->isEmpty()){
            if($application->bank_name!='' && $application->bank_customer_name!='' && $application->bank_account_number!='' && $application->bank_account_type!='' && $application->bank_ifsc_code!='' && $application->mode_of_payment!=''){
                return true;
            } else {
                return false;
            }   
        } else {
            return false;
        }
    }    

    public function location()
    {
        return $this->belongsTo('App\Location');
    }

    public function repaymentCheques() {
        return $this->hasMany('App\RepaymentCheque');
    }
    
    
    
    public function getValidFromAttribute($value)
    {
        $date = Carbon::parse($value);
        return $date->format('j F, Y');
    }
    public function getValidUptoAttribute($value)
    {
        $date = Carbon::parse($value);
        return $date->format('j F, Y');
    }

    public function setValidFromAttribute($value)
    {
       $this->attributes['valid_from']=Carbon::parse($value)->format('Y-m-d');
    }
    public function setValidUptoAttribute($value)
    {
        $this->attributes['valid_upto']=Carbon::parse($value)->format('Y-m-d');
    }
	
    public function getCreatedAtAttribute($value)
    {
        $date = Carbon::parse($value);
        return $date->format('j F, Y h:i A');
    }

    public function getUpdatedAtAttribute($value)
    {
        $date = Carbon::parse($value);
        return $date->format('j F, Y h:i A');
    }

    public function idealRepaymentSchedule($value=null)
    {
        $application = $this;
        //dd($application); 
        $today_month = Carbon::now()->format('Y-m');
        $emi_date = $application->valid_from;
        $tenure = $application->approved_loan_tenure;
        $current_outstanding_principal = collect();
        $interest = $application->effective_interest_rate/100;
        $emi = $application->flat_interest_rate;
        $ideal_repayment_schedule = collect();
        if($application->advance_emi!=0){
            $advance_emis = $this->getAdvanceEMI($application,$application->approved_loan_amount,$emi,$interest);
            $ideal_repayment_schedule->push($advance_emis);
            //dd($advance_emis['principal']);
            $amount =$application->approved_loan_amount-$advance_emis['principal'];
        } else {
            $amount =$application->approved_loan_amount;
        }
        //$schedule = collect();        
        for ($i=0; $i < $application->approved_loan_tenure-$application->advance_emi ; $i++) {
            $data=array();
            $emi_date = Carbon::parse($application->getOriginal('valid_from'))->addMonthNoOverflow($i);
            $emi_month = $emi_date->format('Y-m');
            $interest_rate = round(($amount*$interest)/12,2);
            $principal = $application->flat_interest_rate-$interest_rate;
            $data['application_id'] = $application->id;
            $data['month_at'] = $i;
            $data['type'] = 'EMI';
            if ($value) {
                $data['emi_month'] = $emi_date->format('d-m-Y');
            } else {
                $data['emi_month'] = $emi_date->format('Y-m');
            }
            
            $data['emi'] = $application->flat_interest_rate;
            $data['interest'] = $interest_rate;
            $data['principal'] = $principal;
            $amount = $amount-$principal;
            /*if ($amount<0) {
                //dd(number_format($amount),$amount);
                //dd(round(-2.54874,2));
                $data['outstanding_principal'] = 0;
            } else {*/
                $data['outstanding_principal'] = round($amount,2);
            /*}*/
            $ideal_repayment_schedule->push($data);
        }
        return $ideal_repayment_schedule;
        
    }

    public function getAdvanceEMI($application,$amount,$emi,$interest)
    {   
        $advance_emi = collect();

        for ($i=0; $i < $application->advance_emi ; $i++) {
            $data=array();
            $emi = $application->advance_emi*$application->approved_loan_emi;
            $interest_rate = round(($amount*$interest)/12,2);
            $principal = $application->flat_interest_rate-$interest_rate;
            $data =array();
            array_push($data, '');
            array_push($data, $application->flat_interest_rate);
            array_push($data, $interest_rate);
            array_push($data, $principal);
            $amount = $amount-$principal;

            array_push($data, $amount);
            $advance_emi->push($data);            
        }

        $data = ['application_id'=>$application->id,
                 'type'=>'advance_emi',
                 'emi_month'=>Carbon::parse($application->getOriginal('valid_from'))->format('Y-m-d'),
                 'emi'=>$advance_emi->sum(1),'interest'=>$advance_emi->sum(2), 
                 'principal'=>$advance_emi->sum(3),
                 'outstanding_principal'=>$application->approved_loan_amount-$advance_emi->sum(3),
                 'amount_received'=>$advance_emi->sum(1),
                 'emi_payment_date'=>Carbon::parse($application->getOriginal('valid_from'))->format('Y-m-d')
                ];        
        return $data;
    }

    public function principalIdealRepaymentSchedule()
    {
        $application = $this;
        $principal_adjustments = $application->collections->where('principal_adjustment',1)->groupBy(function($d) {
                                    return Carbon::parse($d->emi_payment_date)->format('Y-m');
                                });
        //dd($principal_adjustments);
        if (!$principal_adjustments->isEmpty()) {
            foreach ($principal_adjustments as $principal_key => $principal_value) {
                $today_month = Carbon::now()->format('Y-m');
                $emi_date = $application->valid_from;
                $tenure = $application->approved_loan_tenure;
                $current_outstanding_principal = collect();
                $interest = $application->effective_interest_rate/100;
                $emi = $application->flat_interest_rate;
                $ideal_repayment_schedule = collect();
                if($application->advance_emi!=0){
                    $advance_emis = $application->getAdvanceEMI($application,$application->approved_loan_amount,$emi,$interest);
                    $ideal_repayment_schedule->push($advance_emis);
                    //dd($advance_emis['principal']);
                    $amount =$application->approved_loan_amount-$advance_emis['principal'];
                } else {
                    $amount =$application->approved_loan_amount;
                }
                for ($i=0; $i < $application->approved_loan_tenure-$application->advance_emi ; $i++) {
                    $data=array();
                    $emi_date = Carbon::parse($application->getOriginal('valid_from'))->addMonthNoOverflow($i);
                    $emi_month = $emi_date->format('Y-m');
                    $interest_rate = round(($amount*$interest)/12,2);
                    $principal = $application->flat_interest_rate-$interest_rate;
                    $data['application_id'] = $application->id;
                    $data['month_at'] = $i;
                    $data['type'] = 'EMI';
                    $data['emi_month'] = $emi_date->format('Y-m');
                    $data['emi'] = $application->flat_interest_rate;
                    $data['interest'] = $interest_rate;
                    if($emi_date->format('Y-m')==$principal_key) {
                        $data['principal'] = $principal+$principal_value->sum('amount_received');
                    } else {
                        $data['principal'] = $principal;
                    }

                    if($emi_date->format('Y-m')==$principal_key) {
                        $amount = ($amount-$principal)-$principal_value->sum('amount_received');
                    } else {
                        $amount = $amount-$principal;
                    }
                    
                    /*if ($amount<1) {
                        $data['outstanding_principal'] = 0;
                    } else {*/
                        $data['outstanding_principal'] = round($amount,2);
                    /*}*/
                    $ideal_repayment_schedule->push($data);
                    if($amount<0){
                        break;
                    }
                }
                $ideal_repayment_schedules = $ideal_repayment_schedule;
                return $ideal_repayment_schedules;
            }
        } else {
            return $application->idealRepaymentSchedule();
            //dd($ideal_repayment_schedules);
        }
    //return $ideal_repayment_schedule;
    }

    /** Get the psychometric test result for this application*/
    public function getPsychometricTestResultAttribute()
    {
        $application = Application::find($this->id);
        if(!$application->psychometricTest->isEmpty()){
            if($application->psychometricTest()->where('test_url','!=','')->count()>0){
                $psychometric_test_result = $application->psychometricTest()->where('test_url','!=','')->latest()->first()->result;
                
            } else {
                $psychometric_test_result = "Pending";
            }   
        } else {
                $psychometric_test_result = "Pending";
        } 

        return $psychometric_test_result;        
    }

    

    public function getAccRepaymentPrincipalAdjustment()
    {
        $application = $this;
        //dd($application->accountRepaymentSchedule);
        foreach ($application->accountRepaymentSchedule as $principal_adjustment) {
            $today_month = Carbon::now()->format('Y-m');
            $emi_date = $application->valid_from;
            $tenure = $application->approved_loan_tenure;
            $current_outstanding_principal = collect();
            $interest = $application->effective_interest_rate/100;
            $emi = $application->flat_interest_rate;
            $ac_repayment_schedules = collect();
            if($application->advance_emi!=0){
                $advance_emi = $application->getAdvanceEMI($application,$application->approved_loan_amount,$emi,$interest);
                $ac_repayment_schedules->push($advance_emi);
                //dd($advance_emi['principal']);
                $amount =$application->approved_loan_amount-$advance_emi['principal'];
            } else {
                $amount =$application->approved_loan_amount;
            }
            for ($i=0; $i < $application->approved_loan_tenure-$application->advance_emi ; $i++) {
                $data=array();
                $emi_date = Carbon::parse($application->getOriginal('valid_from'))->addMonthNoOverflow($i);
                $emi_month = $emi_date->format('Y-m');
                $interest_rate = round(($amount*$interest)/12,2);
                $principal = $application->flat_interest_rate-$interest_rate;
                $data['application_id'] = $application->id;
                $data['type'] = 'emi';
                $data['emi_month'] = $emi_date->format('Y-m-d');
                $data['emi'] = $application->flat_interest_rate;
                $data['interest'] = $interest_rate;
                if($emi_date->format('Y-m')==Carbon::parse($principal_adjustment->emi_month)->format('Y-m')) {
                    //dd('yes');
                    $data['principal'] = $principal+$principal_adjustment->principal_adjustment_amount;
                } else {
                    $data['principal'] = $principal;
                }

                if($emi_date->format('Y-m')==Carbon::parse($principal_adjustment->emi_month)->format('Y-m')) {
                    $amount = ($amount-$principal)-$principal_adjustment->principal_adjustment_amount;
                    $data['principal_adjustment_amount'] = $principal_adjustment->principal_adjustment_amount;
                } else {
                    $data['principal_adjustment_amount'] = null;
                    $amount = $amount-$principal;
                }
                
                /*if ($amount<1) {
                    $data['outstanding_principal'] = 0;
                } else {*/
                    $data['outstanding_principal'] = round($amount,2);
                /*}*/
                $data['amount_received'] = $principal_adjustment->amount_received;
                $data['emi_payment_date'] =$principal_adjustment->emi_payment_date;
                
                $ac_repayment_schedules->push($data);
                if($amount<0){
                    break;
                }
            }
            //dd($ac_repayment_schedules);
            return $ac_repayment_schedules;
        }
    }

    /**
     * Get Disbursed Amount for this application
     */
    public function getDisbursedAmount()
    {
        $disbursed_amount = $this->approved_loan_amount;
        
        if($this->advance_emi_deduct) {
            $advance_emi_amount = $this->advance_emi*$this->approved_loan_emi;
            $disbursed_amount -= $advance_emi_amount;
        }
        
        if($this->subvention_deduct) {
            $subvention_amount = $this->approved_loan_amount*($this->subvention/100);
            $disbursed_amount -= $subvention_amount;
        } 

        if($this->document_processing_fee_deduct) {
            $processing_fee = $this->processing_fee_amount;
            $documentation_fee = $this->documentation_charge_gst;
            $total_charges = $processing_fee+$documentation_fee;
            $disbursed_amount -= $total_charges;
        }
        
        return $disbursed_amount;
    }

    public function getOldDocuments()
    {
        $pin_number = $this->pin_number;
        $files = collect();
        if($pin_number) {
            //1. from pin number go to s3 folder
            $s3_folder = Storage::disk('arogyas3')->exists('backup/documents/'.$pin_number);
            //check if folder with pin number exists
            if ($s3_folder) {
            //2. loop all files from the folder
                $s3_files = Storage::disk('arogyas3')->allFiles('backup/documents/'.$pin_number);
                // add file names to array.
                $files->push($s3_files);             
            }
        }

        return $files->toArray();
    } 


    /**
     * Get Numbers of bocued cheque
     */
    public function getBouncedCheque($overdue_month)
    {
        if($this->collections) {
            $bounced_cheque = $this->collections()
                ->bounce()
                //->where('amount_received','<=',0)
                ->where('emi_payment_date','<=',Carbon::parse($overdue_month)->format('Y-m-d'))
                ->count();
        } else {
            $bounced_cheque = 0;
        }
        
        return $bounced_cheque;
    }

    /**
     * Get current month outstanding principal amout.
     */
    public function getCurrentOutstandingPrincipal()
    {
        $current_acc_repayment = $this->accountRepaymentSchedule()->where('emi_month','like',Carbon::today()->format('Y-m').'%')->first();
        if($current_acc_repayment) {
            $outstanding_principal = $current_acc_repayment->outstanding_principal;
        } else {
            $outstanding_principal = false;            
        }

        return $outstanding_principal;
    }

    /**
     * Get overdue and dpd for the given month.
     */
    public function getOverdueAndDPD($overdue_month)
    {
        $first_emi = $this->accountRepaymentSchedule()->first();
        $last_emi = $this->accountRepaymentSchedule->last();
        $current_emi = $this->accountRepaymentSchedule()
            ->where('emi_month','like','%'.$overdue_month.'%')
            ->first();

        if($current_emi) {
            $outstanding = $this->accountRepaymentSchedule()->where('emi_month',$current_emi->emi_month)->first();
          $repayment_months = $this->accountRepaymentSchedule()->whereDate('emi_month','<=',$current_emi->emi_month);
            $current_repayment_months = $this->accountRepaymentSchedule()
                ->where('emi_month',$current_emi->emi_month)->first();
          $positive_outstanding = $this->accountRepaymentSchedule()->whereDate('emi_month','<=',$current_emi->emi_month)->where('outstanding_principal','>=',0);
          $negative_outstanding = $this->accountRepaymentSchedule()->whereDate('emi_month','<=',$current_emi->emi_month)->where('outstanding_principal','<',0)->first();
          if($positive_outstanding) {
              $current_date = Carbon::now()->endOfMonth()->format('Y-m-d');
              if($negative_outstanding) {
                $collection_tobe_done = $positive_outstanding->sum('emi')+$negative_outstanding->emi;
              } else {
                $collection_tobe_done = $positive_outstanding->sum('emi');
              }
              
              $principal_adjustment = $this->accountRepaymentSchedule()->whereDate('emi_month','<=',$current_emi->emi_month)->sum('principal_adjustment_amount');
              $collected_amount = $this->collections()->accountCollection()->where('emi_payment_date','<=',$current_date)->get()->sum('amount_received');
              $total_collection = $collected_amount+$principal_adjustment;
              $overdues = round(($collection_tobe_done-$total_collection));
              $dpd = round(($overdues/$this->approved_loan_emi),2);
          } else {
            $current_date = Carbon::now()->endOfMonth()->format('Y-m-d');
              $collection_tobe_done = $repayment_months->sum('emi');
              $collected_amount = $this->collections()->accountCollection()->where('emi_payment_date','<=',$current_date)->get()->sum('amount_received');
              $overdues = round(($collection_tobe_done-$collected_amount));
              $dpd = round(($overdues/$this->approved_loan_emi),2);
          }
        } else {
            $current_date = Carbon::now()->endOfMonth()->format('Y-m-d');
            if($current_date<$first_emi->emi_month){
              $repayment_months = $repayment_months=collect();
              $current_repayment_months = null;
              $overdues =0;
              $dpd = 0;
              $collected_amount = 0;
            } else {
                $outstanding = $this->accountRepaymentSchedule()->whereDate('emi_month','<=',$last_emi->emi_month)->where('outstanding_principal','<=',0)->first();
              $repayment_months = $this->accountRepaymentSchedule()->whereDate('emi_month','<=',$last_emi->emi_month);
              $current_repayment_months = $this->accountRepaymentSchedule()->where('emi_month',$last_emi->emi_month)->first();
              $positive_outstanding = $this->accountRepaymentSchedule()->whereDate('emi_month','<=',$last_emi->emi_month)->where('outstanding_principal','>=',0);
              $negative_outstanding = $this->accountRepaymentSchedule()->whereDate('emi_month','<=',$last_emi->emi_month)->where('outstanding_principal','<',0)->first();

              if($positive_outstanding) {
                  $current_date = Carbon::now()->endOfMonth()->format('Y-m-d');
                  if($negative_outstanding) {
                    $collection_tobe_done = $positive_outstanding->sum('emi')+$negative_outstanding->emi;
                  } else {
                    $collection_tobe_done = $positive_outstanding->sum('emi');
                  }
                  
                  $principal_adjustment = $this->accountRepaymentSchedule()->whereDate('emi_month','<=',$last_emi->emi_month)->get()->sum('principal_adjustment_amount');
                  $collected_amount = $this->collections()->accountCollection()->where('emi_payment_date','<=',$current_date)->get()->sum('amount_received')+$principal_adjustment;

                  $overdues = round(($collection_tobe_done-$collected_amount));
                  $dpd = round(($overdues/$this->approved_loan_emi),2);
              } else {
                $current_date = Carbon::now()->endOfMonth()->format('Y-m-d');
                  $collection_tobe_done = $this->accountRepaymentSchedule()->whereDate('emi_month','<=',$last_emi->emi_month)->sum('emi');
                  $collected_amount = $this->collections()->accountCollection()->where('emi_payment_date','<=',$current_date)->get()->sum('amount_received');
                  $overdues = round(($collection_tobe_done-$collected_amount));
                  $dpd = round(($overdues/$this->approved_loan_emi),2);
              }
            }        
        }

        return ['dpd'=>$dpd,'overdues'=>$overdues,'outstanding'=>$outstanding];
    }

    public function getLatePaymentCharges()
    {        

        $current_month_acc_repayment = $this->accountRepaymentSchedule()->where('type','emi')->where('emi_month','like',Carbon::today()->format('Y-m').'%')->first();
        
        if($current_month_acc_repayment) {
            $current_acc_repayment = $current_month_acc_repayment;
        } else {
            $current_acc_repayment = $this->accountRepaymentSchedule->where('type','emi')->last();
        }

        $total_late_payment_charges = 0;
        $total_delay_days = 0;
        $repayment_months = $this->accountRepaymentSchedule()->where('type','emi')->get();
        
        foreach ($repayment_months as $accountRepaymentSchedule) {            
            $late_payment_charges = $accountRepaymentSchedule->getDelayDays();
            $total_late_payment_charges+=$late_payment_charges['late_payment_charges'];
            $total_delay_days+=$late_payment_charges['delay_days'];
        }

        return [
            'total_delay_days'=>$total_delay_days,
            'late_payment_charges'=>$total_late_payment_charges,
        ];
    }

    public function getPrepaymentCharges($closure_month)
    {
        $closing_outstanding = $this->accountRepaymentSchedule()
            ->where('emi_month','like',Carbon::parse($closure_month)->format('Y-m').'%')
            ->first();
        if(!$closing_outstanding) {
            $first_repayment = $this->accountRepaymentSchedule->first();
            $last_repayment = $this->accountRepaymentSchedule->last();
            if(Carbon::parse($closure_month)->format('Y-m')<=$first_repayment->emi_month) {
                $closing_outstanding = $first_repayment;
            } else {
                $closing_outstanding = $last_repayment;
            }
        }

        $pre_payment_repayment = $this->accountRepaymentSchedule()->whereDate('emi_month','<=',$closing_outstanding->emi_month)->count();

        switch ($pre_payment_repayment) {
            case $pre_payment_repayment<=6:
                $percent_rate = 0.04; //4% closure rate within 6months
                break;
            case $pre_payment_repayment>=7 && $pre_payment_repayment<=12:
                $percent_rate = 0.03; //3% closure rate within 7 to 12 months
                break;
            case $pre_payment_repayment>12:
                $percent_rate = 0.02; //2% closure rate more than 12 months
                break;

            default:
                $percent_rate = 0;
                break;
        }
        
        return round(($percent_rate*$closing_outstanding->outstanding_principal),2);
    }

    public function getClosurePrincipalOutstanding($closure_month)
    {
        $closing_outstanding = $this->accountRepaymentSchedule()
            ->where('type','emi')
            ->where('emi_month','like',Carbon::parse($closure_month)->format('Y-m').'%')
            ->first();
        if(!$closing_outstanding) {
            $first_repayment = $this->accountRepaymentSchedule->where('type','emi')->first();
            $last_repayment = $this->accountRepaymentSchedule->where('type','emi')->last();
            if(Carbon::parse($closure_month)->format('Y-m')<=$first_repayment->emi_month) {
                $closing_outstanding = $first_repayment;
            } else {
                $closing_outstanding = $last_repayment;
            }
        }
        
        return $closing_outstanding;
    }

    public function getClosureOverdue($closure_month)
    {
        $closing_outstanding = $this->accountRepaymentSchedule()
            ->where('type','emi')
            ->where('emi_month','like',Carbon::parse($closure_month)->format('Y-m').'%')
            ->first();

        if(!$closing_outstanding) {
            $first_repayment = $this->accountRepaymentSchedule->where('type','emi')->first();
            $last_repayment = $this->accountRepaymentSchedule->where('type','emi')->last();
            if(Carbon::parse($closure_month)->format('Y-m')<=$first_repayment->emi_month) {
                $closing_outstanding = $first_repayment;
            } else {
                $closing_outstanding = $last_repayment;
            }
        }
        $closure_overdue = $this->accountRepaymentSchedule()->whereDate('emi_month','<=',$closing_outstanding->emi_month)->get();

        $tobe_collected_amount = $closure_overdue->sum('emi');

        $collected_amount = $this->collections()->accountCollection()->get()->sum('amount_received');
        $overdue = $tobe_collected_amount-$collected_amount;

        return $overdue;
    }

    public function getClosureLatePaymentCharges($closure_month)
    {
        if($closure_month==null) {
            //$closure_month = Carbon::today()->format('d-m-Y');
            $closure_month = Carbon::parse($closure_month)->format('Y-m-d');
        }
        //dd($closure_month);
        $calculated_delay_charges = $this->accountRepaymentSchedule()->sum('delay_charges');
        //dd($calculated_delay_charges);
        $unpaid_repayment_months = $this->accountRepaymentSchedule()
            ->where('type','emi')
            ->whereDate('emi_month','<=',Carbon::parse($closure_month)->format('Y-m-d'))
            ->where('amount_received','<',$this->approved_loan_emi)
            ->get();
        //dd($unpaid_repayment_months,$closure_month);
        $late_payment_charges = 0+$calculated_delay_charges;
        $dpd = 0;
        
        if($unpaid_repayment_months->count()) {
            $dpd = Carbon::parse($unpaid_repayment_months->first()->emi_month)->diffInDays($closure_month);
            foreach ($unpaid_repayment_months as $unpaid_repayment_month) {
                $unpaid_amount = $unpaid_repayment_month->emi-$unpaid_repayment_month->amount_received;
                //dd($unpaid_amount);
                if($unpaid_amount==$unpaid_repayment_month->emi) {
                    $unpaid_days_difference = Carbon::parse($unpaid_repayment_month->emi_month)->diffInDays($closure_month);
                    $no_to_days = ($unpaid_days_difference/365);
                    $late_payment_charges += round($no_to_days*(0.18*$unpaid_amount),2);
                    //DataLog::info('delay charges for '.$unpaid_days_difference.' days is '.$late_payment_charges);
                    //$charges += $late_payment_charges;              
                } else {
                    $unpaid_days_difference = Carbon::parse($unpaid_repayment_month->emi_month)->diffInDays($closure_month);
                    $no_to_days = ($unpaid_days_difference/365);
                    $late_payment_charges += round($no_to_days*(0.18*$unpaid_amount),2);
                    //DataLog::info('delay charges for '.$unpaid_days_difference.' days is '.$late_payment_charges);
                    //$charges += $late_payment_charges;           
                }
                       
            }
        }

        //$charges = 0;
        
        //dd($charges);
        /*$closure_month = Carbon::parse($closure_month)->format('Y-m-d');
        
        $closing_outstanding = $this->accountRepaymentSchedule()
            ->where('emi_month','like',Carbon::parse($closure_month)->format('Y-m').'%')
            ->first();

        if(!$closing_outstanding) {
            $first_repayment = $this->accountRepaymentSchedule->first();
            $last_repayment = $this->accountRepaymentSchedule->last();
            if(Carbon::parse($closure_month)->format('Y-m')<=$first_repayment->emi_month) {
                $closing_outstanding = $first_repayment;
            } else {
                $closing_outstanding = $last_repayment;
            }
        }

        $closure_late_payment_repayment = $this->accountRepaymentSchedule()->whereDate('emi_month','<=',$closing_outstanding->emi_month)->where('type','emi')->get();

        $late_payment_charges = 0;
        $total_delay_days = 0;
        
        foreach ($closure_late_payment_repayment as $accountRepaymentSchedule) {

            $charges=0;            
            if($accountRepaymentSchedule->amount_received<$accountRepaymentSchedule->emi) {
                if($accountRepaymentSchedule->emi_payment_date==null) {
                    $pending_amount = $accountRepaymentSchedule->emi-$accountRepaymentSchedule->amount_received;
                    $closure_days_difference = Carbon::parse($accountRepaymentSchedule->emi_month)->diffInDays($closure_month);
                    $no_to_days = ($closure_days_difference/365);
                    $charges += round($no_to_days*(0.18*$pending_amount),2);
                    //echo "get pending amount for ".$closure_days_difference." days = ".$charges.'<br>';
                } elseif($accountRepaymentSchedule->emi_payment_date>$accountRepaymentSchedule->emi_month) {
                    $charges += $accountRepaymentSchedule->delay_charges;
                    $pending_amount = $accountRepaymentSchedule->emi-$accountRepaymentSchedule->amount_received;
                    $closure_days_difference = Carbon::parse($accountRepaymentSchedule->emi_month)->diffInDays($closure_month);
                    $no_to_days = ($closure_days_difference/365);
                    $charges += round($no_to_days*(0.18*$pending_amount),2);
                    //echo "get second pending amount for ".$closure_days_difference. " days = ".$charges.'<br>';
                } else {
                    $charges +=0;
                }
            } else {
                if($accountRepaymentSchedule->emi_payment_date>$accountRepaymentSchedule->emi_month) {
                //echo "payment date ".$accountRepaymentSchedule->emi_payment_date." is small than emi date ".$accountRepaymentSchedule->emi_month.'<br>';
                $closure_days_difference = Carbon::parse($accountRepaymentSchedule->emi_month)->diffInDays($accountRepaymentSchedule->emi_payment_date);
                //dd($closure_days_difference);
                $no_to_days = ($closure_days_difference/365);
                $charges += round($no_to_days*(0.18*$accountRepaymentSchedule->amount_received),2);
                } else {
                    //echo "payment date ".$accountRepaymentSchedule->emi_payment_date." is greater than emi date ".$accountRepaymentSchedule->emi_month.'<br>';
                    $charges +=0;
                }
                //$charges=$accountRepaymentSchedule->delay_charges;
                //echo "If full amount is from db = ".$charges.'<br>';
            }
            $late_payment_charges += $charges;
            //dd($accountRepaymentSchedule,$late_payment_charges);
        }
        //dd($late_payment_charges);
        //check if partial payment exists
        $partial_payment = $this->accountRepaymentSchedule()
            ->whereDate('emi_month','<=',$closing_outstanding->emi_month)
            ->where('type','emi')
            ->where('amount_received','<',$this->approved_loan_emi)
            ->get()
            ->sortBy('emi_month');
        $last_payment = $this->accountRepaymentSchedule()
            ->whereDate('emi_month','<=',$closing_outstanding->emi_month)
            ->where('type','emi')
            ->where('amount_received',0)
            ->where('emi_payment_date',null)
            ->get();

        if($partial_payment->count()) {
            $total_delay_days = Carbon::parse($partial_payment->first()->emi_month)->diffInDays($closure_month);
        } elseif($last_payment->count()) {
            $total_delay_days = Carbon::parse($last_payment->last()->emi_month)->diffInDays($closure_month);
        } else {
            $total_delay_days=0;
        }*/

        return [
            'total_delay_days'=>$dpd,
            'late_payment_charges'=>$late_payment_charges,
        ];
    }

    /**
     * get cibil control number from the file
     */
    public function getCibilControlNumber()
    {
        //open file
        $path = public_path()."/documents/".$this->id."/cibil_report.html";
        if(file_exists($path)) {
            $open = fopen($path,'r');
            $file_get_contents = file_get_contents($path);
            //dd($file_get_contents);
            $dom = new Dom;
            $dom->load($file_get_contents);
            $control_number = $dom->find('span')[5]->text;
            fclose($open);
            return $control_number;
        } else {
            return null;
        }
    }
}
