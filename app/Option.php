<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    /**
     * this function returns question for the option.
     * return type is question object
     */
    public function question()
    {
        return $this->belongsTo('App\Question');
    }
}
