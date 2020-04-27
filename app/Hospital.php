<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Baum\Node;

class Hospital extends Node
{
    protected $fillable = ['name','url','location','branches','acc_name',
        'acc_number','bank_name','bank_branch','ifsc_code','acc_type',
        'hospital_referrer','parent_id', 'lft', 'rgt', 'depth',
        'first_name','last_name','mobile_number','email','email_notification'];

    protected $orderColumn = 'id';

	public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }

    public function setLocationAttribute($value)
    {
        $this->attributes['location'] = ucfirst($value);
    }

    public function setBranchesAttribute($value)
    {
        $this->attributes['branches'] = ucfirst($value);
    }

    public function setAccNameAttribute($value)
    {
        $this->attributes['acc_name'] = ucfirst($value);
    }

    public function setBankNameAttribute($value)
    {
        $this->attributes['bank_name'] = ucfirst($value);
    }

    public function setBankBranchAttribute($value)
    {
        $this->attributes['bank_branch'] = ucfirst($value);
    }

    public function setIfscCodeAttribute($value)
    {
        $this->attributes['ifsc_code'] = strtoupper($value);
    }
    
    public function setAccTypeAttribute($value)
    {
        $this->attributes['acc_type'] = ucfirst($value);
    }

    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = ucfirst($value);
    }

    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = ucfirst($value);
    }

    /**
     * Get the hospital director for the hospital
     */
    public function hospitalDirector()
    {
        return $this->hasOne('App\HospitalDirector');
    }
}
