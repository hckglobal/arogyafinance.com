<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    /**
     *
     * get the user of the form
     *
     */

    protected $fillable = ['application_id','name'];
    protected $table = "assets";
    
    public function form()
    {
        return $this->belongsTo('App\Form');
    }

}
