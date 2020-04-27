<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Affiliate extends Model
{
    protected $fillable = ['name','description'];


    public function referrers()
    {
        return $this->hasMany('App\Referrer');
    }
}
