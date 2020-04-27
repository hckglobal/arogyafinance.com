<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
   protected $fillable = ['name'];

   public function cities()
   {
   	return $this->hasMany('App\City');
   }

   public function admins()
    {
    	return $this->belongsToMany('App\Admin');
    }
}
