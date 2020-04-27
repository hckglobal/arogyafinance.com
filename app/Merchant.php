<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    protected $fillable = ['application_id','merchant_id','merchant_location_id','bank_account_no',
						   'bank_name','bank_address','bank_ifsc_code','bank_account_name','order_id'];
    /**
     * Get the application for the application
     */
    public function application()
    {
        return $this->belongsTo('App\Application');
    }
}
