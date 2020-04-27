<?php

namespace App\Http\Controllers\Admin\Application;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Application;

class LogController extends Controller
{
    /**
     * Display a listing of the log.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $application= Application::find($id);
        $logs=$application->logs->sortByDesc('id');
        
        return view('admin.pages.log.index')->with(['logs'=>$logs,'application'=>$application]);
    }    
}
