<?php
namespace App\Http\Controllers\Admin\Charge;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Charge;
use App\Role;
use Session;

class ChargeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        $title = "Manage Charges";

        return view('admin.pages.charge.index')
             ->with(['roles'=>$roles, 'title'=>$title]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $input)
    {
        $role = Role::find($id);
        // get colunn name
        $column_name = $input->get('name');

        // get column value
        $value = $input->get('value');

        if($role->charge) {
            $role->charge()->update([$column_name => $value]);
        } else {
            $role->charge()->create([$column_name => $value]);            
        }

        Session::flash('info','Charges updated !!');
        return redirect()->back();
    }
}
