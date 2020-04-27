<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HospitalDirector extends Model
{
    protected $fillable = ['hospital_id','first_name','middle_name','last_name','date_of_birth','gender','mobile_number','email','residence_type','city','state','pincode','address_line_1','address_line_2','marital_status','id_proof_type','id_proof_number'];
	
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

    public function setStateAttribute($value)
    {
        $this->attributes['state'] = ucfirst($value);
    }
	
	/**
     * Get the hospital for this Hospital Director
     */
    public function hospital()
    {
        return $this->belongsTo('App\Hospital','hospital_id');
    }
}
