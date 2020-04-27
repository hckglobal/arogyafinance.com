<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use App\Application;
use Illuminate\Contracts\Auth\Guard;


class VerifyApplicationAccess
{   
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /*if ($request->route('id');) {
            $applications=Application::all()->pluck('id');
            $valid_application=$applications->contains($request->route('id'));
            return $application;
        
        }
        
        return $next($request);*/
        //return $request->route('id');
        $user= $this->auth->user();

        $user_applications=$user->applications;
        //dd($user_applications);
        $valid_applications=$user_applications->contains($request->route('id'));
        //dd($valid_applications);
        if($valid_applications != false ){
            return $next($request);
        }
        return view('admin.pages.application.access_denied');
    }
}
