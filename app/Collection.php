<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $fillable = ['application_id', 'emi_payment_date', 'amount_received',
    	'narration', 'ref_no', 'source', 'principal_adjustment', 'type', 'transaction_number', 'bounce'];

    // scope for bounce cheque collections only
    public function scopeBounce($query)
    {
        return $query->where('type','bounce')->where('bounce',0);
    }

    //scope for acc repayment collection
    public function scopeAccountCollection($query)
    {
        return $query->whereIn('type',['emi','advance_emi'])->where('bounce',0);
    }

    // scope for collection index page. fetch only emi & advance emi collection
    public function scopeNoBounce($query)
    {
        return $query->whereIn('type',['emi','advance_emi']);
    }

    /**
     * Get the application for this repayment schedule
     */
    public function application()
    {
    	return $this->belongsTo('App\Application');
    }
}
