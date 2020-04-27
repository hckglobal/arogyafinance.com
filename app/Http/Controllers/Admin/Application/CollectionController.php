<?php

namespace App\Http\Controllers\Admin\Application;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Note;
use Session;
use Redirect;
use Zipper;
use Carbon\Carbon;
use App\User;
use App\Application;
use PDF;
use Input;
use App\Borrower;
use App\Log;
use App\Location;
use App\Helpers\SMSProvider;
use App\Helpers\Alerts;
use Terbilang;
use App\RejectionReason;
use App\Product;
use App\Reference;
use App\Hospital;
use App\RepaymentCheque;
use App\FamilyMember;
use App\Document;
use File;
use DB;
use Excel;
use Mail;
use App\Collection;
use App\Http\Controllers\Admin\Application\RepaymentController;
use App\Jobs\UpdateAccountRepaymentSchedules;
use Illuminate\Support\Facades\Bus;
use Log as DataLog;
use App\AccountRepaymentSchedule;

class CollectionController extends Controller
{
    /**
     * Save single collection data for this application
     * @param  [int]  $application_id 
     * @param  Request $input          [form data]
     * @return \Illuminate\Http\Response
     */
    public function saveCollection(Request $input) 
    {
        $admin_id = Auth::user()->id;
        $new_value = 'Added a collection of '.$input->amount_received.' for EMI month '.$input->emi_payment_date;
        $old_value = '';
        $field = 'collection';

        Log::create(['application_id' => $input->application_id, 
                     'admin_id' => $admin_id, 'field' => $field, 
                     'old_value' => $old_value, 'new_value' => $new_value]);
    
        $collection = Collection::create($input->all());
        
        $this->updateAccountRepaymentCollectionDetail($collection->application);
        
        Session::flash('info','Collection added successfully');
        return redirect()->back();
    }

    /**
     * Save collection data for this application
     * @param  [int]  $application_id 
     * @param  Request $input          [form data]
     * @return \Illuminate\Http\Response
     */
    public function importCollectionData(Request $input)
    {   
        ini_set('max_execution_time', 1000000); 
        $error_record = collect();
        $tobe_updated = collect();
        $collection_status = collect();
        $collection_name = '';
        if ($input->hasFile('sample_file')) {
            $file = $input->file('sample_file');
            $collection_name = $file->getClientOriginalName();
            $path = $input->file('sample_file')->getRealPath();
            $data = \Excel::load($path)->get();
            $repayment_object = new RepaymentController();
            $overdue_month = Carbon::now()->format('Y-m');
            if ($data->count()>0) {
                $sheets = $data->toArray();
                $chunks = array_chunk($sheets, 100);
                foreach ($chunks as $chunk) {
                    foreach ($chunk as $row) {
                        if (isset($row['pin_number'])) {
                            $pin = preg_replace('/\s+/', '', $row['pin_number']);
                            //dd($pin);
                            $application = Application::where('pin_number',$pin)->where('type','loan')
                            ->whereIN('status',['disbursed','closed'])->first();

                            if ($application) {
                                if(strtolower($row['type'])=='emi' || strtolower($row['type'])=='bounce') {
                                    if(strtolower($row['type'])=='emi') {
                                        $collectionData = array();
                                        $collectionData['application_id'] = $application->id;
                                        $collectionData['emi_payment_date'] = Carbon::parse($row['emi_payment_date'])->format('Y-m-d');
                                        $collectionData['amount_received'] = $row['amount_received'];
                                        $collectionData['narration'] = $row['narration'];
                                        $collectionData['ref_no'] = $row['ref_no'];
                                        $collectionData['source'] = $row['source'];
                                        $collectionData['type'] = 'emi';
                                        $collectionData['transaction_number'] = $row['transaction_number'];
                                        $collection = $application->collections()
                                                        ->create($collectionData);
                                        $tobe_updated->push($application->id);
                                        $row['status'] = "Collection Updated";
                                        $row['reason'] = "-";
                                        $collection_status->push($row);
                                        //dd($collection_status);
                                    } elseif(strtolower($row['type'])=='bounce') {
                                        $collection_bounce = Collection::where('emi_payment_date', Carbon::parse($row['emi_payment_date'])->format('Y-m-d'))
                                            ->where('application_id', $application->id)
                                            ->where('transaction_number', $row['transaction_number'])
                                            ->where('type','emi')
                                            ->first();
                                        //check if bounce exists already.
                                        if($collection_bounce) {
                                            $bounced_cheque = Collection::where('emi_payment_date', Carbon::parse($row['emi_payment_date'])->format('Y-m-d'))
                                            ->where('application_id', $application->id)
                                            ->where('transaction_number',$collection_bounce->transaction_number)
                                            ->where('type','bounce')
                                            ->first();

                                            if($bounced_cheque==null) {
                                                $input->request->add(['transaction_number'=>$collection_bounce->transaction_number]);
                                                Collection::create([
                                                    'application_id' => $application->id,
                                                    'emi_payment_date' => $row['emi_payment_date'],
                                                    'amount_received' => $row['amount_received'],
                                                    'narration' => $row['narration'],
                                                    'ref_no' => $row['ref_no'],
                                                    'source' => $row['source'],
                                                    'type' => 'bounce',
                                                    'transaction_number' => $row['transaction_number']
                                                ]);
                                                
                                                $collection_bounce->bounce=1;
                                                $collection_bounce->save();
                                                //update repayment collection
                                                //$this->updateAccountRepaymentCollectionDetail($collection_bounce->application);
                                                $row['status'] = "Bounce Updated";
                                                $row['reason'] = "-";
                                                $collection_status->push($row);
                                            } else {
                                                $row['status'] = "Failed Bounce Updated";
                                                $row['reason'] = "Bounce already exist for the collection";
                                                $collection_status->push($row);
                                                $error_record->push($row);
                                            }
                                        } else {
                                            $row['status'] = "Failed Bounce Updated";
                                            $row['reason']= "Collection doesn't exist to mark it as bounce";
                                            $collection_status->push($row);
                                            $error_record->push($row);
                                        }
                                    } else {
                                        $row['status'] = "Failed Updated";
                                        $row['reason'] = "Type value is invalid";
                                        $collection_status->push($row);
                                        $error_record->push($row);
                                    }
                                } else {
                                    $row['status'] = "Failed Updated";
                                    $row['reason'] = "Type value is invalid";
                                    $collection_status->push($row);
                                    $error_record->push($row);
                                }
                                //$this->updateAccountRepaymentCollectionDetail($application);
                                //$repayment_object->getOverdueAndDPD($application, $overdue_month);
                            } else {
                                $row['status'] = "Failed Updated";
                                $row['reason'] = "Application PIN doesn't exist";
                                $collection_status->push($row);
                                $error_record->push($row);
                            }
                        }
                    } 
                }
            }
        }
        $user = Auth::user();
        if($tobe_updated->count()) {
            Bus::dispatch(new UpdateAccountRepaymentSchedules($tobe_updated,$user,$collection_name));
        }
        //dd($error_record);
        if($collection_status->count()) {
            $collection_status = $collection_status->toArray();
            $this->sendCollectionStatusToUser($user, $collection_status);
        }
        if($error_record->count()) {
            $error_record = $error_record->toArray();
            $title = 'Collection Error';
            Session::flash('info','Failed to import below collections/bounces, updating imported collection will mail you on completion,');
            //$this->sendCollectionStatusToUser($user, $error_record);
            return view ('admin.pages.application.collection_error')
                ->with(['error_record'=>$error_record,'title'=>$title]);
        } else {
            Session::flash('info','Collection update inprogress will mail you on completion,');
            return redirect()->back();
        }
    }

    /**
     * Send Collection status report to auth user.
     */
    public function sendCollectionStatusToUser($user, $collection_status)
    {
        $file = Excel::create('Collection_Status', function($excel) use ($user,$collection_status) {
            $excel->sheet('Sheet1', function($sheet) use($user,$collection_status) {
            //set the titles
            //dd($collection_status);
            $sheet->fromArray($collection_status,null,'A1',false,false)->prependRow(array('PIN','EMI Payment Date','Amount Received','Narration','Ref Number','Source','Type','Transcation No', 'Status', 'Reason'));
            });
        });
        
        Mail::send('emails.admin.collection_error_pdf', [
            'user'=>$user], function ($mail) use ($user, $file) {
                $mail->to($user->email, 'Arogya Finance')
                    ->subject('Collection Status Report')
                    ->attach($file->store("xls",false,true)['full']);     
        });
    }

    /**
     * delete the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteCollection($id)
    {
        $collection = Collection::find($id);
        //check if bounced_cheque exists
        $bounced_cheque = Collection::where('type','bounce')->where('transaction_number',$collection->transaction_number)->first();
        if($bounced_cheque) {
            $this->deleteBouncedCollection($collection->id);
        }
        $application = $collection->application;
        Collection::destroy($id);

        $this->updateAccountRepaymentCollectionDetail($application);       

        Log::store($application->id,Auth::user()->id,'collection-deleted',$collection->amount_received,0);
        Session::flash('info','Deleted successfully');
        return redirect('/admin/application/view-repayment-collections/'.$application->id);
    }

    /**
     * Update Collection Detail
     * @param  [int]  $id Collection Id
     * @return \Illuminate\Http\Response
     */
    public function updateCollection($id,Request $input)
    {
        $collection = Collection::find($id);
        $application = $collection->application;
        $application_id = $collection->application->id;
        $column_name = $input->get('name');
        // get column value
        $new_value = $input->get('value');
        // get admin id
        $admin_id = Auth::user()->id;
        // get old value 
        $old_value = $collection->{$column_name};
        $field = 'collection => '.$column_name;

        //update application 
        $collection->update([$column_name=>$new_value]);

        //log application update
        Log::create(['application_id' => $application_id, 'admin_id' => $admin_id, 'field' => $field, 
                     'old_value'=>$old_value, 'new_value' => $new_value]);

        $this->updateAccountRepaymentCollectionDetail($application);

        return redirect()->back();
    }

    public function updateAccountRepaymentDetail($id)
    {
        $collection = Collection::find($id);
        $application = $collection->application;
        $today = Carbon::now()->format('Y-m-d');

        $old_overdues = $application->accountRepaymentSchedule()->where('type','emi')->whereDate('emi_month','<',$today)->where('amount_received','<',$application->approved_loan_emi)->get();

        if($old_overdues->count()) {
            $excess = $this->updateOldOverdues($application,$old_overdues,$collection);
            if($excess>0) {
                $remaining_repayments = $application->accountRepaymentSchedule()
                    ->where('type','emi')
                    ->whereDate('emi_month','>=',$today)
                    ->where('amount_received','<',$application->approved_loan_emi)->get();
                $over_excess =$this->updateExcessAmount($application,$remaining_repayments,$excess,$collection);    
            }
        } else {
            $remaining_repayments = $application->accountRepaymentSchedule()
                ->where('type','emi')
                ->whereDate('emi_month','>=',$today)
                ->where('amount_received','<',$application->approved_loan_emi)->get();
            $excess = $collection->amount_received+$remaining_repayments->sum('amount_received');
            $over_excess =$this->updateExcessAmount($application,$remaining_repayments,$excess,$collection);
        }
    }

    public function updateOldOverdues($application,$old_overdues,$collection)
    {
        $today = Carbon::now()->format('Y-m-d');
        $total_collection = $collection->amount_received;
        $emi_per_month = $application->approved_loan_emi;
        $collection_detail = collect();
        $excess = 0;
        $balance = 0;
        $count = $old_overdues->count();

        foreach ($old_overdues as $old_overdue) {
            /*if($total_collection>$emi_per_month) {
                    $balance = ($total_collection-$emi_per_month);
                    $this_month_emi = $emi_per_month;
                    $old_overdue->amount_received = $this_month_emi;
                    $old_overdue->emi_payment_date = $collection->emi_payment_date;
                    $old_overdue->delay_charges = $this->getDelayDetails($old_overdue,$this_month_emi,$collection->emi_payment_date);
                    $old_overdue->save();
                    DataLog::info('1-delay charges for '.$old_overdue->emi_month.' to '.$collection->emi_payment_date.' on '.$this_month_emi.' is '.$old_overdue->delay_charges);
                    $count--;
                    if($count<=0){
                        $excess = $balance;
                    }
            } else {*/
                $sum = $old_overdue->amount_received+$total_collection;
                
                if($sum>$old_overdue->emi) {
                    $total_collection = $sum;
                    $balance = ($total_collection-$emi_per_month);
                    $this_month_emi = $emi_per_month;
                    $previous_amount = $old_overdue->amount_received;
                    $old_overdue->emi_payment_date = $collection->emi_payment_date;
                    if($old_overdue->amount_received==$old_overdue->emi) {
                        $old_overdue->delay_charges = $this->getDelayDetails($old_overdue,$this_month_emi,$collection->emi_payment_date);
                    } else {
                        $old_overdue->delay_charges = $this->getDelayDetails($old_overdue,$this_month_emi-$previous_amount,$collection->emi_payment_date);

                    }
                    $old_overdue->amount_received = $this_month_emi;
                    $old_overdue->save();
                    DataLog::info('2-delay charges for '.$old_overdue->emi_month.' to '.$collection->emi_payment_date.'on '.$this_month_emi.' is '.$old_overdue->delay_charges);
                    $count--;
                    if($count<=0){
                        $excess = $balance;
                    }
                } else {
                    $old_overdue->amount_received += $total_collection;
                    $old_overdue->emi_payment_date = $collection->emi_payment_date;
                    $old_overdue->delay_charges = $this->getDelayDetails($old_overdue,$total_collection,$collection->emi_payment_date);
                    $old_overdue->save();
                    DataLog::info('3-delay charges for '.$old_overdue->emi_month.' to '.$collection->emi_payment_date.'on '.$total_collection.' is '.$old_overdue->delay_charges);
                    $total_collection -=$total_collection;
                    break;
                }                
            /*}*/            
            $total_collection = $balance;
            //DataLog::info('total_collection - '.$total_collection);
        }
        //DataLog::info('excess - '.$excess);
        return $excess;
    }

    public function updateExcessAmount($application,$remaining_repayments,$excess,
        $collection)
    {
        if($excess>0) {
            $total_collection = $excess;
            $emi_per_month = $application->approved_loan_emi;
            $collection_detail = collect();
            $excess = 0;
            $balance = 0;
            $count = $remaining_repayments->count();
            foreach ($remaining_repayments as $remaining_repayment) {
                if($total_collection>$remaining_repayment->emi) {
                    for ($i=0; $i <= $count ; $i++) {
                        $balance = ($total_collection-$emi_per_month);
                        $this_month_emi = $emi_per_month;
                        $remaining_repayment->amount_received = $this_month_emi;
                        $remaining_repayment->emi_payment_date = $collection->emi_payment_date;
                        $remaining_repayment->delay_charges = $this->getDelayDetails($remaining_repayment,$this_month_emi,$collection->emi_payment_date);
                        $remaining_repayment->save();
                        if($i==$count){
                            $excess = $balance;
                        }
                    }
                } else {
                    $remaining_repayment->amount_received = $total_collection;
                    $remaining_repayment->emi_payment_date = $collection->emi_payment_date;
                    $remaining_repayment->delay_charges = $this->getDelayDetails($remaining_repayment,$total_collection,$collection->emi_payment_date);
                    $remaining_repayment->save();
                    break;
                }
                $total_collection = $balance;  
            }  
            
            return $excess;
        }
    }

    /**
     * Update a/c repayment collection data
     */
    public function updateAccountRepaymentCollectionDetail($application)
    {
        $collections = $application->collections()->accountCollection()->get()->where('type','emi')->sortBy('emi_payment_date');
        $advance_emi_collection = $application->collections()->accountCollection()->get()->where('type','advance_emi')->first();
        if($advance_emi_collection) {
            $application->accountRepaymentSchedule()->where('type','advance_emi')
                ->update(['amount_received'=>$advance_emi_collection->amount_received,
                          'emi_payment_date'=>$advance_emi_collection->emi_payment_date]);
        }
        $application->accountRepaymentSchedule()->where('type','emi')->update(['amount_received'=>0,'emi_payment_date'=>null,'delay_charges'=>0]);

        foreach ($collections as $collection_data) {
            $this->updateAccountRepaymentDetail($collection_data->id);
        }
    }

    public function getDelayDetails($repayment,$amount_received,$payment_date)
    {
        $charges=$repayment->delay_charges;            
        
        if($payment_date>=$repayment->emi_month) {
            $closure_days_difference = Carbon::parse($repayment->emi_month)->diffInDays($payment_date);
            $no_to_days = ($closure_days_difference/365);
            $charges += round($no_to_days*(0.18*$amount_received),2);
            //DataLog::info('delay charges for '.$payment_date.' to '.$repayment->emi_month.' is '.$charges.' on '.$amount_received);
        } else {
            $charges +=0;
            //DataLog::info('delay charges for '.$payment_date.' to '.$repayment->emi_month.' is '.$charges.' on '.$amount_received);

        }

        $repayment->delay_charges=$charges;
        $repayment->save();

        return $charges;
    }

    /**
     * mark collection as bounce
     * @param  [int]  $collection id 
     * @param  Request $input          [form data]
     * @return \Illuminate\Http\Response
     */
    public function markBounce($id, Request $input)
    {
        $collection = Collection::find($id);
        $title = "Cheque Bounce";
        return view('admin.pages.application.collection_bounce', 
            ['title'=>$title, 'collection'=>$collection]
        );
    }

    /**
     * mark collection as bounce
     * @param  [int]  $collection id 
     * @param  Request $input          [form data]
     * @return \Illuminate\Http\Response
     */
    public function collectionBounce($id,Request $input) 
    {
        
        $collection_bounce = Collection::find($id);    
        //check if bounce exists already.
        $bounced_cheque = Collection::where('type','bounce')->where('transaction_number',$collection_bounce->transaction_number)->first();
        if(!$bounced_cheque) {
            if($collection_bounce->transaction_number==null) {
                $input->request->add(['transaction_number'=>null]);
            }
            Collection::create($input->all());
            
            $collection_bounce->bounce=1;
            $collection_bounce->save();
            //update repayment collection
            $this->updateAccountRepaymentCollectionDetail($collection_bounce->application);

            $admin_id = Auth::user()->id;
            $new_value = 'Added cheque bounce for collection '.$collection_bounce->narration.' for EMI month '.$collection_bounce->emi_payment_date;
            
            $old_value = '';
            $field = 'collection-bounce';

            Log::create(['application_id' => $input->application_id, 
                         'admin_id' => $admin_id, 'field' => $field, 
                         'old_value' => $old_value, 'new_value' => $new_value]);

            Session::flash('info','Collection bounce added successfully');
            return redirect('/admin/application/view-repayment-collections/'.$input->application_id);
        } else {
            Session::flash('info','Collection bounce already exists');
            return redirect('/admin/application/view-repayment-collections/'.$input->application_id);

        }
    }

    public function viewCollectionBounce($id)
    {
        $title = "Cheque Bounce";
        $collection = Collection::find($id);
        $bounce = Collection::where('transaction_number',$collection->transaction_number)->where('application_id',$collection->application_id)->where('type','bounce')->first();

        return view('admin.pages.application.collection_bounce_detail', 
            ['title'=>$title, 'collection'=>$collection, 'bounce'=>$bounce]
        );
    }

    /**
     * delete bounced collection
     * @param  [int]  $collection id 
     * @param  Request $input          [form data]
     * @return \Illuminate\Http\Response
     */
    public function deleteBouncedCollection($id) 
    {
        $collection = Collection::find($id);

        if($collection->type=="emi") {
            $bounced_collection = Collection::where('transaction_number',$collection->transaction_number)->where('type','bounce')->first();
            $bounced_collection->delete();
            //dd($bounced_collection);
            $collection->bounce=0;
            $collection->save();

            $admin_id = Auth::user()->id;
            $new_value = 'Deleted cheque bounce for collection '.$collection->narration.' for EMI month '.$collection->emi_payment_date;
            $old_value = '';
            $field = 'collection-bounce';

            Log::create(['application_id' => $collection->application->id, 
                         'admin_id' => $admin_id, 'field' => $field, 
                         'old_value' => $old_value, 'new_value' => $new_value]);
            //update repayment collection
            $this->updateAccountRepaymentCollectionDetail($collection->application);

        } else {
            //log deletion action
            $admin_id = Auth::user()->id;
            $application_id= $collection->application->id;
            $new_value = 'Deleted cheque bounce for collection '.$collection->narration.' for EMI month '.$collection->emi_payment_date;
            $old_value = '';
            $field = 'collection-bounce';
            //delete cheque bounce
            $collection->delete();            
            
            //log deletion action
            Log::create(['application_id' => $application_id, 
                         'admin_id' => $admin_id, 'field' => $field, 
                         'old_value' => $old_value, 'new_value' => $new_value]);
        }

        Session::flash('info','Bouced Collection deleted successfully');
        return redirect()->back();
    }

    /**
     * add no. of cheque bounce
     * @param  [int]  $collection id 
     * @param  Request $input          [form data]
     * @return \Illuminate\Http\Response
     */
    public function addNoOfChequeBounce($id,Request $input) 
    {
        
        $application = Application::find($id);
        $input->request->add([
            'transaction_number'=>null,
            'application_id'=>$application->id,
            'type'=>'bounce',
            'amount_received'=>-0.0,
        ]);
        if($input->no_of_cheque_bounce>0 && $input->no_of_cheque_bounce<=100) {
            $first_repayment = $application->accountRepaymentSchedule->first();
            for ($i=1; $i <= $input->no_of_cheque_bounce; $i++) { 
                $input->request->add([
                    'narration'=>'Cheque Bounce - '.$i,
                    'emi_payment_date'=>$first_repayment->emi_month
                ]);
                Collection::create($input->all());
            }
            $admin_id = Auth::user()->id;
            $new_value = 'Added '.$input->no_of_cheque_bounce.' cheque bounce '.$input->amount_received.' for EMI month '.$input->emi_payment_date;
            $old_value = '';
            $field = 'collection-bounce';

            Log::create(['application_id' => $application->id, 
                         'admin_id' => $admin_id, 'field' => $field, 
                         'old_value' => $old_value, 'new_value' => $new_value]);
        } else {
            Session::flash('info','Please select a valid no. of cheque bounce');
            return redirect('/admin/application/closure-status/'.$application->id);
        }
     
        Session::flash('info','Cheque bounce added successfully');
        return redirect('/admin/application/closure-status/'.$application->id);
    }

    public function viewAllChequeBounce($id)
    {
        $title = "Cheque Bounce";
        $application = Application::find($id);
        $collection = $application->collections()->bounce()->get();
        return view('admin.pages.application.all_cheque_bounce_detail', 
            ['title'=>$title, 'collection'=>$collection]
        );
    }

    /**
     * save loan closure collection to system.
     * @param Object of Input class $input
    */
    public function saveClosureCollection(Request $input)
    {   //dd($input->all());
        //get application
        $application = Application::find($input->application_id);

        // add closure amount to collection
        $this->addClosureCollectionDetail($application, $input);

        $this->updateAccountRepayment($application, $input);

        Session::flash('info','Closure amount added successfully');
        return redirect()->back();
    }

    /**
     * add closure collection detail into system.
     * @param Object of Application class $application
     * @param Object of Input class $input
     * @return \Illuminate\Http\Response
    */
    public function addClosureCollectionDetail($application, $input)
    {
        $data = [
            'application_id' => $input->application_id,
            'emi_payment_date' => Carbon::parse($input->emi_payment_date)->format('Y-m-d'),
            'amount_received' => $input->amount_received,
            'narration' => $input->narration,
            'ref_no' => $input->ref_no,
            'source' => $input->source,
            'type' => 'emi',
            'transaction_number' => $input->transaction_number
        ];

        $collection = Collection::create($data);

        if($collection) {
            $admin_id = Auth::user()->id;
            $new_value = 'Added a closure collection of '.$input->amount_received.' for EMI month '.$input->emi_payment_date;
            $old_value = '';
            $field = 'collection';

            Log::create(['application_id' => $input->application_id, 
                'admin_id' => $admin_id, 'field' => $field, 
                'old_value' => $old_value, 'new_value' => $new_value
            ]);
        }
    }

    /**
     * Update a/c repayment collection data based on closure amount
     */
    public function updateAccountRepayment($application, $input)
    {
        $collections = $application->collections()->accountCollection()->get()->where('type','emi')->sortBy('emi_payment_date');
        $advance_emi_collection = $application->collections()->accountCollection()->get()->where('type','advance_emi')->first();
        if($advance_emi_collection) {
            $application->accountRepaymentSchedule()->where('type','advance_emi')
                ->update(['amount_received'=>$advance_emi_collection->amount_received,
                          'emi_payment_date'=>$advance_emi_collection->emi_payment_date]);
        }
        $application->accountRepaymentSchedule()->where('type','emi')->update(['amount_received'=>0,'emi_payment_date'=>null,'delay_charges'=>0]);

        foreach ($collections as $collection_data) {
            $this->updateACRepaymentDetail($collection_data->id, $input);
        }
    }

    public function updateACRepaymentDetail($id, $input)
    {
        $collection = Collection::find($id);
        $application = $collection->application;
        $today = Carbon::parse($input->emi_payment_date)->format('Y-m-d');

        $old_overdues = $application->accountRepaymentSchedule()->where('type','emi')->whereDate('emi_month','<',$today)->where('amount_received','<',$application->approved_loan_emi)->get();

        if($old_overdues->count()) {
            $excess = $this->updateOldOverdues($application,$old_overdues,$collection);
            if($excess>0) {
                $remaining_repayments = $application->accountRepaymentSchedule()
                    ->where('type','emi')
                    ->whereDate('emi_month','>=',$today)
                    ->where('amount_received','<',$application->approved_loan_emi)->first();
                $over_excess =$this->updateExcessClosureAmount($application,$remaining_repayments,$excess,$collection,$input);           
            }
        }
    }

    /**
     * 
    */
    public function updateExcessClosureAmount($application,$remaining_repayments,$excess, $collection, $input)
    {
        if($excess>0) {
            $total_collection = $excess;
            $emi_per_month = $application->approved_loan_emi;
            $collection_detail = collect();
            $excess = 0;
            $balance = 0;
            //dd($remaining_repayments,$total_collection);
            if($total_collection>$remaining_repayments->emi) {
                $balance = ($total_collection-$emi_per_month);
                $this_month_emi = $emi_per_month;
                $remaining_repayments->amount_received = $this_month_emi;
                $remaining_repayments->emi_payment_date = $collection->emi_payment_date;
                $remaining_repayments->delay_charges = $this->getDelayDetails($remaining_repayments,$this_month_emi,$collection->emi_payment_date);
                $principal_adjustment_amount = $balance;
                $old_value = $remaining_repayments->principal_adjustment_amount;
                $remaining_repayments->principal_adjustment_amount = $principal_adjustment_amount;
                $remaining_repayments->save();

                // Create Log
                $admin_id = Auth::user()->id;
                
                $new_value = 'Added principal adjustment of '.$balance.' for EMI month '.$remaining_repayments->emi_month;
                
                
                $field = 'principal adjustment->'.$remaining_repayments->id;
                
                Log::create(['application_id' => $application->id, 
                    'admin_id' => $admin_id, 'field' => $field, 'old_value' => $old_value,
                    'new_value' => $new_value]);
                
                //Update A/c Repayment Schedule
                $application->updateRepaymentSchedule();
                //get updated outstanding principal
                $remaining_repayment = AccountRepaymentSchedule::find($remaining_repayments->id);
                $outstanding_amount = $remaining_repayment->outstanding_principal;
                //echo "OS ".$outstanding_amount.'<br>';
                //deduct the dishonor charges
                $balance = abs($outstanding_amount) - $input->dishonor_charges;
                //echo "dishonor deduct ".$balance.'<br>';

                //deduct the late-payment charges
                $balance = $balance - $input->late_payment_charges;
                //echo "late-payment deduct ".$balance.'<br>';

                //deduct the legal off amount
                $balance = round($balance - $input->legal_charges,2);
                //echo "legal charges - ".$balance.'<br>';

                //deduct the pre-payment charges
                $balance = $balance - $input->pre_payment_charges;
                //echo "pre-payment deduct ".$balance.'<br>';

                //deduct the wavier off amount
                $balance = round($balance + $input->wavied_off,2);
                //echo "wavier off - ".$balance.'<br>';
                
                $application->applicationClosure()->updateOrCreate([
                    'application_id' => $application->id,
                    'closure_amount' => $input->amount_received,
                    'closure_date' => Carbon::parse($input->emi_payment_date)->format('Y-m-d'),
                    'overdue_amount' => $input->overdue,
                    'principal_outstanding' => $input->outstanding_principal,
                    'adjusted_principal' => $principal_adjustment_amount,
                    'adjusted_outstanding_principal' => $outstanding_amount,
                    'adjusted_dishonor' => $input->dishonor_charges,
                    'adjusted_late_payment' => $input->late_payment_charges,
                    'adjusted_legal' => $input->legal_charges,
                    'adjusted_pre_payment' => $input->pre_payment_charges,
                    'adjusted_waived_off' => $input->wavied_off
                ]);

            } else {
                $remaining_repayments->amount_received = $total_collection;
                $remaining_repayments->emi_payment_date = $collection->emi_payment_date;
                $remaining_repayments->delay_charges = $this->getDelayDetails($remaining_repayments,$total_collection,$collection->emi_payment_date);
                $remaining_repayments->save();
            }
            $total_collection = $balance;  
            
            return $excess;
        }
    }
}