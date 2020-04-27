<?php

namespace App\Http\Controllers\Admin\Application;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Application;
use Carbon\Carbon;
use App\Admin;
use App\Borrower;
use App\Log;
use DB;
class TatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $application= Application::find($id);
        $logs=$application->logs()->where('field','status')->orderBy('created_at','asc')->get();
        $old_val=$logs->pluck('old_value');
        $last_val="";

        foreach ($logs as $log) {
            
            if ($old_val)  $log->tat=Carbon::parse($application->getOriginal('created_at'))->diffForHumans(Carbon::parse($log->getOriginal('created_at')), true);

            if ($last_val) $log->tat = Carbon::parse($log->getOriginal('created_at'))->diffForHumans($last_val, true);

            $last_val = Carbon::parse($log->getOriginal('created_at'));

        }
        return view('admin.pages.tat.index')->with(['logs'=>$logs,'application'=>$application]);
    }

    /**
     * Display a users statistics of the applications.
     *
     * @return \Illuminate\Http\Response
     */
    public function statistics()
    {
        $application_logs=collect();
        $logs=Log::where('field','status')->orderBy('created_at','asc')->get();
        $old_val=$logs->pluck('old_value');
        $last_val="";                        
        
        foreach ($logs as $log) {
            $application = Application::find($log->application_id);
            if (isset($application)) {
                 $data = array();
                if ($old_val)  $log->tat=Carbon::parse($application->getOriginal('created_at'))->diffInHours(Carbon::parse($log->getOriginal('created_at')), true);

                if ($last_val) $log->tat = Carbon::parse($log->getOriginal('created_at'))->diffInHours($last_val, true);

                $last_val = Carbon::parse($log->getOriginal('created_at'));
                array_push($data,$log->id);
                array_push($data,$log->application_id);

                if (isset($log->admin->first_name)) {
                    array_push($data,$log->admin_id);
                    array_push($data,$log->admin->first_name.' '.$log->admin->last_name);
                } else {
                    array_push($data,'Admin Id not available');
                    array_push($data,'Admin name not available');
                }                                                        
                array_push($data,$log->old_value);
                array_push($data,$log->new_value);                         
                array_push($data,$log->tat);
                $application_logs->push($data);
            }                                                           
        }
        //dd($application_logs->take(20));
        $result = $application_logs->groupBy(3);
        $users = collect();
        
        foreach ($result as $key => $value) {
            $users->put($key,$value->groupBy(5));
        }
        
        return view('admin.pages.tat.tat')->with(['users'=>$users]);        
    }
}
