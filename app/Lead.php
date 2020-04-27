<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = ['first_name','middle_name','last_name','location_id','mobile_number','email',
                           'reject_reason_id','status',	'product_id', 'date_of_contact', 
                           'pin_number', 'hospital_name', 'alternate_number', 
                           'requested_loan_amount','referrer_id'
                           ];

    public function getFirstNameAttribute($value)
    {
        return ucfirst($value);
    }

    public function getLastNameAttribute($value)
    {
        return ucfirst($value);
    }
    
    public function getHospitalNameAttribute($value)
    {
        return ucfirst($value);
    }

    public function getDateOfContactAttribute($value)
    {
        $date = Carbon::parse($value);
        return $date->format('j F, Y');
    }

    public function location()
    {
        return $this->belongsTo('App\Location');
    }

    public function product() 
    {
        return $this->belongsTo('App\Product');
    }

    public function  application() 
    {
        return $this->hasOne('App\Application');
    }

    public function rejectionReason()
    {
        return $this->belongsTo('App\RejectionReason','reject_reason_id');
    }
}
