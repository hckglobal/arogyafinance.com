<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RejectionReason extends Model
{
    protected $fillable = ['text'];


    public function applications()
    {
        return $this->hasMany('App\Application');
    }

    public function leads()
    {
        return $this->hasMany('App\Lead');
    }
}
