<?php

namespace App\Http\Controllers\Admin\Staff;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Auth;
use App\Location;
use App\Admin;
use App\Role;
use Redirect;
use Session;
use App\ActivityLog;
use App\TreatmentType;
use App\Hospital;
use App\Product;

class StaffController extends Controller
{
    /**
     * Display all the staff
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Manage Users";
        $admins = Admin::all();
        return view('admin.pages.staff.index')->with(['title'=>$title,'admins'=>$admins]);
    }

    /**
     * Create Staff
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $title = "Add User";
        $roles = Role::where('name','!=','admin')->get();
        $locations = Location::all()->sortBy('name');
        //generating all the  list partner required
        $application_columns=array("none"=>"None","treatment_type" => "Treatment Type","hospital_name" =>"Hopital Name","product_id"=>"Product");

        return view('admin.pages.staff.create')->with(['title'=>$title,'locations'=>$locations,
                                                        'roles'=>$roles,
                                                        'application_columns'=>$application_columns
                                                        ]);
    }

    /**
     * Store Staff
     * @param  Request $input get the input from form
     * @return \Illuminate\Http\Response
     */
    public function store(Request $input)
    {
        if($input->email_notification) {
            $input->request->add(['email_notification'=>1]);
        } else {
            $input->request->add(['email_notification'=>0]);
        }

        $admin = Admin::create($input->all());
        
        if (!$admin->referrer_code) {
            $admin->referrer_code = "null";
        }

        if ($admin->application_column == "none") {
            $admin->application_column_value="null";
        }

        $admin->attachRole($input->role_ids[0]);
        $admin->locations()->attach($input->location_ids);
        $admin->merchant_api_token = str_random(60);
        $admin->api_token = str_random(60);
        $admin->save();
        //$this->syncAdminLocationAndRoles($input,$admin);
        Session::flash('info','User created');
        return redirect('/admin/staff/all');
    }

    /**
     * Show edit page to update the staff details
     * @param  $id staff id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = "Edit User";
        $locations = Location::all()->sortBy('name');
        $roles = Role::where('name','!=','admin')->get();
        $admin = Admin::find($id);
        $application_columns=array("none"=>"None","treatment_type" => "Treatment Type","hospital_name" =>"Hopital Name","product_id"=>"Product");

        return view('admin.pages.staff.edit')->with(['title'=>$title,'admin'=>$admin,'locations'=>$locations,
            'roles'=>$roles,'application_columns'=>$application_columns]);
    }

    /**
     * Update the staff details
     * @param  $id    staff id
     * @param  Request $input accept the form data
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $input)
    {
        if($input->email_notification) {
            $input->request->add(['email_notification'=>1]);
        } else {
            $input->request->add(['email_notification'=>0]);
        }
        $admin = Admin::find($id);
        $admin->update($input->all());
        $this->syncAdminLocationAndRoles($input,$admin);
        Session::flash('info','User updated');
        return redirect('/admin/staff/all');
    }

    /**
     * Destroy particular staff 
     * @param  $id staff id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Admin::destroy($id);
        Session::flash('info','User deleted');
        return Redirect::back();
    }

    /**
     * Synchronize Admin Location And Roles 
     * @param  Request $input 
     * @param  $admin 
     * @return 
     */
    public function syncAdminLocationAndRoles(Request $input,$admin)
    {

        /*//sync states
        if ($input->has('states')) {
            $admin->states()->sync($input->get('states'));
        }

        //sync cities
        if ($input->has('cities')) {
              $admin->cities()->sync($input->get('cities'));
        }*/

        if ($input->has('role_id')) {
            $admin->roles()->sync($input->get('role_id'));
        }

        if ($input->has('location_ids')) {
            $admin->locations()->sync($input->location_ids);
        } else {
            $admin->locations()->sync([]);            
        }
    }

    /**
     * Update password for a particular staff
     * @param  $id    staff id
     * @param  Request $input accept the password from form
     * @return \Illuminate\Http\Response
     */
    public function updatePassword($id, Request $input)
    {
        $admin = Admin::find($id);
        $admin->update($input->all());
        Session::flash('info','Password updated');
        return redirect('/admin/staff/all');
    }

    /**
     * [Activate / Deactivate Admin]
     * @param  [int]  $id    [Admin Id]
     * @param  Request $input [input data]
     * @return \Illuminate\Http\Response
     */
    public function updateStatus($status,$id)
    {
        $admin = Admin::find($id);
        if($status=="activate") {
            $admin->status = 1;
            $flash = 'Activated';
        } else {
            $admin->status = 0;
            $flash = 'Deactivated';
        }
        $admin->save();
        ActivityLog::createLog($flash,$admin->id);
        Session::flash('info',$flash);
        return redirect('/admin/staff/all');
    }

    public function getAccountActivityLogs()
    {
        $title = "Account Activity Logs";
        $activity_logs = ActivityLog::latest()->get();
        return view('admin.pages.staff.activity_logs')->with(['title'=>$title,'activity_logs'=>$activity_logs]);
    }



    public function fetchEntity(Request $input, $entity){
        $data = [];
        switch($entity){
            case 'treatment_type':
                $data = TreatmentType::get(['name AS key','name AS value']);
            break;

            case 'hospital_name':
                $data = Hospital::get(['name AS key','name AS value']);
            break;

            case 'product_id':
                $data = Product::get(['id AS key','name AS value']);
            break;

            default:
            break;
        }

        return $data;
    }
}
