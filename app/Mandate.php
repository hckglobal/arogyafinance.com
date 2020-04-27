<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mandate extends Model
{
    protected $fillable = ['application_id', 'mandate_id', 'type', 'status', 'message', 
       'partner_entity_status','umrn', 'provider'
   ];
    
    /**
     * Get the application for the application
     */
    public function application()
    {
        return $this->belongsTo('App\Application');
    }
}
