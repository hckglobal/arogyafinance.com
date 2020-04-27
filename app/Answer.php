<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{

    protected  $fillable = ['borrower_id','question_id','option_id'];

  /**
     *
     * get the answer of the form
     *
     */
    public function question()
    {
    	return $this->belongsTo('App\Question');
    }
    /**
     *
     * get the answer of the form
     *
     */
    public function user()
    {
    	return $this->belongsTo('App\User');
    }
    /**
     *
     * get the option of the form
     *
     */
    public function option()
    {
    	return $this->belongsTo('App\Option');
    }

    /**
     *
     * get the option of the form
     *
     */
    public function parameter()
    {
    	return $this->belongsTo('App\Parameter');
    }



}
