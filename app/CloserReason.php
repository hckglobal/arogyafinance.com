<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CloserReason extends Model
{
    protected $fillable = ['display_name', 'name'];

    public function applications()
    {
        return $this->hasMany('App\Application');
    }
}
