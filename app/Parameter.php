<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    /**
     * this function returns questions this parameter.
     * returns array of question object
     */
    public function questions()
    {
        return $this->hasMany('App\Question');
    }
}
