<?php

namespace App\Http\Controllers\Mobile;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\TreatmentType;
use App\Helpers\Api;
use App\Admin;
use Auth;
class LoginController extends Controller
{
    /**
     * Authenticate incoming requet
     */
    public function login(Request $input)
    {
        $credentials['email'] = $input->email;
        $credentials['password'] = $input->password;
        $credentials['status'] = 1; 
        if (Auth::attempt($credentials)) {
            return Api::success("Authenticated!",Auth::User());
        } else {
            return Api::error('UnAuthorized');            
        }
    }
}
