<?php

namespace App\Http\Controllers\Mobile;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Location;
use App\Helpers\Api;

class LocationController extends Controller
{
    /**
     * Fetch all locations from database.
     */
    public function index(Request $input)
    {
        $locations = Location::get(['id','name']); 
        
        if($locations->count()) {
            return Api::success($locations);
        } else {
            return Api::error('No location available.');
        }
    }
}
