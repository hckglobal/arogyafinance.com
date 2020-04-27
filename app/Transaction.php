<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['application_id','transaction_number','amount'];

    public function  application() {
    	return $this->belongsTo('App\Application');
    }
}
