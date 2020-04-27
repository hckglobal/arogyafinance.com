<?php

namespace App\Http\Controllers\Mobile;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\TreatmentType;
use App\Helpers\Api;

class TreatmentTypeController extends Controller
{
    /**
     * Fetch all treatment type from database.
     */
    public function index(Request $input)
    {
        $treatment_types = TreatmentType::get(['name']); 
        
        if($treatment_types->count()) {
            return Api::success($treatment_types);
        } else {
            return Api::error('No location available.');
        }
    }
}
