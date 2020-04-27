<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    protected $fillable = ['application_id','name','mobile_number','address','relation'];

    public function application() {
    	return $this->belongsTo('App\Application','application_id');
    }
}
