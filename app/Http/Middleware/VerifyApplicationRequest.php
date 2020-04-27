<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class VerifyApplicationRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!Session::has('application_id')){
           // return redirect('/apply/loan/personal-details');
        }
        return $next($request);
    }
}
