<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Charge extends Model
{
    protected $fillable = ['role_id','principal_os','overdue_emi','dishonor', 'late_payment', 'legal', 
    	'pre_payment'
	];
	
	public function role()
	{
		return $this->belongsTo('App\Role');
	}
}
