<?php

namespace App\Http\Controllers\Mobile;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Hospital;
use App\Helpers\Api;
use App\Admin;

class HospitalController extends Controller
{
    /**
     * Fetch all hospitals from database.
     */
    public function index(Request $input)
    {
        if($input->ajax()) {
            $hospitals = Hospital::get(['id','name'])->toJson();
            return $hospitals;
        } else {
            $hospitals = Hospital::get(['id','name']);
            if($hospitals->count()) {
                return Api::success($hospitals);
            } else {
                return Api::error('No location available.');
            }            
        }   

        
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
            return Api::success("Hospital created!",['id'=>$child_hospital->id,'name'=>$child_hospital->name]);
        } else {
            $input = $input->all();
            $input['parent_id']=null;
            $parent_hospital = Hospital::create($input);
            return Api::success("Hospital created!",['id'=>$parent_hospital->id,'name'=>$parent_hospital->name]);
        }
    }
}
