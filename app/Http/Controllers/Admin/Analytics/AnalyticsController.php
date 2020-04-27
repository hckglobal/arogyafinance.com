<?php

namespace App\Http\Controllers\Admin\Analytics;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Application;
use App\Location;
use App\RejectionReason;
use Carbon\Carbon;
use DB;
use App\Product;
use App\Lead;
use Excel;
use Auth;

class AnalyticsController extends Controller
{
    /**
     * [summary MIS for Loan & Card Applications]
     * @param  Request $input [filter data]
     * @return [object]
     */
    public function summary(Request $input)
    {   
        if($input->type){
            $title = "Summary - ".$input->type;
        } else {
            $title = "Summary";            
        }

        $filter_dropdown_list = $this->getFilterDropDownList();        
        $locations = $filter_dropdown_list['locations'];        
        $products = $filter_dropdown_list['products'];
        $ids = $this->getUserApplicationIds();        
        $application_types = $this->getType($input,$mis="loan&card",$ids);
        $application_status = $this->getStatus($input,$mis="loan&card",$ids);
        $application_disbursed_status = $this->getDisbursedStatus($input,$mis="loan&card",$ids);
        $application_reject_status = $this->getRejectStatus($input,$mis="loan&card",$ids);
        $application_location = $this->getLocation($input,$mis="loan&card",$ids);
        
        $application_disbursed = DB::table('applications')
            ->whereIn('status',['disbursed','closed'])
            ->whereIn('applications.id',$ids)
            ->select('applications.id','applications.type','applications.status',
                     'applications.disbursement_date','applications.created_at',
                     'applications.rejection_reason_id','applications.location_id',
                     'applications.product_id');

        if ($input->has('start_date')) {
            $start_date = Carbon::parse($input->start_date)->format('Y-m-d');
            $application_disbursed = $application_disbursed
                ->whereDate('applications.disbursement_date','>=',$start_date);
        }

        if ($input->has('end_date')) {
            $end_date = Carbon::parse($input->end_date)->format('Y-m-d');      
            $application_disbursed = $application_disbursed
                ->whereDate('applications.disbursement_date','<=',$end_date);
        }
        
        $application_disbursed = $application_disbursed
                ->select(DB::raw('MONTHNAME(disbursement_date) as month,YEAR(disbursement_date) as year,count(id) as count,sum(approved_loan_amount) as disbursed_amount'))
                ->groupBy(DB::raw('MONTHNAME(disbursement_date)'),DB::raw('MONTH(disbursement_date)'),DB::raw('YEAR(disbursement_date)'))
                ->orderBy(DB::raw('MAX(disbursement_date)'),'DESC');

        if ($input->has('type') && $input->type!='') {
           $application_disbursed = $application_disbursed->where('type',$input->type);
        }
        
        if ($input->has('location') && $input->location!='all') {
           $application_disbursed = $application_disbursed->where('location_id',$input->location);
        }

        if ($input->has('product') && $input->product!='all') {
            $application_disbursed = $application_disbursed->where('product_id',$input->product);
        }

        $application_disbursed = $application_disbursed->get();
        $total_disbursement_count = 0;
        $total_disbursement_amount = 0;
        
        foreach ($application_disbursed as $key => $value) {
            $total_disbursement_count += $value->count;
            $total_disbursement_amount += $value->disbursed_amount; 
        }

        return view('admin.pages.analytics.summary-filter')
            ->with(['title'=>$title, 'locations'=>$locations,
                    'input'=>$input, 'application_types'=>$application_types,
                    'application_status'=>$application_status,
                    'application_location'=>$application_location,
                    'application_disbursed'=>$application_disbursed,
                    'input'=>$input, 'products'=>$products, 
                    'total_disbursement_count'=>$total_disbursement_count,
                    'total_disbursement_amount'=>$total_disbursement_amount,
                    'application_reject_status'=>$application_reject_status,
                    'application_disbursed_status'=>$application_disbursed_status
                ]);
    }

    /**
     * [summaryFilter Display Detail of filter applications]
     * @param  Request $input [Filtered Data]
     * @return [object]         
     */
    public function summaryFilter(Request $input)
    {
        if($input->type){
            $title = "Summary - ".$input->type;
        } else {
            $title = "Summary";            
        }

        $filter_dropdown_list = $this->getFilterDropDownList();
        $locations = $filter_dropdown_list['locations'];
        $products = $filter_dropdown_list['products'];
        $ids = $this->getUserApplicationIds();       
        $applications = $this->getApplications($input,$ids);

        if ($input->has('month_year')) {
            $year = Carbon::parse($input->month_year)->format('Y');
            $month = Carbon::parse($input->month_year);
            $start_of_month =Carbon::parse($input->month_year)->startOfMonth();
            $end_of_month = Carbon::parse($input->month_year)->endOfMonth();
            $applications = $applications->where('status','disbursed')
                ->whereBetween('disbursement_date',[ $start_of_month,$end_of_month]);
        }

        $applications = $applications
            ->leftjoin('borrowers', function ($join) {
                $join->on('applications.id', '=', 'borrowers.application_id')
                     ->where('borrowers.type', '=','primary');
            })
            ->leftjoin('locations', function ($join) {
                $join->on('locations.id', '=', 'applications.location_id');
            })            
            ->leftjoin('products', function ($join) {
                $join->on('products.id', '=', 'applications.product_id');
            })
            ->select('applications.id','applications.type','applications.pin_number','applications.status',
                DB::raw('borrowers.first_name,borrowers.middle_name,borrowers.last_name'),
                DB::raw('locations.name as location'))
            ->get();

        return view('admin.pages.analytics.filtered_status')
            ->with(['title'=>$title, 'locations'=>$locations,
                    'input'=>$input, 'applications'=>$applications, 'products'=>$products
            ]);
    }

    /**
     * [getApplications Filter the application]
     * @param  [Request] $input [filter data]
     * @return [object]        [applications]
     */
    public function getApplications($input,$ids,$data=null)
    {   
        $applications = DB::table('applications')
            ->whereIn('applications.id',$ids)
            ->select('applications.id','applications.type','applications.status',
                     'applications.disbursement_date','applications.created_at',
                     'applications.rejection_reason_id','applications.location_id',
                     'applications.product_id');

        if ($input->has('type') && $input->type!='') {
            $applications = $applications->where('applications.type',$input->type);
        }

        if ($input->has('start_date')) {
            if ($input->has('status') && $input->status=='disbursed' || $data=='disbursed' || $input->status=='disbursed_closed') {

                $start_date = Carbon::parse($input->start_date)->format('Y-m-d');
                $applications = $applications->whereDate('applications.disbursement_date','>=',$start_date);
            } else {
                $start_date = Carbon::parse($input->start_date)->format('Y-m-d');
                $applications = $applications->whereDate('applications.created_at','>=',$start_date);
            }
        }
        
        if ($input->has('end_date')) {
            if ($input->has('status') && $input->status=='disbursed' || $data=='disbursed' || $input->status=='disbursed_closed') {
                $end_date = Carbon::parse($input->end_date)->format('Y-m-d');
                $applications = $applications->whereDate('applications.disbursement_date','<=',$end_date);
            } else {
                $end_date = Carbon::parse($input->end_date)->format('Y-m-d');
                $applications = $applications->whereDate('applications.created_at','<=',$end_date);
            }
        }

        if ($input->has('status') && $input->status!='all') {
            if ($input->has('reject_reason_id')) {
                $applications = $applications->where('status','rejected')
                    ->where('rejection_reason_id',$input->reject_reason_id);
            } elseif ($input->status>0) {
                $applications = $applications->where('status','rejected')
                    ->where('rejection_reason_id',$input->status);
            } elseif ($input->status=='disbursed_closed') {
               $applications = $applications->whereIN('status',['disbursed','closed']);
            } else {
                $applications = $applications->where('status',$input->status);  
            }
            
        }

        if($data=='disbursed') {
            $applications =$applications->whereIn('status',['disbursed','closed']);
        }

        if ($input->has('reject_reason_id')) {
            $applications = $applications->where('status','rejected')
                ->where('rejection_reason_id',$input->reject_reason_id);
        }

        if ($input->has('location') && $input->location!='all') {
            $applications = $applications->where('location_id',$input->location);
        }        

        if ($input->has('product') && $input->product!='all') {
            $applications = $applications->where('product_id',$input->product);
        }
        
        return $applications;
    }

    /**
     * [Lead MIS Summary]
     * @param  Request $input [Filter Data]
     * @return [object]         [Leads]
     */
    public function misSummary(Request $input)
    {
        $title = "MIS Summary";
        $filter_dropdown_list = $this->getFilterDropDownList();
        $locations = $filter_dropdown_list['locations'];
        $products = $filter_dropdown_list['products'];
        $ids = $this->getUserLeadIds();
        $leads = $this->getLeads($input,$ids);

        $application_status = $this->getStatus($input,$mis=null,$ids);
        $application_location = $this->getLocation($input,$mis=null,$ids);
        $application_reject_status = $this->getRejectStatus($input,$mis=null,$ids);
        $leads = $leads->count();

        return view('admin.pages.analytics.mis-summary-filter')
            ->with(['title'=>$title, /*'years'=>$years,*/ 'locations'=>$locations, 'input'=>$input,
                    'application_status'=>$application_status, 'application_location'=>$application_location,
                    'products'=>$products, 'leads'=>$leads, 'application_reject_status'=>$application_reject_status
            ]);
    }

    /**
     * [LEAD MIS Filter]
     * @param  Request $input [Filter data]
     * @return [object]         [leads]
     */
    public function misSummaryFilter(Request $input)
    {   
        $title = "MIS Summary";
        $filter_dropdown_list = $this->getFilterDropDownList();
        $locations = $filter_dropdown_list['locations'];
        $products = $filter_dropdown_list['products'];
        $ids = $this->getUserLeadIds();
        $leads = $this->getLeads($input,$ids);

        $application_status = $this->getStatus($input,$mis=null,$ids);
        $application_location = $this->getLocation($input,$mis=null,$ids);
        $application_reject_status = $this->getRejectStatus($input,$mis=null,$ids);
        $reject_reasons = RejectionReason::all();
        $leads = $leads
            ->leftjoin('locations', function ($join) {
                $join->on('locations.id', '=', 'leads.location_id');
            })
            ->leftjoin('products', function ($join) {
                $join->on('products.id', '=', 'leads.product_id');
            })
            ->leftjoin('rejection_reasons', function ($join) {
                $join->on('rejection_reasons.id', '=', 'leads.reject_reason_id');
            })
            ->select('leads.id','leads.date_of_contact','leads.first_name','leads.middle_name','leads.last_name','leads.referrer_id',
                'leads.status','leads.mobile_number',
                    DB::raw('locations.name as location'),
                    DB::raw('products.name as product'),
                    DB::raw('rejection_reasons.text as reject_reason'))
            ->orderBy('leads.id', 'desc')
            ->get();
        //dd($leads);
        return view('admin.pages.analytics.mis-filtered_status')
            ->with(['title'=>$title, 'locations'=>$locations, 'input'=>$input,
                    'leads'=>$leads, 'products'=>$products,
                    'application_reject_status'=>$application_reject_status,
                    'reject_reasons'=>$reject_reasons
                    ]);
    }

    /**
     * [getLeads based on the filter]
     * @param  [Request] $input [filter data]
     * @return [object]  
     */
    public function getLeads($input,$ids)
    {
        $leads = DB::table('leads')
            ->whereIn('leads.id',$ids)
            ->select('leads.id','leads.status','leads.reject_reason_id',
                     'leads.location_id','leads.product_id',
                     'leads.date_of_contact','leads.referrer_id');
        
        if ($input->has('status') && $input->status!='all') {
            if ($input->has('reject_reason_id')) {
                $leads = $leads->where('status','rejected')->where('reject_reason_id',$input->reject_reason_id);
            } elseif ($input->status>0) {
                $leads = $leads->where('status','rejected')->where('reject_reason_id',$input->status);
            } else {
                $leads = $leads->where('status',$input->status);  
            }
        }

        if ($input->has('reject_reason_id')) {
            $leads = $leads->where('status','rejected')->where('reject_reason_id',$input->reject_reason_id);
        }

        if ($input->has('location') && $input->location!='all') {
            $leads = $leads->where('location_id',$input->location);
        }

        if ($input->has('start_date')) {
            $start_date = Carbon::parse($input->start_date)->format('Y-m-d');
            $leads = $leads->whereDate('date_of_contact','>=',$start_date);
        }

        if ($input->has('end_date')) {
            $end_date = Carbon::parse($input->end_date)->format('Y-m-d');
            $leads = $leads->whereMonth('date_of_contact','<=',$input->end_date);
        }

        if ($input->has('product') && $input->product!='all') {
            $leads = $leads->where('product_id',$input->product);
        }

        return $leads;
    }

    /**
     * [getStatus of all the applications status and its count]
     * @param  [type] $input [description]
     * @param  [type] $mis   [description]
     * @return [type]        [description]
     */
    public function getStatus($input,$mis,$ids)
    {
        if ($mis==null) {
            $data = $this->getLeads($input,$ids);
        } else {
            $data = $this->getApplications($input,$ids);
        }

        $application_status = $data
            ->whereNotIn('status',['disbursed','closed'])
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->orderBy('status','ASC')
            ->get();

        return $application_status;
    }

    /**
     * [getDisbursedStatus get all the disbursed & closed applications status and its count]
     * @param  [type] $input [description]
     * @param  [type] $mis   [description]
     * @return [type]        [description]
     */
    public function getDisbursedStatus($input,$mis,$ids)
    {
        if ($mis==null) {
            $data = $this->getLeads($input,$ids);
        } else {
            $data = $this->getApplications($input,$ids,$data='disbursed');
        }
        
        $application_disbursed_status = $data
            ->whereIn('status',['disbursed','closed'])
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->orderBy('status','desc')
            ->get();

        return $application_disbursed_status;
    }


    /**
     * [getLocation of all the applications and its count]
     * @param  [type] $input [description]
     * @param  [type] $mis   [description]
     * @return [type]        [description]
     */
    public function getLocation($input,$mis,$ids)
    {   
        if ($mis==null) {
            $data = $this->getLeads($input,$ids);
                $application_location = $data
                    ->join('locations', 'locations.id', '=', 'leads.location_id')
                    ->select('location_id', DB::raw('locations.name,count(*) as count'))
                    ->groupBy('location_id')
                    ->orderBy('locations.name','ASC')
                    ->get();

        } else {
            $data = $this->getApplications($input,$ids);
                $application_location = $data
                    ->join('locations', 'locations.id', '=', 'applications.location_id')
                    ->select('applications.location_id', DB::raw('locations.name,count(*) as count'))
                    ->groupBy('applications.location_id')
                    ->orderBy('locations.name','ASC')
                    ->get();
        }

        return $application_location;
    }

    /**
     * [getType of applications]
     * @param  [Request] $input
     * @param  [string] $mis   [null value]
     * @return [object]
     */
    public function getType($input,$mis,$ids)
    {
        if ($mis==null) {
            $data = $this->getLeads($input,$ids);
        } else {
            $data = $this->getApplications($input,$ids);
        }
        
        $application_types = $data
            ->select('type', DB::raw('count(*) as count'))
            ->groupBy('type')
            ->orderBy('type','ASC')
            ->get();

        return $application_types;
    }

    /**
     * [getRejectStatus list of all the rejection reasons]
     * @param  [Request] $input
     * @param  [string] $mis   [null value]
     * @return [object]
     */
    public function getRejectStatus($input,$mis,$ids)
    {
        if ($mis==null) {
            $data = $this->getLeads($input,$ids);
            $application_reject_status = $data
                ->join('rejection_reasons', 'rejection_reasons.id', '=', 'leads.reject_reason_id')
                ->select('rejection_reasons.id', DB::raw('rejection_reasons.text,count(*) as count'))
                ->groupBy('reject_reason_id')
                ->orderBy('text','ASC')
                ->get();
        } else {
            $data = $this->getApplications($input,$ids);
            $application_reject_status = $data
                ->join('rejection_reasons', 'rejection_reasons.id', '=', 'applications.rejection_reason_id')
                ->select('rejection_reasons.id', DB::raw('rejection_reasons.text,count(*) as count'))
                ->groupBy('rejection_reason_id')
                ->orderBy('text','ASC')
                ->get();
        }
                
        return $application_reject_status;
    }

    /**
     * [getFilterDropDownList]
     * @return [array]
     */
    public function getFilterDropDownList()
    {
        $locations = DB::select('SELECT * FROM locations ORDER BY `name` ASC');
        $products = DB::select('SELECT * FROM products ORDER BY `name` ASC');
        
        return ['locations'=>$locations,'products'=>$products];
    }
    
    /**
     * [summaryExport]
     * @return [array]
     */
    public function summaryExport(Request $input)
    {
        $ids = $this->getUserApplicationIds();
        $applications = $this->getApplications($input,$ids);
        $applications = $applications
            ->leftjoin('borrowers', function ($join) {
                $join->on('applications.id', '=', 'borrowers.application_id')
                     ->where('borrowers.type', '=','primary');
            })
            ->leftjoin('patients', function ($join) {
                $join->on('applications.id', '=', 'patients.application_id');
            })
            ->leftjoin('locations', function ($join) {
                $join->on('locations.id', '=', 'applications.location_id');
            })
            ->leftjoin('products', function ($join) {
                $join->on('products.id', '=', 'applications.product_id');
            })
            ->select('applications.id','applications.type',
                    'applications.cibil_score',
                    'applications.pin_number','applications.status',
                    'applications.approved_hospital_name',
                    'applications.approved_loan_amount',
                    'applications.created_at','applications.disbursement_date',
                DB::raw('borrowers.first_name,borrowers.middle_name,borrowers.last_name,borrowers.mobile_number,borrowers.alternate_number,borrowers.email'),
                DB::raw('patients.first_name as patient_first_name,patients.last_name as patient_last_name'),
                DB::raw('products.name as product'),
                DB::raw('locations.name as location'))
            ->get();

        Excel::create('MIS Report', function($excel) use ($applications) {
            $excel->sheet('Sheet1', function($sheet) use($applications) {       
                $arr1 =array();
                foreach ($applications as $key => $application) {
                    //dd($key,$value);
                     $application_data =  array(
                        $application->id,
                        $application->type,
                        $application->cibil_score,
                        $application->pin_number,
                        $application->status,
                        $application->approved_hospital_name,
                        $application->approved_loan_amount,
                        $application->created_at,
                        Carbon::parse($application->disbursement_date)->format('d-m-Y'),
                        $application->first_name,
                        $application->middle_name,
                        $application->last_name,
                        $application->mobile_number,
                        $application->alternate_number,
                        $application->email,
                        $application->location,
                        $application->product,
                        $application->patient_first_name,
                        $application->patient_last_name);
                    array_push($arr1, $application_data);
                }
                //set the titles
                $sheet->fromArray($arr1,null,'A1',false,false)->prependRow(array(
                        'Id','Type','CIBIL Score','PIN','Status','Approved Hospital Name','Approved Loan Amount','Created At','Disbursement Date','Borrower First Name','Borrower Middle Name','Borrower Last Name','Mobile Number','Alternate Number','Email-Id','Location','Product','Patient First Name','Patient Last Name'
                    )
                );
            });
        })->export('xlsx');
    }

    /**
     * [misSummaryExport]
     * @return [array]
     */
    public function misSummaryExport(Request $input)
    {
        $ids = $this->getUserLeadIds();
        $leads = $this->getLeads($input,$ids);
        $leads = $leads
            ->leftjoin('locations', function ($join) {
                $join->on('locations.id', '=', 'leads.location_id');
            })
            ->leftjoin('products', function ($join) {
                $join->on('products.id', '=', 'leads.product_id');
            })
            ->leftjoin('rejection_reasons', function ($join) {
                $join->on('rejection_reasons.id', '=', 'leads.reject_reason_id');
            })
            ->select('leads.id','leads.date_of_contact','leads.first_name','leads.middle_name','leads.last_name','leads.created_at',
                'leads.status','leads.mobile_number',
                    DB::raw('locations.name as location'),
                    DB::raw('products.name as product'),
                    DB::raw('rejection_reasons.text as reject_reason'))
            ->orderBy('leads.id', 'desc')
            ->get();

        Excel::create('MIS Lead Report', function($excel) use ($leads) {
            $excel->sheet('Sheet1', function($sheet) use($leads) {       
                $arr1 =array();
                //dd($leads);
                foreach ($leads as $key => $lead) {
                    $date_of_contact = Carbon::parse($lead->date_of_contact)->format('d-m-Y');
                    $lead_data =  array(
                        $lead->id,
                        $date_of_contact,
                        $lead->first_name.' '.$lead->middle_name.' '.$lead->last_name,
                        $lead->mobile_number,
                        $lead->location,
                        $lead->product,
                        $lead->created_at);
                    array_push($arr1, $lead_data);
                }
                //set the titles
                $sheet->fromArray($arr1,null,'A1',false,false)->prependRow(array(
                        'Id','Date of Contact','Name','Mobile Number','Location',
                        'Product','Created At'
                    )
                );
            });
        })->export('xlsx');
    }

    /**
     * [getUserApplicationIds]
     * @return [array]
     */
    public function getUserApplicationIds()
    {
        $admin = Auth::user();  
        $ids = $admin->applications->pluck('id');

        return $ids;
    }

    /**
     * [getUserApplicationIds]
     * @return [array]
     */
    public function getUserLeadIds()
    {
        $admin = Auth::user();  
        $ids = $admin->leads->pluck('id');

        return $ids;
    }
}
