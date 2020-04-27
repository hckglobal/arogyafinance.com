<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use App\City;
use App\State;

class Form extends Model
{
  

  
  protected $fillable = ['pin','status','type','cibil_score','borrowers_income','earning_since','nature_of_income','source_of_income','employer_details','name_of_firm','income_itr','current_loan_emi','education_expenses','house_rent','number_of_dependants','other_earnings','other_earnings_type','monthly_emi_possible','total_borrowers_income','borrowers_marital_status','hospital_name','other_expense','calculated_income','calculated_loan_amount','calculated_loan_emi','calculated_loan_tenure','approved_loan_amount','approved_loan_emi','approved_loan_tenure','id_proof','residence_proof','income_proof','id_proof_doc','income_proof_doc','residence_proof_doc','bank_statement_doc','photo','patient_first_name','patient_middle_name','patient_last_name','patient_date_of_birth','patient_mobile_number','patient_gender','treatment_type','estimate_cost','loan_required','requested_tenure','approved_hospital_name','date_of_approval','interest_rate','subvention','processing_fee'];


  protected $dates=['']; 

   /**
    *  Get the user of the form
    * @return 
    */
     public function user()
    {
        return $this->belongsTo('App\User');
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
     * The documents of the form
     * @return  
     */
     public function documents()
    {
        return $this->hasMany('App\Document');
    }

    /**
     * The assets of the form
     * @return  
     */
     public function notes()
    {
        return $this->hasMany('App\Note');
    }


     /**
      * Remaining documents for the form
      * @return int 
      */
     public function remainingDocumentsCount()
    {
        $count = 0;
        if (!$this->id_proof_doc) $count++;
        if (!$this->income_proof_doc) $count++;   
        if (!$this->residence_proof_doc) $count++; 
        if (!$this->bank_statement_doc) $count++; 
        if (!$this->photo) $count++;  
        return $count;
    }

    /**
     * The category of the form
     * @return string category
     */
    public function category()
    {
       $cibil = $this->cibil_score;

       if($cibil>=self::CIBIL_SCORE_CAT_1){
        return 'One';

       }elseif($cibil>self::CIBIL_SCORE_CAT_1 -1 && $cibil<= self::CIBIL_SCORE_CAT_2){
        return 'Two';

       }elseif($cibil<self::CIBIL_SCORE_CAT_1-1 && $cibil>=0){
        return 'Three';
       }else{
        return 'Uncategorized';
       }

    }

    
    
    /**
     * scope verfied 
     * @param   $query 
     * @return Form 
     */
     public function scopeVerified($query)
    {
        return $query->where('status', 'verified');
       
    }


    /**
     * scope unVerfied 
     * @param   $query 
     * @return Form 
     */
     public function scopeUnVerfied($query)
    {
        return $query->where('status', 'new');
       
    }


    /**
     * scope sanctioned 
     * @param   $query 
     * @return Form 
     */
     public function scopeSanctioned($query)
    {
        return $query->where('status', 'sanctioned');
       
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
        //get the state admins
        $admins = State::where('name',$this->user->city)->first()->admins;
      }else{
        $admins = State::where('name',$this->user->state)->first()->admins;
      }

      return $admins;
    }

    public function getAdminsAttribute(){
      return $this->admins();
    }

    public function scopePending($type,$category)
    {
      $categoryFun = 'Category'.ucfirst($category);
      Auth::user()->forms()->where('type',$type)->$categoryFun()->unVerfied()->count();
    }


    public function getCategoryAttribute()
    {
      if($this->cibil_score>=self::CIBIL_SCORE_CAT_1){
        return 'one' ;
      }elseif($this->cibil_score<=self::CIBIL_SCORE_CAT_1-1 && $this->cibil_score>=self::CIBIL_SCORE_CAT_2){
        return 'two' ;
      }elseif($this->cibil_score<=self::CIBIL_SCORE_CAT_2-1 && $this->cibil_score>=-1){
        return 'three';
      }elseif($this->cibil_score==-100){
        return 'none';
      }
    }
}
