<?php

namespace App\Http\Controllers\Admin\TreatmentType;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\TreatmentType;

class TreatmentTypeController extends Controller
{
    /**
     * Display a listing of the treatment type.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Manage Treatment Type";
        $treatment_types = TreatmentType::all();
        return view('admin.pages.treatmenttype.index')->with(['title'=>$title,'treatment_types'=>$treatment_types]);
    }

    /**
     * Show the form for creating a new treatment type.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Add New Treatment Type";
        return view('admin.pages.treatmenttype.create')->with(['title'=>$title]);
    }

    /**
     * Store a newly created treatment type in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $input)
    {
        $treatment_type = TreatmentType::create($input->all());
        return redirect('/admin/treatment-type/all');
    }

    /**
     * Display the specified treatment type.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified treatment type.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = "Edit Treatment Type";
        $treatment_type = TreatmentType::find($id);
        return view('admin.pages.treatmenttype.edit')->with(['title'=>$title,'treatment_type'=>$treatment_type]);
    }

    /**
     * Update the specified treatment type in database.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $input, $id)
    {
        $treatment_type = TreatmentType::find($id);
        $treatment_type->update($input->all());
        return redirect('/admin/treatment-type/all');
    }

    /**
     * Remove the specified treatment type from database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TreatmentType::destroy($id);
        return redirect('/admin/treatment-type/all');
    }
}
