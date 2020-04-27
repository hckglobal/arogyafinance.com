<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">
        <b>Internal Details</b></h3>
    </div>
    <div class="box-body">
        <div class="row">
        @if(Entrust::can('view-internal-notes'))    
            <div class="col-md-6">
                <h4 class="box-title"><i class="fa fa-comments-o"></i> Notes</h4>
                <div class="box box-primary direct-chat direct-chat-primary">
                    <div class="box-body">
                        @if($application->notes->count())
                            <div class="direct-chat-messages">
                                @foreach ($application->notes as $note)
                                    <div class="direct-chat-msg">
                                        <div class="direct-chat-info clearfix">
                                            <span class="direct-chat-name pull-left">{{$note->admin->first_name}} {{$note->admin->last_name}}</span>
                                            <span class="direct-chat-timestamp pull-right">{{$note->created_at}}</span>
                                        </div>
                                        <img class="direct-chat-img" src="/assets/admin/dist/img/user2-160x160.jpg" alt="message user image">
                                        <div class="direct-chat-text">
                                            {{$note->text}}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="box-footer">
                        <form action="/admin/application/{{$application->type}}/create/notes" 
                            method="post">
                            <div class="input-group">
                                <input type="hidden" value="{{csrf_token()}}" name="_token">
                                <input type="hidden" name="type" value="internal">
                                <input type="hidden" value="{{$application->id}}" name="application_id">
                                <input type="hidden" value="{{Auth::user()->id}}" name="admin_id">                                
                                <input type="text" name="text" placeholder="Enter Notes..." class="form-control">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-success btn-flat">Post</button>
                                </span>                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
        @if(Entrust::can('view-partner-notes'))    
            <div class="col-md-6">
                <h4 class="box-title"><i class="fa fa-comments-o"></i> Partner Notes</h4>
                <div class="box box-primary direct-chat direct-chat-primary">
                    <div class="box-body">
                        @if($application->partnerNotes->count())
                            <div class="direct-chat-messages">
                                @foreach ($application->partnerNotes as $note)
                                    <div class="direct-chat-msg">
                                        <div class="direct-chat-info clearfix">
                                            <span class="direct-chat-name pull-left">{{$note->admin->first_name}} {{$note->admin->last_name}}</span>
                                            <span class="direct-chat-timestamp pull-right">{{$note->created_at}}</span>
                                        </div>
                                        <img class="direct-chat-img" src="/assets/admin/dist/img/user2-160x160.jpg" alt="message user image">
                                        <div class="direct-chat-text">
                                            {{$note->text}}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="box-footer">
                        <form action="/admin/application/{{$application->type}}/create/notes" 
                            method="post">
                            <div class="input-group">
                                <input type="hidden" value="{{csrf_token()}}" name="_token">
                                <input type="hidden" name="type" value="partner">
                                <input type="hidden" value="{{$application->id}}" name="application_id">
                                <input type="hidden" value="{{Auth::user()->id}}" name="admin_id">                                
                                <input type="text" name="text" placeholder="Enter Notes..." class="form-control">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-success btn-flat">Post</button>
                                </span>                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
        </div>
        <div class="row">    
            @if(Entrust::can('view-internal-detail'))
            <div class="col-md-12">
                <h4 class="box-title"><i class="fa fa-tag"></i> Approved {{ucfirst($application->type)}} Details</h4>
                <div class="box box-primary">
                    @if(Entrust::can('update-internal-detail'))
                    <form role="form" action="/admin/application/{{$application->type}}/update/{{$application->id}}" method="post" enctype="multipart/form-data">
                    @endif
                    <div class="row">
                        <div class="col-md-6" style="border-right: 1px dotted black;">
                            @if($application->status =='disbursed' && !Entrust::can('post-disburse')|| $application->status =='sanctioned' && !Entrust::can('post-disburse') )
                                <div class="disabled">
                                    @if($application->type=="card")
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Arogya Card Number</label>
                                                <input type="text" class="form-control" @if($application->card_no) value="{{$application->card_no}}"  @endif name="card_no" placeholder="Arogya Card Number">
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Reference Number</label>
                                            <input  type="text" class="form-control change_uppercase" @if($application->pin_number) value="{{$application->pin_number}}"  @endif name="pin_number" placeholder="Reference Number">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Location </label>                                
                                            <select class="form-control" name="location_id">
                                                @foreach($locations as $location)
                                                  <option @if($application->location_id == $location->id) selected @endif value="{{$location->id}}">{{$location->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Product </label>
                                            <select class="form-control" name="product_id">
                                                @foreach($products as $product)
                                                  <option @if($application->product_id == $product->id)) selected @endif value="{{$product->id}}">{{$product->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Approved Loan</label>
                                            <input type="text" class="form-control"  @if($application->approved_loan_amount) value="{{$application->approved_loan_amount}}" @else value="{{$application->calculated_loan_amount}}"  @endif name="approved_loan_amount" placeholder="Enter Loan">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Approved Tenure</label>
                                            <input type="text" class="form-control" @if($application->approved_loan_tenure) value="{{$application->approved_loan_tenure}}"  @else value="{{$application->calculated_loan_tenure}}"  @endif name="approved_loan_tenure" placeholder="Enter Tenure">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Approved EMI</label>
                                            <input type="text" class="form-control" @if($application->approved_loan_emi) value="{{$application->approved_loan_emi}}"  @else value="{{$application->calculated_loan_emi}}"   @endif name="approved_loan_emi" placeholder="Enter Emi">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Advance EMI (Months)</label>
                                            <input type="text" class="form-control" @if($application->advance_emi) value="{{$application->advance_emi}}"  @endif name="advance_emi" placeholder="Advance EMI (Months)">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Flat Interest Rate</label>
                                            <input type="text" class="form-control" @if($application->interest_rate) value="{{$application->interest_rate}}"  @endif name="interest_rate" placeholder="Enter Interest Rate">
                                        </div>
                                    </div>
                                    @if(Entrust::can('update-disbursement-date'))
                                        <!-- <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Disbursement Date</label>
                                                <input type="text" class="form-control" 
                                                value="{{$application->disbursement_date}}"
                                                 name="disbursement_date" placeholder="Disbursement Date">
                                            </div>
                                        </div> -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Disbursement Date 
                                                </label>
                                                <div class='input-group date' id='datetimepicker-disbursement-date'>
                                                    <input type='text' class="form-control" name="disbursement_date" 
                                                    @if($application->getOriginal('disbursement_date')=="0000-00-00")
                                                    value="{{Carbon\Carbon::now()->format('d-m-Y')}}"

                                                    @else
                                                    value="{{Carbon\Carbon::parse($application->getOriginal('disbursement_date'))->format('d-m-Y')}}"
                                                    @endif
                                                    />
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Disbursement Date</label>
                                                <input type="text" class="form-control" 
                                                value="{{$application->disbursement_date}}"
                                                 name="disbursement_date" placeholder="Disbursement Date" readonly disabled="">
                                            </div>
                                        </div>
                                    @endif     
                                </div>
                            @else
                                @if($application->type=="card")
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Arogya Card Number</label>
                                            <input type="text" class="form-control" @if($application->card_no) value="{{$application->card_no}}"  @endif name="card_no" placeholder="Arogya Card Number">
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Reference Number</label>
                                        <input  type="text" class="form-control change_uppercase" @if($application->pin_number) value="{{$application->pin_number}}"  @endif name="pin_number" placeholder="Reference Number">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Location </label>                                
                                        <select class="form-control" name="location_id">
                                            @foreach($locations as $location)
                                              <option @if($application->location_id == $location->id) selected @endif value="{{$location->id}}">{{$location->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Product </label>
                                        <select class="form-control" name="product_id">
                                            @foreach($products as $product)
                                              <option @if($application->product_id == $product->id)) selected @endif value="{{$product->id}}">{{$product->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Approved Loan</label>
                                        <input type="text" class="form-control"  @if($application->approved_loan_amount) value="{{$application->approved_loan_amount}}" @else value="{{$application->calculated_loan_amount}}"  @endif name="approved_loan_amount" placeholder="Enter Loan">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Approved Tenure</label>
                                        <input type="text" class="form-control" @if($application->approved_loan_tenure) value="{{$application->approved_loan_tenure}}"  @else value="{{$application->calculated_loan_tenure}}"  @endif name="approved_loan_tenure" placeholder="Enter Tenure">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Approved EMI</label>
                                        <input type="text" class="form-control" @if($application->approved_loan_emi) value="{{$application->approved_loan_emi}}"  @else value="{{$application->calculated_loan_emi}}"   @endif name="approved_loan_emi" placeholder="Enter Emi">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Advance EMI (Months)</label>
                                        <input type="text" class="form-control" @if($application->advance_emi) value="{{$application->advance_emi}}"  @endif name="advance_emi" placeholder="Advance EMI (Months)">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Flat Interest Rate</label>
                                        <input type="text" class="form-control" @if($application->interest_rate) value="{{$application->interest_rate}}"  @endif name="interest_rate" placeholder="Enter Interest Rate">
                                    </div>
                                </div>
                                @if(Entrust::can('update-disbursement-date'))
                                    <!-- <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Disbursement Date</label>
                                            <input type="text" class="form-control" 
                                            value="{{Carbon\Carbon::parse($application->getOriginal('disbursement_date'))->format('d-m-Y')}}"
                                             name="disbursement_date" placeholder="Disbursement Date">
                                        </div>
                                    </div> -->
                                    <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Disbursement Date 
                                                </label>
                                                <div class='input-group date' id='datetimepicker-disbursement-date'>
                                                    <input type='text' class="form-control" name="disbursement_date" 
                                                    @if($application->getOriginal('disbursement_date')=="0000-00-00")
                                                    value="{{Carbon\Carbon::now()->format('d-m-Y')}}"

                                                    @else
                                                    value="{{Carbon\Carbon::parse($application->getOriginal('disbursement_date'))->format('d-m-Y')}}"
                                                    @endif
                                                    />
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                @else
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Disbursement Date</label>
                                            <input type="text" class="form-control" 
                                            value="{{Carbon\Carbon::parse($application->getOriginal('disbursement_date'))->format('d-m-Y')}}"
                                             name="disbursement_date" placeholder="Disbursement Date" readonly disabled>
                                        </div>
                                    </div>                                    
                                @endif
                            @endif
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Valid From </label>
                                    <div class='input-group date' id='datetimepicker2'>
                                        <input type='text' class="form-control" name="valid_from" 
                                        @if($application->getOriginal('valid_from')=="0000-00-00")
                                        value="{{Carbon\Carbon::now()->format('d-m-Y')}}"

                                        @else
                                        value="{{Carbon\Carbon::parse($application->getOriginal('valid_from'))->format('d-m-Y')}}"
                                        @endif
                                        />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Valid Upto</label>
                                    <input type="text" class="form-control" 
                                    @if($application->getOriginal('valid_upto')=="0000-00-00")
                                    value="{{Carbon\Carbon::now()->format('d-m-Y')}}"
                                    @else
                                    value="{{Carbon\Carbon::parse($application->getOriginal('valid_upto'))->format('d-m-Y')}}"
                                    @endif name="valid_upto" placeholder="Valid Upto" readonly>
                                </div>
                            </div>
                            
                            <div class="col-md-6">    
                                <div class="form-group">
                                    <label>FOIR</label>
                                    <input type="text" class="form-control" 
                                    value="{{$application->foir}}"
                                     name="foir" placeholder="FOIR">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Subvention (%)</label>
                                    <input type="text" class="form-control" @if($application->subvention) value="{{$application->subvention}}"  @endif name="subvention" placeholder="Enter Subvention %">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Processing Fee (%)</label>
                                    <input type="text" class="form-control" @if($application->processing_fee) value="{{$application->processing_fee}}"  @endif name="processing_fee" placeholder="Enter Processing Fee">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Processing Fee (Amount with GST)</label>
                                    <p> ₹ {{round($application->processing_fee_amount)}}</p>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Documentation charge </label>
                                    <input type="text" class="form-control" @if($application->documentation_charge) value="{{$application->documentation_charge}}"  @endif name="documentation_charge" placeholder="Enter Documentaion Charge">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Documentation charge (with GST)</label>
                                    <p> ₹ {{$application->documentation_charge_gst}}</p>
                                </div>
                            </div> 
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Hospital Name</label>
                                    <select name="hospital_name" class="form-control select2" 
                                        data-placeholder="">
                                        <option selected disabled>Select Hospital</option>
                                        @if($hospitals->contains($application->hospital_name))
                                            @foreach($hospitals as $hospital)
                                                @if($hospital->isRoot())                                            
                                                    @if($hospital->getDescendants()->count())
                                                    <optgroup label="{{$hospital->name}}">
                                                        @foreach($hospital->getDescendants() as $descendant)
                                                        <option @if($descendant->name==$application->hospital_name) selected @endif value="{{$descendant->name}}">
                                                            {{$descendant->name}}
                                                        </option>
                                                        @endforeach
                                                    </optgroup> 
                                                    @else
                                                    <option @if($hospital->name==$application->hospital_name) selected @endif
                                                        value="{{$hospital->name}}">
                                                        {{$hospital->name}}
                                                    </option>
                                                    @endif                                               
                                                @endif
                                            @endforeach
                                        @else
                                            <option selected value="{{$application->hospital_name}}">
                                                {{$application->hospital_name}}
                                            </option>
                                            @foreach($hospitals as $hospital)
                                                @if($hospital->isRoot())                                            
                                                    @if($hospital->getDescendants()->count())
                                                        <optgroup label="{{$hospital->name}}">
                                                            @foreach($hospital->getDescendants() as $descendant)
                                                            <option  value="{{$descendant->name}}">
                                                                {{$descendant->name}}
                                                            </option>
                                                            @endforeach
                                                        </optgroup> 
                                                    @else
                                                        <option 
                                                            value="{{$hospital->name}}">
                                                            {{$hospital->name}}
                                                        </option>
                                                    @endif                                               
                                                @endif
                                            @endforeach
                                        @endif                                           
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Loan to be disbursed to</label>
                                    <input type="text" class="form-control" @if($application->approved_hospital_name) value="{{$application->approved_hospital_name}}"   @else value="{{$application->hospital_name}}" @endif name="approved_hospital_name" placeholder="Hospital or Borrower Name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Bank Name</label>
                                    <input type="text" class="form-control" 
                                    value="{{$application->bank_name}}"
                                     name="bank_name" placeholder="Bank name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                <label>Bank A/c Holder Name</label>
                                    <input type="text" class="form-control"
                                    value="{{$application->bank_customer_name}}"
                                     name="bank_customer_name" placeholder="Bank a/c holder name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Bank A/c Number</label>
                                    <input type="text" class="form-control" 
                                    value="{{$application->bank_account_number}}"
                                     name="bank_account_number" placeholder="Bank a/c number">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Bank A/c Type</label>                                    
                                    <a href="#" class="bank_account_type 
                                        editable-click form-control" 
                                        data-name="bank_account_type" 
                                        data-type="select" data-pk="{{$application->id}}"
                                        data-url="/admin/application/family-details/edit/{{$application->id}}"
                                        sourceCache="false" 
                                        data-title="Select A/c Type">
                                        {{$application->bank_account_type}}
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Bank IFSC Code</label>
                                    <input type="text" class="form-control"
                                    value="{{$application->bank_ifsc_code}}"
                                     name="bank_ifsc_code" placeholder="Bank IFSC code">
                                </div>
                            </div>    
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Mode of payment</label>
                                    <!-- <input type="text" class="form-control" 
                                    value="{{$application->mode_of_payment}}"
                                     name="mode_of_payment" placeholder="Mode of payment"> -->
                                     <a href="#" class="mode_of_payment 
                                        editable-click form-control" 
                                        data-name="mode_of_payment" 
                                        data-type="select" data-pk="{{$application->id}}"
                                        data-url="/admin/application/family-details/edit/{{$application->id}}"
                                        sourceCache="false" 
                                        data-title="Select Mode of Payment">
                                        {{$application->mode_of_payment}}
                                    </a>
                                </div>
                            </div>
                        </div>    
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group" id="files">
                                    <div class="wizard-pane active" id="documents" role="tabpanel">
                                        <div class="col-md-12">
                                            <h3><i class="glyphicon glyphicon-open-file"></i>&nbsp;&nbsp;Borrower's Documents</h3>
                                        </div>    
                                        @if( !$application->hasDocument('id-proof')  )
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                <select class="form-control form-control-document" name="documents[0][name]">
                                                    <option selected="" disabled="">Select ID Proof</option>
                                                    <option value="PAN Card">PAN Card</option>
                                                    <option value="Aadhar Card">Aadhar Card</option>
                                                    <option value="Permanent Driving License">Permanent Driving License</option>
                                                    <option value="Photo Credit Card">Photo Credit Card</option>
                                                    <option value="Passport">Passport</option>
                                                    <option value="Government Employee ID Card">Government Employee ID Card</option>
                                                    <option value="Election Card">Election Card</option>
                                                    <option value="Photo Bank Passbook">Photo Bank Passbook</option>
                                                </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="hidden" multiple name="documents[0][type]" value="id-proof">
                                                <input type="file" multiple name="documents[0][files][]" id="upload1" placeholder="Upload ID Proof">
                                            </div>
                                            <div class="clearfix"></div>
                                        @endif      
                                    
                                        @if( !$application->hasDocument('address-proof') )
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                <select class="form-control form-control-document" name="documents[1][name]">
                                                    <option selected="" disabled="">Select Address Proof</option>
                                                    <option value="Ration Card">Ration Card</option>
                                                    <option value="Election/Voting Card">Election/Voting Card</option>
                                                    <option value="Electricity Bill">Electricity Bill</option>
                                                    <option value="Water Bill">Water Bill</option>
                                                    <option value="Postpaid landline phone Bill">Postpaid landline phone Bill</option>
                                                    <option value="Passport">Passport</option>
                                                    <option value="Permanent Driving License">Permanent Driving License</option>
                                                    <option value="Municipal tax Bill">Municipal tax Bill</option>
                                                    <option value="Share Certificate of Society">Share Certificate of Society</option>
                                                    <option value="House Purchase Deed">House Purchase Deed</option>
                                                    <option value="Gas Connection (only PSU)">Gas Connection (only PSU)</option>
                                                    <option value="LIC Policy">LIC Policy</option>
                                                    <option value="Bank Statement (only of scheduled/commercial banks)">Bank Statement (only of scheduled/commercial banks)</option>
                                                    <option value="Rent Agreement">Rent Agreement</option>
                                                    <option value="Employer’s certificate on letterhead">Employer’s certificate on letterhead</option>
                                                    <option value="RC Book">RC Book</option>
                                                </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="hidden" multiple name="documents[1][type]" value="address-proof">
                                                <input type="file" name="documents[1][files][]" id="upload2" placeholder="Upload Residence Proof">
                                            </div>
                                            <div class="clearfix"></div>
                                        @endif
                                        
                                        @if( !$application->hasDocument('residence-ownership-proof') && !(stripos($application->borrower->residence_type, 'owned')===false) )
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                <select class="form-control form-control-document" name="documents[2][name]">
                                                    <option selected="" disabled="">Select Residence Ownership Proof </option>
                                                    <option value="Purchase deed">Purchase deed</option>
                                                    <option value="Share certificates">Share certificates</option>
                                                    <option value="Electricity bill having ownership address">Electricity bill having ownership address</option>
                                                    <option value="Index 2">Index 2</option>
                                                    <option value="Property tax certificate">Property tax certificate</option>
                                                </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="hidden" multiple name="documents[2][type]" value="residence-ownership-proof">
                                                <input type="file" multiple name="documents[2][files][]" id="upload1" placeholder="Upload Residence Ownership Proof">
                                            </div>
                                            <div class="clearfix"></div>
                                        @endif

                                        @if( !$application->hasDocument('income-proof') )
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                <select class="form-control form-control-document" name="documents[3][name]">
                                                    <option selected="" disabled="">Select Income Proof</option>
                                                    <option disabled="">=== If Salaried (Select Any One) ===</option>
                                                    <option value="Salary Slip">Salary Slip</option>
                                                    <option value="Form 16">Form 16</option>
                                                    <option value="Letter from employer stating monthly salary">Letter from employer stating monthly salary</option>
                                                    <option value="ITR*">ITR*</option>
                                                    <option disabled="">=== Self Employeed (Select Any One) ===</option>
                                                    <option value="Latest two years ITR* (Income Tax Returns)">Latest two years ITR* (Income Tax Returns)</option>
                                                    <option value="Balance Sheet for last 2 years">Balance Sheet for last 2 years</option>
                                                    <option value="P&L Statement for last 2 years">P&amp;L Statement for last 2 years</option>
                                                    <option value="Income Computation Statement (CA attested)">Income Computation Statement (CA attested)</option>
                                                    <option value="Bank statement of last 12 months reflecting income (Rs. 10 Lacs in case of service/Rs. 20 Lacs in case of sales)">
                                                        Bank statement of last 12 months reflecting income (Rs. 10 Lacs in case of service/Rs. 20 Lacs in case of sales)</option>
                                                    <option value="Sales Tax/Service Tax Receipt or Register">Sales Tax/Service Tax Receipt or Register</option>
                                                    <option value="" disabled="">
                                                        ITR filing date should be at least 30 days prior to application or before 30th Sept
                                                    </option>
                                                    <option disabled>=== Agriculture (Select Any One) ===</option>
                                                    <option value="Mandi Receipt">Mandi Receipt</option>
                                                    <option value="Kisan Passbook">Kisan Passbook</option>
                                                    <option value="Bank Statement">Bank Statement</option>
                                                    <option value="Kisan Credit Card">Kisan Credit Card</option>
                                                    <option disabled>=== Pension ===</option>
                                                    <option value="Proof of Pension">Proof of Pension</option>
                                                </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="hidden" multiple name="documents[3][type]" value="income-proof">
                                                <input type="file" multiple name="documents[3][files][]" id="upload3" placeholder="Upload Income Proof">
                                            </div>
                                            <div class="clearfix"></div>
                                        @endif
                                    
                                        @if( !$application->hasDocument('bank-statement') )
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Upload Bank Statement : (Hold Ctrl/Cmd for multiple file upload)</label>
                                                    <input type="hidden" name="documents[4][name]" value="Bank Statement">
                                                    <input type="hidden" multiple name="documents[4][type]" value="bank-statement">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <input multiple style="display: inline;" type="file" name="documents[4][files][]" id="upload4" placeholder="Upload Bank Statement">
                                                <div class="clearfix"></div>
                                            </div>
                                        @endif

                                        @if( !$application->hasDocument('photo') )
                                        <div class="clearfix"></div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Choose Borrower Photo :</label>
                                                    <input type="hidden" name="documents[5][name]" value="Photo">
                                                    <input type="hidden" multiple name="documents[5][type]" value="photo">
                                                </div>
                                            </div>
                                            <div class="col-md-6">    
                                                <input style="display: inline;" type="file" name="documents[5][files][]" id="upload5" placeholder="Upload Photo">
                                            </div>
                                        @endif                                        
                                    </div>                            
                                    <div class="col-md-12">  
                                        <div id="add-file">
                                             <label class="cursor"><i class=" fa fa-paperclip attach-document" aria-hidden="true"></i>Attach Document </label>
                                        </div>
                                    </div>
                                </div>
                            </div>                                
                        </div>
                    </div>    
                    <div class="clearfix"></div>

                    <!-- <div class="center-block">
                        <button type="submit" class="btn btn-primary airy">Update Application Details</button>    
                    </div> -->
                    @if(Entrust::can('update-internal-detail'))
                    <div class="col-md-12 text-center"> 
                        <button type="submit" class="btn btn-primary airy">Update Application Details</button> 
                    </div>                        
                    </form>
                    @endif
                </div>
            </div>
            @endif  
        </div>
    </div>
</div>
@section('scripts')           
<script type="text/javascript">
    $(document).ready(function() {
        $('#datetimepicker2').datetimepicker({
            locale: 'en',
            format: 'DD-MM-YYYY'            
            
        });
        $('#datetimepicker-disbursement-date').datetimepicker({
            locale: 'en',
            format: 'DD-MM-YYYY'            
            
        });
        $(".select2").select2({
            tags: true
        }); 
    });
</script>
@endsection