<?php

namespace App;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
	protected $fillable = ['name','display_name','description'];
	
	public function permissions()
	{
		return $this->belongsToMany('App\Permission');
	}

	public function charge()
	{
    	return $this->hasOne('App\Charge');
	}

    /**
     * Get the closure charges for the role
     */
    public function charges()
    {
        return $this->hasOne('App\Charge','role_id');
    }
}
