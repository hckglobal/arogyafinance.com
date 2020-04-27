<?php

namespace App\Http\Controllers\Website\Enquiry;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Mail;
use Redirect;
use Session;

class EnquiryController extends Controller
{
    /**
     *
     * enquiry mail
     *
     */
    
    public function enquiryMail(Request $input)
    {
        $name = $input->get('name');
        $email = $input->get('email');
        $mobile_number = $input->get('mobile_number');
        $enquiry_details = ['name'=>$name,'email'=>$email,'mobile_number'=>$mobile_number];

        Mail::send('website.emails.enquiry', ['name'=>$name,'email'=>$email,'mobile_number'=>$mobile_number],
            function ($mail) use ($enquiry_details)
            {
                $mail->to("info@arogyafinance.com", 'Arogya Finance')->subject("enquiry mail");
            });
        Session::flash('Info','Mail send');
        return redirect()->back();


    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
