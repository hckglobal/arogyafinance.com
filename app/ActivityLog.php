<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Carbon\Carbon;

class ActivityLog extends Model
{
    protected $fillable = ['admin_id','message','user_id'];

    public static function createLog($message,$user_id)
	{
		$auth_user = Auth::User();
		$message = $message;
		$data = ['admin_id'=>$auth_user->id,'message'=>$message,'user_id'=>$user_id];
		ActivityLog::create($data);
	}

	/**
     * Get the admin for the log
     */
    public function admin()
    {
    	return $this->belongsTo('App\Admin');
    }

    /**
     * Get the user of the log
     */
    public function user()
    {
    	return $this->belongsTo('App\Admin','user_id');
    }
}
