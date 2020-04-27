<?php

namespace App\Http\Controllers\Admin\Hospital;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;
use App\Hospital;
use Auth;

class HospitalController extends Controller
{
    /**
     * Display a listing of the hospital.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = " Manage Hospitals";
        $user = Auth::user();
        if($user->hasRole(['partner'])) {
            $hospitals = Hospital::where('hospital_referrer',$user->referrer_code)->latest()->get();
        } else {
            $hospitals = Hospital::all();
        }       
        
        return view('admin.pages.hospital.index')->with(['title'=>$title,'hospitals'=>$hospitals]);
    }

    /**
     * Show the form for creating a new hospital.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Add New Hospital";
        $hospitals = Hospital::all();
        return view('admin.pages.hospital.create')
            ->with(['title'=>$title,'hospitals'=>$hospitals]);
    }

    /**
     * Store a newly created hospital in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $input)
    {
        if($input->email_notification) {
            $input->request->add(['email_notification'=>1]);
        } else {
            $input->request->add(['email_notification'=>0]);
        }
        if($input->has('parent_id')){
            $parent_hospital = Hospital::find($input->parent_id);
            $child_hospital = $parent_hospital->children()->create($input->all());
        } else {
            $input = $input->all();
            $input['parent_id']=null;
            $parent_hospital = Hospital::create($input);
        }
        
        Session::flash('info','New Hospital Created');
        return redirect('/admin/hospital/all');
    }

    /**
     * Display the specified hospital.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = "Hospital Details";
        $hospital = Hospital::find($id);
        return view('admin.pages.hospital.show')->with(['title'=>$title,'hospital'=>$hospital]);
    }

    /**
     * Show the form for editing the specified hospital.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = "Edit Hospital Details";
        $hospital = Hospital::find($id);
        $hospitals = Hospital::all();
        return view('admin.pages.hospital.edit')->with(['title'=>$title,'hospital'=>$hospital,'hospitals'=>$hospitals]);
    }

    /**
     * Update the specified hospital in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $input, $id)
    {
        if($input->email_notification) {
            $input->request->add(['email_notification'=>1]);
        } else {
            $input->request->add(['email_notification'=>0]);
        }
        $hospital = Hospital::find($id);
        if($hospital->isRoot()){
            $hospital->update($input->except('parent_id'));
        } else {
            $hospital->update($input->all());            
        }
        Session::flash('info','Hospital updated');
        return redirect('/admin/hospital/all');
    }

    /**
     * Remove the specified hospital from database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Hospital::destroy($id);
        Session::flash('info','Hospital deleted');
        return redirect()->back();
    }

    public function addSubHospitals($id,Request $input)
    {
        $title = "Import Hospital Branch";
        return view('admin.pages.hospital.import',['title'=>$title,'id'=>$id]);
    }

    public function storeSubHospitals($id,Request $input)
    {
        if ($input->hasFile('sample_file')) {
            $path = $input->file('sample_file')->getRealPath();
            $data = \Excel::load($path)->get();
            $pins = collect();
            if ($data->count()>0) {
                $sheets = $data->toArray();
                $children = array();
                foreach ($sheets as $row) {
                    array_push($children,$row);
                }
                $parent_hospital = Hospital::find($id);
                $parent_hospital->makeTree($children);
            }
        }

        Session::flash('info','Hospital Branch Added');
        return redirect('/admin/hospital/all');
    }

    public function updateHospitalDetailForm()
    {
        $title = "Update Hospital Details";
        return view('admin.pages.hospital.update_hospitals_detail',['title'=>$title]);
    }

    public function updateHospitalDetail(Request $input)
    {
        if ($input->hasFile('sample_file')) {
            $path = $input->file('sample_file')->getRealPath();
            $data = \Excel::load($path)->get();
            $pins = collect();
            if ($data->count()>0) {
                $sheets = $data->toArray();
                foreach ($sheets as $row) {
                    $hospital = Hospital::find($row['id']);
                    $hospital->update($row);
                }
            }
            
            Session::flash('info','Hospital Updated');
            return redirect('/admin/hospital/all');
        }
    }

    public function importHospitalsForm(Request $input)
    {
        $title = "Import Hospitals";
        return view('admin.pages.hospital.import_parent_hospital',['title'=>$title]);
    }

    public function importHospitals(Request $input)
    {
        if ($input->hasFile('sample_file')) {
            $path = $input->file('sample_file')->getRealPath();
            $data = \Excel::load($path)->get();
            $pins = collect();
            if ($data->count()>0) {
                $sheets = $data->toArray();
                $children = array();
                foreach ($sheets as $row) {
                    $row['parent_id']=null;
                    $parent_hospital = Hospital::create($row);
                }
            }
        }

        Session::flash('info','Hospitals Added');
        return redirect('/admin/hospital/all');
    }
}