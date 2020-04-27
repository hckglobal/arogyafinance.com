<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OldCollection extends Model
{
    protected $fillable = ['application_id', 'emi_payment_date', 'amount_received',
    	'narration', 'ref_no', 'source', 'principal_adjustment'];

    /**
     * Get the application for this repayment schedule
     */
    public function application()
    {
    	return $this->belongsTo('App\Application');
    }

}
