<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Borrower;
use App\Application;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Auth;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    //Search function to search values from database
    //
    public function search(Request $input)
    {
        $keyword = preg_replace('/\s+/', '', $input->get('keyword'));        
        $admin = Auth::user();
        $application_ids = $admin->applications->pluck('id');
        
        /*$results = DB::table('borrowers')
                        ->select('*')
                        ->join('applications','applications.id','=','borrowers.application_id')
                        ->where('first_name','LIKE',"%$keyword%")
                    ->orWhere('id_proof_number','LIKE',"%$keyword%")
                    ->orWhere('pan_card_number','LIKE',"%$keyword%")
                    ->orWhere('aadhar_card_number','LIKE',"%$keyword%")
                   ->orWhere('last_name','LIKE',"%$keyword%")
                   ->orWhere('application_id','LIKE',"$keyword")
                   ->orWhere('reference_code','LIKE',"%$keyword%")
                    ->orWhere('pin_number','LIKE',"%$keyword%")
                    ->orderBy('application_id','desc')->get();*/

        $results = DB::table('borrowers')
                    ->whereIn('borrowers.application_id',$application_ids)
                    ->join('applications','applications.id','=','borrowers.application_id')
                    ->join('locations', 'locations.id', '=', 'applications.location_id')
                    ->Where(function($query) use($keyword){
                        return $query
                            ->Where('application_id',$keyword)
                            ->orWhere('reference_code','LIKE',"%".$keyword."%")
                            ->orWhere('pin_number','LIKE',"%".$keyword."%")
                            ->orWhere('first_name','LIKE',"%".$keyword."%")
                            ->orWhere('last_name','LIKE',"%".$keyword."%")
                            ->orWhere('id_proof_number','LIKE',"%".$keyword."%")
                            ->orWhere('pan_card_number','LIKE',"%".$keyword."%")
                            ->orWhere('aadhar_card_number','LIKE',"%".$keyword."%")
                            ->orWhere('mobile_number','LIKE',"%".$keyword."%")
                            ->orWhere('email','LIKE',"%".$keyword."%")
                            ->orWhere('alternate_number','LIKE',"%".$keyword."%");
                        })
                    ->select('applications.id','applications.type',
                             'borrowers.type as borrower_type',
                             'borrowers.first_name','borrowers.last_name',
                             'locations.name as location')
                ->orderBy('application_id','desc')->get();        
        
        return view('admin.pages.search.index')->with(['results'=>$results,'keyword'=>$keyword,'title'=>'Search Results']);
    }   
}
