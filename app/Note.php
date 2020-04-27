<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = ['application_id','admin_id','text','type'];


    public function admin()
    {
    	return $this->belongsTo('App\Admin');
    }

    public function application()
    {
    	return $this->belongsTo('App\Application');
    }

    public function getCreatedAtAttribute($value)
    {
        $date = Carbon::parse($value);
        return $date->format('j F, Y h:i A');
    }

    public function getUpdatedAtAttribute($value)
    {
        $date = Carbon::parse($value);
        return $date->format('j F, Y h:i A');
    }
}
