<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Referrer extends Model
{

	protected $fillable = ['name','description','uid' ,'affiliate_id'];

    public function affiliate()
    {
        return $this->belongsTo('App\Affiliate');
    }
    public function applications()
    {
    	return $this->hasMany('App\Application');
    }
}
