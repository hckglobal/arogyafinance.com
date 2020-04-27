<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PsychometricTest extends Model
{
    protected  $fillable = ['application_id','result','test_url'];

    /**
     *
     * get the application of the test
     *
     */
    public function application()
    {
    	return $this->belongsTo('App\Application');
    }

    public function setResultAttribute($value)
    {
        $this->attributes['result'] = ucfirst($value);
    }
}
