<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MerchantDocument extends Model
{
    protected $fillable = ['application_id','consumer_profile_pic','aadhar_kyc_link','pan_link',
						   'signed_agreement_link','nach_link','others_link'];
    /**
     * Get the application for the application
     */
    public function application()
    {
        return $this->belongsTo('App\Application');
    }
}
