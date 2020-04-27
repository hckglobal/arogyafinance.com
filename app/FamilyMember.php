<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FamilyMember extends Model
{
    protected $fillable = ['application_id','first_name','last_name','relation','date_of_birth','gender'];

    
    /**
     * Get the application for the Family member
     */
    public function application()
    {
    	return $this->belongsTo('App\Application');
    }

    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = ucfirst($value);
    }

    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = ucfirst($value);
    }
}
