<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Borrower extends Model
{
    protected $fillable = ['application_id','type','first_name','middle_name','last_name','date_of_birth','gender','mobile_number','email','residence_type','city','state','pincode','address_line_1','address_line_2','marital_status','borrowers_income','earning_since','nature_of_income','source_of_income','employer_details','name_of_firm','income_itr','current_loan_emi','education_expenses','house_rent','number_of_dependants','other_earnings','other_earnings_type','monthly_emi_possible','id_proof_type','id_proof_number','pan_card_number','aadhar_card_number','alternate_number','relation_with_patient','residing_since',
        'permanent_address','permanent_city','permanent_state','permanent_pincode'];

    protected $dates = [''];

    protected $integrityCutoff =5;
    protected $abilityCutoff=5;
    protected $riskCutoff=4.25;
    protected $intentionCutoff=5;


    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = ucfirst($value);
    }
    public function setMiddleNameAttribute($value)
    {
        $this->attributes['middle_name'] = ucfirst($value);
    }
    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = ucfirst($value);
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    public function setAddressLine1Attribute($value)
    {
        $this->attributes['address_line_1'] = ucwords($value);
    }

    public function setAddressLine2Attribute($value)
    {
        $this->attributes['address_line_2'] = ucwords($value);
    }

     public function setCityAttribute($value)
    {
        $this->attributes['city'] = ucfirst($value);
    }

    public function setNameOfFirmAttribute($value)
    {
      $this->attributes['name_of_firm'] = ucwords($value);
    }

    public function setGenderAttribute($value)
    {
      $this->attributes['gender'] = ucfirst($value);
    }

    public function getTypeAttribute($value)
    {
        return ucfirst($value);
    }

    public function getAddressLine1Attribute($value)
    {
        return strtolower($value);
    }

    public function getAddressLine2Attribute($value)
    {
        return strtolower($value);
    }

    public function getCityAttribute($value)
    {
        return strtolower($value);
    }

    public function getStateAttribute($value)
    {
        return strtolower($value);
    }

    /**
     * Get the application for the Borrower
     */
    public function application()
    {
        return $this->belongsTo('App\Application');
    }

    /**
     * Get the form for the user
     */
    public function answers()
    {
        return $this->hasMany('App\Answer');
    }

    /**
     * Get the screenshot  for the psychometric test
     */
    public function screenshots()
    {
        return $this->hasMany('App\Screenshot');
    }


    /**
     *
     * get the option of the form
     *
     */
    public function score($type)
    {
        $score=0;
        switch ($type) {

            case 'ability':
                $answers = $this->answers()->whereHas('question',function($query){
                    $query->where('parameter_id',1);
                })
                ->get();
                break;

            case 'integrity':
                //get all answers
                $answers = $this->answers()->whereHas('question',function($query){
                    $query->where('parameter_id',2);
                })
                ->get();
                break;

            case 'intention':
                //get all answers
                $answers = $this->answers()->whereHas('question',function($query){
                    $query->where('parameter_id',3);
                })
                ->get();
                break;
            case 'risk':
               //get all answers
                $answers = $this->answers()->whereHas('question',function($query){
                    $query->where('parameter_id',4);
                })
                ->get();

                break;
            case 'total':
                //get all answers
                $answers = $this->answers;
                break;
            default:
                 //get all answers
                $answers = $this->answers;
                break;
        }

        foreach ($answers as $answer) {
            $score= $score + $answer->option->value;
        }

        return $score;
    }

    /**
     *
     * Test Result
     *
     */
    public function result($type)
    {
        $cutoff = $type.'Cutoff';
        $cutoff = $this->$cutoff;
       // dd($cutoff);

        if($type!='total'){
          return $this->score($type) >=  $cutoff ? 'accept' : 'reject';
        }

        else{
          return ($this->result('integrity')=='accept' && $this->result('abililty')=='accept' && $this->result('intention')=='accept' && $this->result('risk')=='accept' )? 'accept' : 'reject';
        }

    }

    /**
     * get created_at Attribute 
     * @param  [date] $value 
     * @return [date]          
     */
    public function getCreatedAtAttribute($value)
    {
        $date = Carbon::parse($value);
        return $date->format('j F, Y');
    }

    /**
     * get update_at Attribute 
     * @param  [date] $value 
     * @return [date]          
     */
    public function getUpdatedAtAttribute($value)
    {
        $date = Carbon::parse($value);
        return $date->format('j F, Y');
    }

    public function getFullNameAttribute()
    {
        return $this->first_name.' '.$this->middle_name.' '.$this->last_name;
    }

}
