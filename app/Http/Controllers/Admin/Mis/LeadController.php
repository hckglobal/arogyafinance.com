<?php

namespace App\Http\Controllers\Admin\Mis;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Excel;
use App\Lead;
use Redirect;
use Session;
use App\Product;
use DB;
use App\Application;
use Carbon\Carbon;
use App\Location;
use App\RejectionReason;
use App\Borrower;
use Log;
use Auth;

class LeadController extends Controller
{
    
    /**
     * Show the form for creating a new lead.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Add New Lead";
        $products = Product::all();
        $locations = Location::all();
        return view('admin.pages.lead.create')
             ->with(['title'=>$title, 'products'=>$products,'locations'=>$locations]);
    }

    /**
     * Store a newly created lead in database.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $input)
    {
        $lead = Lead::create($input->all());
        $lead->date_of_contact =  Carbon::now()->format('Y-m-d');
        $lead->referrer_id = Auth::User()->referrer_code;
        // $lead->date_of_birth .= "-".$input->get('lead_birthday_month');
        // $lead->date_of_birth .= "-".$input->get('lead_birthday_day');

        // $lead->save();
        $lead->status = "pending";
        $lead->reject_reason_id = 0;
        $lead->save();
        Session::flash('info','New Lead Created');
        return redirect('/admin/analytics/mis/summary/filter?status=pending');
    }

    /**
     * Show the form for editing the specified lead.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = "Edit Lead";
        $lead = Lead::find($id);
        $products = Product::all();
        return view('admin.pages.lead.edit')->with(['title'=>$title,'lead'=>$lead, 'products'=>$products]);

    }

    /**
     * Update the specified lead in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $input, $id)
    {
        $lead = Lead::find($id);
        $lead->update($input->all());
        Session::flash('info','Lead updated');
        return redirect('/admin/lead/pending');
    }

    /**
     * Remove the specified lead from database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reject($id,Request $input)
    {
        $lead = Lead::find($id);
        $lead->reject_reason_id = $input->get('reject_reason_id');
        $lead->status = "rejected";
        $lead->save();
        Session::flash('info','Lead rejected');

        return redirect('/admin/lead/pending');

    }

    /*
     * Retrive all the lead with new status
     */
    public function newLeads($type)
    {   
        $title=str_replace('-',' ',$type);
        $title = ucfirst($title)." Leads";
        //$leads = Lead::all();
        $leads=Lead::where('status',$type)->get();
        /*$leads = DB::table('leads')->where('status',$type)
                  ->join('locations', 'locations.id', '=', 'leads.location_id')
                  ->join('products', 'products.id', '=', 'leads.product_id')
                  ->select('leads.id','leads.first_name','leads.middle_name','leads.last_name','leads.mobile_number',
                      DB::raw('products.name as product'),
                      DB::raw('locations.name as location'))
                  ->get();*/
        //dd($leads);
        $type=$type;
        $reject_reasons = RejectionReason::all();
        return view('admin.pages.lead.index')
             ->with(['title'=>$title,'leads'=>$leads,'type'=>$type, 'reject_reasons'=>$reject_reasons]);
    }

    public function import(Request $request)
    {
        if ($request->hasFile('sample_file')) {
            $path = $request->file('sample_file')->getRealPath();
            $data = \Excel::load($path)->get();
            if ($data->count()>0) {
                $data = $data->toArray();

                //$check_pins = $this->checkPins($data);
                //$check_mobile_nos = $this->checkMobileNumbers($data);
                foreach ($data as $key => $value) {
                    if ((int)$value['case_status']==7 || (int)$value['case_status']==11 || (int)$value['case_status']==12) {
                        $status = "pending";
                        $reject_reasons = 0;
                    } else {
                       $status = "rejected";
                       $reject_reasons = (int)$value['case_status'];
                    }
                    $leads[] = [
                              'date_of_contact' => Carbon::parse($value['date_of_contact'])->format('Y-m-d'),
                              'pin_number' => preg_replace('/\s+/', '', $value['pin_no']),
                              'hospital_name' =>  preg_replace('/\s+/', '', $value['hospital_name']),
                              'location_id' => (int)$value['location_id'],
                              'first_name' => preg_replace('/\s+/', '', $value['patient_first_name']),
                              'middle_name' => preg_replace('/\s+/', '',$value['patient_middle_name']), 
                              'last_name' => preg_replace('/\s+/', '', $value['patient_last_name']),
                              'product_id' => (int)$value['product_id'],
                              'mobile_number' => $value['contact_number'],
                              'alternate_number' => $value['alternate_number'],
                              //'email' => $value['email'],
                              'reject_reason_id' => $reject_reasons,
                              'status' => $status,
                              'requested_loan_amount' => (int)$value['loan_amount'],
                              'created_at' => Carbon::now()
                             ];
                    //dd($leads);         
                }
                //$chunks = array_chunk($leads,500);
                foreach ($leads as $arr) {
                    if (!empty($arr)) {
                        DB::table('leads')->insert($arr);
                    }
                }
                Session::flash('info','Lead Imported Successfully');
                return redirect('/admin/lead/pending');                
            }
        }
    }

    public function checkPins($data)
    {
        $given_pins = collect();
        $match_rows = collect();
        foreach ($data as $key => $value) {
          //dd($key,$value);
            $pin = preg_replace('/\s+/', '', $value['pin_no']);
            $given_pins->push($pin);
        }
        //dd($given_pins);
        foreach ($given_pins as $pin) {
          //dd($pin);
            $match_rows->push(Application::where('pin_number','like','%'.$pin.'%')->first());
            

        }
        //dd($match_rows->pluck('pin_number'));
        if($match_rows){
            $applications = $match_rows->unique('pin_number');
                Excel::create('Arogya', function($excel) use ($applications) {

                $excel->sheet('Match PIN', function($sheet) use($applications) {       
                    $arr =array();
                    foreach($applications as $key=>$value) {
                        
                            //dd($key,$values);
                            //$data =  array($key);
                            //array_push($arr, $data);
                            

                                
                                 $data =  array(
                                    $value['id'],
                                    $value['pin_number'],
                                    $value['type'],
                                    $value['status']);
                                array_push($arr, $data);
                            
                                                   
                    }

                    //set the titles
                    $sheet->fromArray($arr,null,'A1',false,false)->prependRow(array(
                            'ID','PIN','Type','Status'
                        )

                    );

                });

            })->export('xlsx');
        }
    }

    public function checkMobileNumbers($data)
    {
        $given_mobile_nos = collect();
        $match_rows = collect();
        foreach ($data as $key => $value) {
          //dd($data);
            $mobile_no = preg_replace('/\s+/', '', $value['alternate_number']);
            $given_mobile_nos->push($mobile_no);
        }
        //Log::info($given_mobile_nos);
        //dd($given_mobile_nos);
        foreach ($given_mobile_nos as $mobile_no) {
          //dd($mobile_no);
            $borrowers = Borrower::where('alternate_number','like','%'.$mobile_no.'%')->get();
            //dd();
            if($borrowers->count()!=0){
              
              $match_rows->push($borrowers); 
            }
            //dd($match_rows);
        }
        //dd($match_rows->first());
        //dd($match_rows->pluck('mobile_number'));
        //Log::info($match_rows);
        //dd($match_rows->pluck('mobile_number'));
        if($match_rows){
            $borrowers = $match_rows;
            //dd($borrowers->count());
                Excel::create('Match Mobile_Nos', function($excel) use ($borrowers) {

                $excel->sheet('sheet1', function($sheet) use($borrowers) {       
                    $arr =array();
                    foreach($borrowers as $key=>$values) {
                      foreach ($values as $value) {
                        $data =  array(
                          $value['application_id'],
                          $value['alternate_number']);
                      array_push($arr, $data);
                      }                       
                    }
                    //set the titles
                    $sheet->fromArray($arr,null,'A1',false,false)->prependRow(array(
                            'App-ID','Alternate Number'
                        )

                    );

                });

            })->export('xlsx');
        }
    }
}
