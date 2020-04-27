<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Carbon\Carbon;

class Log extends Model
{
    protected $fillable = ['application_id','admin_id','field','old_value','new_value'];

    /**
     * Get the application for the log
     */
    public function application()
    {
    	return $this->belongsTo('App\Application');
    }

     /**
     * Get the admin for the log
     */
    public function admin()
    {
    	return $this->belongsTo('App\Admin');
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function store($id,$admin_id,$field_name,$old_value,$value)
    {
        $admin=Auth::user()->id;
        Log::create(['application_id'=>$id,'admin_id'=>$admin_id,'field'=>$field_name,'old_value'=>$old_value,'new_value'=>$value]);
    }

    public function getCreatedAtAttribute($value)
    {
        $date = Carbon::parse($value);
        return $date->toDayDateTimeString();
    }

    public function getUpdatedAtAttribute($value)
    {
        $date = Carbon::parse($value);
        return $date->toDayDateTimeString();
    }
}
