<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable =['name','admin_id'];

    /**
     * Get the admin for the log
     */
    public function admins()
    {
    	return $this->belongsToMany('App\Admin','admin_location')->where('status',1);
    }

    /**
     * Get the applications for the location
     */
    public function applications() {
        return $this->hasMany('App\Application');
    }
}
