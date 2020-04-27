<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Screenshot extends Model
{
    protected $fillable = ['url'];

    public function borrower()
    {
        return $this->belongsTo('App\Borrower');
    }
}
