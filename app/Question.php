<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
   
   /**
     * Scope returns questions of parameter ability to pay
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAbility($query)
    {
        return $query->where('parameter_id', 1);
    }

    /**
     * Scope returns questions of parameter integrity to pay
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIntegrity($query)
    {
        return $query->where('parameter_id', 2);
    }

    /**
     * Scope returns questions of parameter intention to pay
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIntention($query)
    {
        return $query->where('parameter_id', 3);
    }

    /**
     * Scope returns questions of parameter risk to pay
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRisk($query)
    {
        return $query->where('parameter_id', 4);
    }

     /**
     * Scope returns level of parameter of scope low
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLow($query)
    {
        return $query->where('level_id', 1);
    }

     /**
     * Scope returns level of parameter of scope medium
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMedium($query)
    {
        return $query->where('level_id', 2);
    }

    /**
     * Scope returns level of parameter of scope high
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeHigh($query)
    {
        return $query->where('level_id', 3);
    }

    /**
     * get the options for this question
     * returns options object array
     */
    public function options()
    {
        return $this->hasMany('App\Option');
    }

    /**
     * get the one parameter for this question
     * returns parameter belonging to the question
     */
    public function parameter()
    {
        return $this->belongsTo('App\Parameter');
    }
    
    
    /**
     * get the one parameter for this question
     * returns parameter belonging to the question
     */
    public function answers()
    {
        return $this->hasMany('App\Answer');
    }

    /**
     * get the one parameter for this question
     * returns parameter belonging to the question
     */
    public function level()
    {
        return $this->belongsTo('App\Level');
    }

    protected $fillable = ['text_en','text_hi','text_mr','text_gu','text_bn','parameter_id','level_id'];
}
