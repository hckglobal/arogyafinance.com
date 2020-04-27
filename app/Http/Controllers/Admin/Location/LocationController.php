<?php

namespace App\Http\Controllers\Admin\Location;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Auth;
use App\State;
use App\Location;
use App\Admin;
use App\Role;
use Redirect;
use Session;

class LocationController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Manage Location";
        $locations = Location::all();
        return view('admin.pages.location.index')->with(['title'=>$title,'locations'=>$locations]);
    }


    /**
     * show page 
     *
     * @param  no param
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
          $title = "Add Location";
          return view('admin.pages.location.create')->with(['title'=>$title]);
    }

    
    /**
     * store data.
     *
     * @param  Request $input
     * @return \Illuminate\Http\Response
     */
    public function store(Request $input)
    {
      Location::create($input->all());
      Session::flash('info','New Location created');
      return redirect('/admin/location/all');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = "Edit Location";
        $location = Location::find($id);
        return view('admin.pages.location.edit')->with(['title'=>$title,'location'=>$location]);

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $input, $id)
    {
        $lead = Location::find($id);
        $lead->update($input->all());
        Session::flash('info','Location updated');
        return redirect('/admin/location/all');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         Location::destroy($id);
         Session::flash('info','Location deleted successfully');
         return redirect('/admin/location/all');
    }
}
