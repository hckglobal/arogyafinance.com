<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    protected $fillable = ["first_name","middle_name","last_name","date_of_birth","gender","mobile_number","email","aadhar_card_number","pan_card_number","id_proof_number","id_proof_type","residence_type","address1","address2","city","state","pincode","reference_code"];
    protected $dates = [''];

    protected $integrityCutoff =4.5;
    protected $abilityCutoff=4.5;
    protected $riskCutoff=5.5;
    protected $intentionCutoff=5;

    /**
     * Get the form for the user
     */
    public function form()
    {
        return $this->hasOne('App\Form');
    }


      /**
     * Get the family members for the user
     */
    public function familyMembers()
    {
        return $this->hasMany('App\FamilyMember');
    }

     /**
     * Get the form for the user
     */
    public function answers()
    {
        return $this->hasMany('App\Answer');
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
                $answers = $this->answers()->where('parameter_id',1)->get();
                break;

            case 'integrity':
                //get all answers
                $answers = $this->answers()->where('parameter_id',2)->get();
                break;

            case 'intention':
                //get all answers
                $answers = $this->answers()->where('parameter_id',3)->get();
                break;
            case 'risk':
               //get all answers
                $answers = $this->answers()->where('parameter_id',4)->get();

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

}
