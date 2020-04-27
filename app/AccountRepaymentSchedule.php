<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AccountRepaymentSchedule extends Model
{
    protected $fillable = ['application_id', 'type', 'emi_month', 'emi', 
    	'principal', 'interest', 'outstanding_principal', 
    	'amount_received', 'emi_payment_date', 'principal_adjustment_amount',
        'delay_charges'
    ];

    public function settypeAttribute($value)
    {
        $this->attributes['type'] = strtolower($value);
    }

    /**
     * Get the application for this repayment schedule
     */
    public function application()
    {
    	return $this->belongsTo('App\Application');
    }

    public function getDelayDays()
    {
        $future_repayments_outstanding_amount = $this->application->accountRepaymentSchedule()->where('type','emi')->whereDate('emi_month','>=',$this->emi_month)->get();
        $outstanding_amount = $future_repayments_outstanding_amount->sum('emi');

        if($this->emi_payment_date) {
            if($this->emi_payment_date <= $this->emi_month) {
                $difference = 0;
            } else {
                $emi_date = new Carbon($this->emi_month);
                $payment_date = new Carbon($this->emi_payment_date);
                $difference = $emi_date->diffInDays($payment_date);
            }
        } else {
            $difference = 0;
        }
        
        $no_to_days = ($difference/365);
        $late_payment_charges = round($no_to_days*(0.18*$this->amount_received),2);
        //$late_payment_charges = round($no_to_days*(0.18*$outstanding_amount),2);
        //dd($no_to_days,$late_payment_charges,$difference,$outstanding_amount);
        return [
            'late_payment_charges'=>$late_payment_charges,
            'delay_days'=>$difference
        ];
    }
}
