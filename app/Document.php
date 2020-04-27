<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['application_id','name','file','type'];

    /**
     * Get the application for the document
     */

    public function application()
    {
    	return $this->belongsTo('App\Application');
    }

    public function getTypeAttribute($value)
    {
        return ucfirst($value);
    }


}
