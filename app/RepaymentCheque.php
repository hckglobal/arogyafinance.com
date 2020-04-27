<?php

namespace App;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class RepaymentCheque extends Model
{
    protected $fillable = ['application_id','borrower_name','bank_name','cheque_number','branch','amount','series','type','cheque_date'];

    public function application() {
    	return $this->belongsTo('App\Application','application_id');
    }

    /*public function getChequeDateAttribute($value)
    {
        $date = Carbon::parse($value);
        return $date->format('j F, Y');
    }*/
}
