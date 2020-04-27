<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = ['application_id','first_name','middle_name','last_name','date_of_birth','gender',
        'mobile_number','address_line_1','address_line_2','city','state','pincode','pan_card','aadhar_card',
        'driving_id','voting_id','residing_since','marital_status','permanent_address','permanent_city','permanent_state','permanent_pincode'];
    protected $dates = [''];




    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = ucfirst($value);
    }

    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = ucfirst($value);
    }
    public function setMiddleName($value)
    {
      $this->attributes['middle_name']=ucfirst($value);
    }


    /**
     * Get the application for the Patient
     */
    public function application()
    {
        return $this->belongsTo('App\Application');
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
}
