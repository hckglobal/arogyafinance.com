<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\AdminLocation;

class City extends Model
{
	protected $fillable = ['name','state_id'];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }

    public function admins()
    {
    	return $this->belongsToMany('App\Admin');
    }


}
