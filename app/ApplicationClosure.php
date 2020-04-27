<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicationClosure extends Model
{
    protected $fillable = ['application_id', 'closure_date', 'closure_amount','overdue_amount', 'principal_outstanding',
    	'adjusted_principal', 'adjusted_outstanding_principal', 'adjusted_dishonor', 'adjusted_late_payment', 
    	'adjusted_legal', 'adjusted_pre_payment', 'adjusted_waived_off'];

    /**
     * Get the application for this closure
     */
    public function application()
    {
    	return $this->belongsTo('App\Application', 'application_id');
    }

}
