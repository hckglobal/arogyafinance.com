<?php
namespace App\Http\Middleware;
use App\Admin;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\App;

class ApiToken
{
    protected $auth;
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }
    public function handle($request, Closure $next)
    {
        if($request->ajax()) {
            return $next($request);
        }
        if($request->input('api_token') && $this->hasMatchingToken($request->input('api_token'))) {
            return $next($request);
        } else {
            return response('Unauthorized.', 401);
        }
    }
    /**
     * Check Input api_token exist in system database
     */
    public function hasMatchingToken($token)
    {
        if($user = Admin::where('api_token', $token)->first())
        
        return true;
    }
}