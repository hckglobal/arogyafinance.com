<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OutstandingPrincipalReport extends Model
{
    protected $fillable = ['pin_number','loan_amount','emi','no_of_advance_emi','valid_from','valid_upto',
		'disbursement_date','interest_rate','tenure','overdue_amount','interest','principal',
		'outstanding_principal','total_collection','receivable','overdue_in_months','application_id','processing_fee','document_charge'];
}
