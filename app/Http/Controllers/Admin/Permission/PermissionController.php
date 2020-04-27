<?php
namespace App\Http\Controllers\Admin\Permission;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Permission;
use App\Role;
use Session;


class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $rolePermissions  = Role::find($id)->permissions;
        $role = Role::find($id);
        $roles = Role::all();
        $permissions =Permission::all();
        return view('admin.pages.permission.index')
             ->with(['role'=>$role,'roles'=>$roles,'permissions'=>$permissions,'rolePermissions'=>$rolePermissions]);
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
        $role->permissions()->sync($input->get('permissions'));
        Session::flash('info','Permission updated !!');
        return \Redirect::back();
    }
}
