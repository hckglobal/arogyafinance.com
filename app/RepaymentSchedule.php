<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class RepaymentSchedule extends Model
{
    protected $fillable = ['application_id', 'month_at', 'type','emi_month', 'emi', 'principal', 'interest', 
    					   'outstanding_principal', 'amount_received', 'emi_payment_date', 'narration', 'ref_no', 'source'];

    /**
     * Get the application for this repayment schedule
     */
    public function application()
    {
    	return $this->belongsTo('App\Application');
    }
}
