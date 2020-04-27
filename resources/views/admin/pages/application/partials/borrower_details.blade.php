<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-user"></i> <b>Borrower Details</b></h3>
    </div>
    <!-- @foreach($application->borrowers as $key=>$borrower)
    <div>
        <div class="col-md-10">
            @if($borrower->type=="Primary")
                <h4> Borrower #{{++$key}} ({{$borrower->type}})</h4>
            @else
                <h4> Borrower #{{++$key}} 
                    (<a href="#" class="type editable-click" 
                        data-name="type" 
                        data-type="select" data-pk="{{$borrower->id}}" 
                        data-url="/admin/application/borrower/edit/{{$borrower->id}}" 
                        sourceCache="false" 
                        data-title="Select type">
                        {{$borrower->type}}
                    </a>)
                </h4>
            @endif    
        </div>
        @if($borrower->type!="Primary" && Entrust::can('remove-borrowers'))
        <div class="col-md-2 remove-borrower-custom">
            <a type="button" data-toggle="modal" data-target="#delete-borrower{{$borrower->id}}">
                <i class="fa fa-times" aria-hidden="true"></i>
            </a>
        </div>
            <div class="modal fade" id="delete-borrower{{$borrower->id}}" tabindex="-1" role="dialog" aria-labelledby="modalLabel" 
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content col-sm-12">
                        <div class="modal-header">
                            <h5 class="modal-title">Delete Borrower</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form name="repaymentForm" action="/admin/application/borrower-delete/{{$borrower->id}}"       method="GET">
                                <h6 class="modal-title">Do you want to delete {{$borrower->first_name.' '.
                                    $borrower->middle_name.' '.$borrower->last_name}} Borrower ?</h6>
                                <div class="clearfix"></div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                </div>
                           </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <div class="box-body capitalize-field">
        <div class="row">
            <div class="col-md-4">
                <b>Full Name</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="first_name"  data-type="text" 
                        data-pk="{{$borrower->id}}" data-url="/admin/application/borrower/edit/{{$borrower->id}}" data-title="Enter first name">{{$borrower->first_name}}
                    </a>
                    <a href="#" class="editable-click inline-edit" data-name="middle_name"  data-type="text" 
                        data-pk="{{$borrower->id}}" data-url="/admin/application/borrower/edit/{{$borrower->id}}" data-title="Enter middle name">{{$borrower->middle_name}}
                    </a>
                    <a href="#" class="editable-click inline-edit" data-name="last_name"  data-type="text" 
                        data-pk="{{$borrower->id}}" data-url="/admin/application/borrower/edit/{{$borrower->id}}" data-title="Enter last name">{{$borrower->last_name}}
                    </a>
                <br>
                <b>Date Of Birth</b>:
                    <a href="#" class="datetime" data-name="date_of_birth" data-type="date" 
                        data-pk="{{$borrower->id}}" data-url="/admin/application/borrower/edit/{{$borrower->id}}" 
                        data-title="Select Date of Birth"> {{date('j M, Y',strtotime($borrower->date_of_birth))}}
                    </a>
                <br>
                <b>Gender</b>: 
                    <a href="#" class="gender editable-click" 
                        data-name="gender" 
                        data-type="select" data-pk="{{$borrower->id}}" 
                        data-url="/admin/application/borrower/edit/{{$borrower->id}}" 
                        sourceCache="false" 
                        data-title="Select gender">
                        {{$borrower->gender}}
                    </a> 
                <br>
                <b>Mobile Number</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="mobile_number" 
                        data-type="text" data-pk="{{$borrower->id}}" data-url="/admin/application/borrower/edit/{{$borrower->id}}" data-title="Enter mobile number">{{$borrower->mobile_number}}
                    </a> 
                <br>
                <b>Alternate mobile number</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="alternate_number" data-type="text"    data-pk="{{$borrower->id}}" data-url="/admin/application/borrower/edit/{{$borrower->id}}"   data-title="Enter alternate number">{{$borrower->alternate_number}}
                    </a> 
                <br>
                <b>Email</b>: 
                    <a  href="#" class="editable-click inline-edit email-not" data-name="email" data-type="text"    data-pk="{{$borrower->id}}" data-url="/admin/application/borrower/edit/{{$borrower->id}}"    data-title="Enter address">{{$borrower->email}}
                    </a> 
                <br>
                <b>Marital Status</b>: 
                    <a href="#" class="marital_status editable-click" 
                        data-name="marital_status" 
                        data-type="select" data-pk="{{$borrower->id}}" 
                        data-url="/admin/application/borrower/edit/{{$borrower->id}}" 
                        sourceCache="false" 
                        data-title="Select marital status">
                        {{$borrower->marital_status}}
                    </a> 
                <br>
                <b>Relation with Patient</b>: 
                    <a href="#" class="relation_with_patient editable-click" 
                        data-name="relation_with_patient" 
                        data-type="select" data-pk="{{$borrower->id}}" 
                        data-url="/admin/application/borrower/edit/{{$borrower->id}}" 
                        sourceCache="false" 
                        data-title="Select relation status">
                        {{$borrower->relation_with_patient}}
                    </a> 
                <br>
            </div>
            <div class="col-md-4">
                <b>Address Line 1</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="address_line_1" data-type="text"      data-pk="{{$borrower->id}}" data-url="/admin/application/borrower/edit/{{$borrower->id}}"      data-title="Enter address line 1">{{$borrower->address_line_1}}
                    </a>
                <br>
                <b>Address Line 2</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="address_line_2" data-type="text"      data-pk="{{$borrower->id}}" data-url="/admin/application/borrower/edit/{{$borrower->id}}"      data-title="Enter address line 2">{{$borrower->address_line_2}}
                    </a>  
                <br>
                <b>City</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="city" data-type="text" 
                        data-pk="{{$borrower->id}}" data-url="/admin/application/borrower/edit/{{$borrower->id}}" data-title="Enter address">{{$borrower->city}}
                    </a> 
                <br>
                <b>State</b>: 
                    <a href="#" class="state editable-click" 
                        data-name="state" 
                        data-type="select" data-pk="{{$borrower->id}}" 
                        data-url="/admin/application/borrower/edit/{{$borrower->id}}" 
                        sourceCache="false" 
                        data-title="Select state">
                        {{$borrower->state}}
                    </a> 
                <br>
                <b>Pincode</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="pincode" data-type="text" 
                        data-pk="{{$borrower->id}}" data-url="/admin/application/borrower/edit/{{$borrower->id}}" data-title="Enter address">{{$borrower->pincode}}</a> 
                <br>
                <b>Residence Type</b>: 
                    <a href="#" class="residence_type editable-click" 
                        data-name="residence_type" 
                        data-type="select" data-pk="{{$borrower->id}}" 
                        data-url="/admin/application/borrower/edit/{{$borrower->id}}" 
                        sourceCache="false" 
                        data-title="Select residence type">
                        {{$borrower->residence_type}}
                    </a>
                <br>
                <b>Residing Since </b>: 
                    <a href="#" class="residing_since editable-click" 
                        data-name="residing_since" 
                        data-type="select" data-pk="{{$borrower->id}}" 
                        data-url="/admin/application/borrower/edit/{{$borrower->id}}" 
                        sourceCache="false" 
                        data-title="Select residing since">
                        {{$borrower->residing_since}}
                    </a>
                <br>
            </div>
            <div class="col-md-4">
                <b>Permanent Address</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="permanent_address" data-type="text" 
                        data-pk="{{$borrower->id}}" data-url="/admin/application/borrower/edit/{{$borrower->id}}" data-title="Enter permanent address">{{$borrower->permanent_address}}
                    </a> 
                <br>
                <b>Permanent City</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="permanent_city" data-type="text" 
                        data-pk="{{$borrower->id}}" data-url="/admin/application/borrower/edit/{{$borrower->id}}" data-title="Enter permanent address">{{$borrower->permanent_city}}
                    </a> 
                <br>
                <b>Permanent State</b>: 
                    <a href="#" class="state editable-click" 
                        data-name="permanent_state" 
                        data-type="select" data-pk="{{$borrower->id}}" 
                        data-url="/admin/application/borrower/edit/{{$borrower->id}}" 
                        sourceCache="false" 
                        data-title="Select state">
                        {{$borrower->permanent_state}}
                    </a> 
                <br>
                <b>Permanent Pincode</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="permanent_pincode" data-type="text" 
                        data-pk="{{$borrower->id}}" data-url="/admin/application/borrower/edit/{{$borrower->id}}" data-title="Enter permanent address">{{$borrower->permanent_pincode}}
                    </a> 
                <br>
                
                <b>PAN Card</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="pan_card_number" 
                        data-type="text" data-pk="{{$borrower->id}}" data-url="/admin/application/borrower/edit/{{$borrower->id}}" data-title="Enter address">{{$borrower->pan_card_number}} 
                    </a> 
                <br>
                <b>Aadhar Card</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="aadhar_card_number" 
                        data-type="text" data-pk="{{$borrower->id}}" data-url="/admin/application/borrower/edit/{{$borrower->id}}" data-title="Enter address">{{$borrower->aadhar_card_number}}
                    </a>  
                <br>
                <b>ID Proof</b>: {{$borrower->id_proof_type}} ({{$borrower->id_proof_number}})
                <br>
                
            </div>
        </div>
    </div>
    @endforeach -->
    <!-- Display Primary Borrower Detail -->
    <?php $count = 1; ?>
    <div>
        <div class="col-md-10">
            <h4> Borrower #{{$count}} ({{$application->borrower->type}})</h4>
        </div>
    </div>
    <div class="box-body capitalize-field">
        <div class="row">
            <div class="col-md-4">
                <b>Full Name</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="first_name"  data-type="text" 
                        data-pk="{{$application->borrower->id}}" data-url="/admin/application/borrower/edit/{{$application->borrower->id}}" data-title="Enter first name">{{$application->borrower->first_name}}
                    </a>
                    <a href="#" class="editable-click inline-edit" data-name="middle_name"  data-type="text" 
                        data-pk="{{$application->borrower->id}}" data-url="/admin/application/borrower/edit/{{$application->borrower->id}}" data-title="Enter middle name">{{$application->borrower->middle_name}}
                    </a>
                    <a href="#" class="editable-click inline-edit" data-name="last_name"  data-type="text" 
                        data-pk="{{$application->borrower->id}}" data-url="/admin/application/borrower/edit/{{$application->borrower->id}}" data-title="Enter last name">{{$application->borrower->last_name}}
                    </a>
                <br>
                <b>Date Of Birth</b>:
                    <a href="#" class="datetime" data-name="date_of_birth" data-type="date" 
                        data-pk="{{$application->borrower->id}}" data-url="/admin/application/borrower/edit/{{$application->borrower->id}}" 
                        data-title="Select Date of Birth"> {{date('j M, Y',strtotime($application->borrower->date_of_birth))}}
                    </a>
                <br>
                <b>Gender</b>: 
                    <a href="#" class="gender editable-click" 
                        data-name="gender" 
                        data-type="select" data-pk="{{$application->borrower->id}}" 
                        data-url="/admin/application/borrower/edit/{{$application->borrower->id}}" 
                        sourceCache="false" 
                        data-title="Select gender">
                        {{$application->borrower->gender}}
                    </a> 
                <br>
                <b>Mobile Number</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="mobile_number" 
                        data-type="text" data-pk="{{$application->borrower->id}}" data-url="/admin/application/borrower/edit/{{$application->borrower->id}}" data-title="Enter mobile number">{{$application->borrower->mobile_number}}
                    </a> 
                <br>
                <b>Alternate mobile number</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="alternate_number" data-type="text"    data-pk="{{$application->borrower->id}}" data-url="/admin/application/borrower/edit/{{$application->borrower->id}}"   data-title="Enter alternate number">{{$application->borrower->alternate_number}}
                    </a> 
                <br>
                <b>Email</b>: 
                    <a  href="#" class="editable-click inline-edit email-not" data-name="email" data-type="text"    data-pk="{{$application->borrower->id}}" data-url="/admin/application/borrower/edit/{{$application->borrower->id}}"    data-title="Enter email">{{$application->borrower->email}}
                    </a> 
                <br>
                <b>Marital Status</b>: 
                    <a href="#" class="marital_status editable-click" 
                        data-name="marital_status" 
                        data-type="select" data-pk="{{$application->borrower->id}}" 
                        data-url="/admin/application/borrower/edit/{{$application->borrower->id}}" 
                        sourceCache="false" 
                        data-title="Select marital status">
                        {{$application->borrower->marital_status}}
                    </a> 
                <br>
                <b>Borrower's Relation with Patient</b>: 
                    <a href="#" class="relation_with_patient editable-click" 
                        data-name="relation_with_patient" 
                        data-type="select" data-pk="{{$application->borrower->id}}" 
                        data-url="/admin/application/borrower/edit/{{$application->borrower->id}}" 
                        sourceCache="false" 
                        data-title="Select relation status">
                        {{$application->borrower->relation_with_patient}}
                    </a> 
                <br>
            </div>
            <div class="col-md-4">
                @if($application->borrower->address_line_2)
                <b>Address Line 1</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="address_line_1" data-type="text"      data-pk="{{$application->borrower->id}}" data-url="/admin/application/borrower/edit/{{$application->borrower->id}}"      data-title="Enter address line 1">{{$application->borrower->address_line_1}}
                    </a>
                <br>
                <b>Address Line 2</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="address_line_2" data-type="text"      data-pk="{{$application->borrower->id}}" data-url="/admin/application/borrower/edit/{{$application->borrower->id}}"      data-title="Enter address line 2">{{$application->borrower->address_line_2}}
                    </a>
                <br>
                @else
                <b>Address</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="address_line_1" data-type="text"      data-pk="{{$application->borrower->id}}" data-url="/admin/application/borrower/edit/{{$application->borrower->id}}"      data-title="Enter address">{{$application->borrower->address_line_1}}
                    </a>
                <br>
                @endif
                <b>City</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="city" data-type="text" 
                        data-pk="{{$application->borrower->id}}" data-url="/admin/application/borrower/edit/{{$application->borrower->id}}" data-title="Enter city">{{$application->borrower->city}}
                    </a> 
                <br>
                <b>State</b>: 
                    <a href="#" class="state editable-click" 
                        data-name="state" 
                        data-type="select" data-pk="{{$application->borrower->id}}" 
                        data-url="/admin/application/borrower/edit/{{$application->borrower->id}}" 
                        sourceCache="false" 
                        data-title="Select state">
                        {{$application->borrower->state}}
                    </a> 
                <br>
                <b>Pincode</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="pincode" data-type="text" 
                        data-pk="{{$application->borrower->id}}" data-url="/admin/application/borrower/edit/{{$application->borrower->id}}" data-title="Enter pincode">{{$application->borrower->pincode}}</a> 
                <br>
                <b>Residence Type</b>: 
                    <a href="#" class="residence_type editable-click" 
                        data-name="residence_type" 
                        data-type="select" data-pk="{{$application->borrower->id}}" 
                        data-url="/admin/application/borrower/edit/{{$application->borrower->id}}" 
                        sourceCache="false" 
                        data-title="Select residence type">
                        {{$application->borrower->residence_type}}
                    </a>
                <br>
                <b>Residing Since </b>: 
                    <a href="#" class="residing_since editable-click" 
                        data-name="residing_since" 
                        data-type="select" data-pk="{{$application->borrower->id}}" 
                        data-url="/admin/application/borrower/edit/{{$application->borrower->id}}" 
                        sourceCache="false" 
                        data-title="Select residing since">
                        {{$application->borrower->residing_since}}
                    </a>
                <br>
            </div>
            <div class="col-md-4">
                <b>Permanent Address</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="permanent_address" data-type="text" 
                        data-pk="{{$application->borrower->id}}" data-url="/admin/application/borrower/edit/{{$application->borrower->id}}" data-title="Enter permanent address">{{$application->borrower->permanent_address}}
                    </a> 
                <br>
                <b>Permanent City</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="permanent_city" data-type="text" 
                        data-pk="{{$application->borrower->id}}" data-url="/admin/application/borrower/edit/{{$application->borrower->id}}" data-title="Enter permanent city">{{$application->borrower->permanent_city}}
                    </a> 
                <br>
                <b>Permanent State</b>: 
                    <a href="#" class="state editable-click" 
                        data-name="permanent_state" 
                        data-type="select" data-pk="{{$application->borrower->id}}" 
                        data-url="/admin/application/borrower/edit/{{$application->borrower->id}}" 
                        sourceCache="false" 
                        data-title="Select state">
                        {{$application->borrower->permanent_state}}
                    </a> 
                <br>
                <b>Permanent Pincode</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="permanent_pincode" data-type="text" 
                        data-pk="{{$application->borrower->id}}" data-url="/admin/application/borrower/edit/{{$application->borrower->id}}" data-title="Enter permanent pincode">{{$application->borrower->permanent_pincode}}
                    </a> 
                <br>
                
                <b>PAN Card</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="pan_card_number" 
                        data-type="text" data-pk="{{$application->borrower->id}}" data-url="/admin/application/borrower/edit/{{$application->borrower->id}}" data-title="Enter PAN Card Number">{{$application->borrower->pan_card_number}} 
                    </a> 
                <br>
                <b>Aadhar Card</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="aadhar_card_number" 
                        data-type="text" data-pk="{{$application->borrower->id}}" data-url="/admin/application/borrower/edit/{{$application->borrower->id}}" data-title="Enter Aadhar Card Number">{{$application->borrower->aadhar_card_number}}
                    </a>  
                <br>
                <b>ID Proof</b>: {{$application->borrower->id_proof_type}} ({{$application->borrower->id_proof_number}})
                <br>
                
            </div>
        </div>
    </div>
    <!-- End of Display Primary Borrower Detail -->

    <!-- Display Co-Borrower Detail -->
    @foreach($application->coborrower as $key=>$borrower)
    <div>
        <div class="col-md-10">
            <h4> Borrower #{{++$count}} 
                (<a href="#" class="type editable-click" 
                    data-name="type" 
                    data-type="select" data-pk="{{$borrower->id}}" 
                    data-url="/admin/application/borrower/edit/{{$borrower->id}}" 
                    sourceCache="false" 
                    data-title="Select type">
                    {{$borrower->type}}
                </a>)
            </h4>
        </div>
        @if(Entrust::can('remove-borrowers'))
        <div class="col-md-2 remove-borrower-custom">
            <a type="button" data-toggle="modal" data-target="#delete-borrower{{$borrower->id}}">
                <i class="fa fa-times" aria-hidden="true"></i>
            </a>
        </div>
            <div class="modal fade" id="delete-borrower{{$borrower->id}}" tabindex="-1" role="dialog" aria-labelledby="modalLabel" 
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content col-sm-12">
                        <div class="modal-header">
                            <h5 class="modal-title">Delete Borrower</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form name="repaymentForm" action="/admin/application/borrower-delete/{{$borrower->id}}"       method="GET">
                                <h6 class="modal-title">Do you want to delete {{$borrower->first_name.' '.
                                    $borrower->middle_name.' '.$borrower->last_name}} Borrower ?</h6>
                                <div class="clearfix"></div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                </div>
                           </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <div class="box-body capitalize-field">
        <div class="row">
            <div class="col-md-4">
                <b>Full Name</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="first_name"  data-type="text" 
                        data-pk="{{$borrower->id}}" data-url="/admin/application/borrower/edit/{{$borrower->id}}" data-title="Enter first name">{{$borrower->first_name}}
                    </a>
                    <a href="#" class="editable-click inline-edit" data-name="middle_name"  data-type="text" 
                        data-pk="{{$borrower->id}}" data-url="/admin/application/borrower/edit/{{$borrower->id}}" data-title="Enter middle name">{{$borrower->middle_name}}
                    </a>
                    <a href="#" class="editable-click inline-edit" data-name="last_name"  data-type="text" 
                        data-pk="{{$borrower->id}}" data-url="/admin/application/borrower/edit/{{$borrower->id}}" data-title="Enter last name">{{$borrower->last_name}}
                    </a>
                <br>
                <b>Date Of Birth</b>:
                    <a href="#" class="datetime" data-name="date_of_birth" data-type="date" 
                        data-pk="{{$borrower->id}}" data-url="/admin/application/borrower/edit/{{$borrower->id}}" 
                        data-title="Select Date of Birth"> {{date('j M, Y',strtotime($borrower->date_of_birth))}}
                    </a>
                <br>
                <b>Gender</b>: 
                    <a href="#" class="gender editable-click" 
                        data-name="gender" 
                        data-type="select" data-pk="{{$borrower->id}}" 
                        data-url="/admin/application/borrower/edit/{{$borrower->id}}" 
                        sourceCache="false" 
                        data-title="Select gender">
                        {{$borrower->gender}}
                    </a> 
                <br>
                <b>Mobile Number</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="mobile_number" 
                        data-type="text" data-pk="{{$borrower->id}}" data-url="/admin/application/borrower/edit/{{$borrower->id}}" data-title="Enter mobile number">{{$borrower->mobile_number}}
                    </a> 
                <br>
                <b>Alternate mobile number</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="alternate_number" data-type="text"    data-pk="{{$borrower->id}}" data-url="/admin/application/borrower/edit/{{$borrower->id}}"   data-title="Enter alternate number">{{$borrower->alternate_number}}
                    </a> 
                <br>
                <b>Email</b>: 
                    <a  href="#" class="editable-click inline-edit email-not" data-name="email" data-type="text"    data-pk="{{$borrower->id}}" data-url="/admin/application/borrower/edit/{{$borrower->id}}"    data-title="Enter Email">{{$borrower->email}}
                    </a> 
                <br>
                <b>Marital Status</b>: 
                    <a href="#" class="marital_status editable-click" 
                        data-name="marital_status" 
                        data-type="select" data-pk="{{$borrower->id}}" 
                        data-url="/admin/application/borrower/edit/{{$borrower->id}}" 
                        sourceCache="false" 
                        data-title="Select marital status">
                        {{$borrower->marital_status}}
                    </a> 
                <br>
                <b>Borrower's Relation with Patient</b>: 
                    <a href="#" class="relation_with_patient editable-click" 
                        data-name="relation_with_patient" 
                        data-type="select" data-pk="{{$borrower->id}}" 
                        data-url="/admin/application/borrower/edit/{{$borrower->id}}" 
                        sourceCache="false" 
                        data-title="Select relation status">
                        {{$borrower->relation_with_patient}}
                    </a> 
                <br>
            </div>
            <div class="col-md-4">
                @if($borrower->address_line_2)
                <b>Address Line 1</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="address_line_1" data-type="text"      data-pk="{{$borrower->id}}" data-url="/admin/application/borrower/edit/{{$borrower->id}}"      data-title="Enter address line 1">{{$borrower->address_line_1}}
                    </a>
                <br>
                <b>Address Line 2</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="address_line_2" data-type="text"      data-pk="{{$borrower->id}}" data-url="/admin/application/borrower/edit/{{$borrower->id}}"      data-title="Enter address line 2">{{$borrower->address_line_2}}
                    </a>
                <br>
                @else
                <b>Address</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="address_line_1" data-type="text"      data-pk="{{$borrower->id}}" data-url="/admin/application/borrower/edit/{{$borrower->id}}"      data-title="Enter address">{{$borrower->address_line_1}}
                    </a>
                <br>
                @endif

                <b>City</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="city" data-type="text" 
                        data-pk="{{$borrower->id}}" data-url="/admin/application/borrower/edit/{{$borrower->id}}" data-title="Enter city">{{$borrower->city}}
                    </a> 
                <br>
                <b>State</b>: 
                    <a href="#" class="state editable-click" 
                        data-name="state" 
                        data-type="select" data-pk="{{$borrower->id}}" 
                        data-url="/admin/application/borrower/edit/{{$borrower->id}}" 
                        sourceCache="false" 
                        data-title="Select state">
                        {{$borrower->state}}
                    </a> 
                <br>
                <b>Pincode</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="pincode" data-type="text" 
                        data-pk="{{$borrower->id}}" data-url="/admin/application/borrower/edit/{{$borrower->id}}" data-title="Enter pincode">{{$borrower->pincode}}</a> 
                <br>
                <b>Residence Type</b>: 
                    <a href="#" class="residence_type editable-click" 
                        data-name="residence_type" 
                        data-type="select" data-pk="{{$borrower->id}}" 
                        data-url="/admin/application/borrower/edit/{{$borrower->id}}" 
                        sourceCache="false" 
                        data-title="Select residence type">
                        {{$borrower->residence_type}}
                    </a>
                <br>
                <b>Residing Since </b>: 
                    <a href="#" class="residing_since editable-click" 
                        data-name="residing_since" 
                        data-type="select" data-pk="{{$borrower->id}}" 
                        data-url="/admin/application/borrower/edit/{{$borrower->id}}" 
                        sourceCache="false" 
                        data-title="Select residing since">
                        {{$borrower->residing_since}}
                    </a>
                <br>
            </div>
            <div class="col-md-4">
                <b>Permanent Address</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="permanent_address" data-type="text" 
                        data-pk="{{$borrower->id}}" data-url="/admin/application/borrower/edit/{{$borrower->id}}" data-title="Enter permanent address">{{$borrower->permanent_address}}
                    </a> 
                <br>
                <b>Permanent City</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="permanent_city" data-type="text" 
                        data-pk="{{$borrower->id}}" data-url="/admin/application/borrower/edit/{{$borrower->id}}" data-title="Enter permanent city">{{$borrower->permanent_city}}
                    </a> 
                <br>
                <b>Permanent State</b>: 
                    <a href="#" class="state editable-click" 
                        data-name="permanent_state" 
                        data-type="select" data-pk="{{$borrower->id}}" 
                        data-url="/admin/application/borrower/edit/{{$borrower->id}}" 
                        sourceCache="false" 
                        data-title="Select state">
                        {{$borrower->permanent_state}}
                    </a> 
                <br>
                <b>Permanent Pincode</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="permanent_pincode" data-type="text" 
                        data-pk="{{$borrower->id}}" data-url="/admin/application/borrower/edit/{{$borrower->id}}" data-title="Enter permanent pincode">{{$borrower->permanent_pincode}}
                    </a> 
                <br>
                
                <b>PAN Card</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="pan_card_number" 
                        data-type="text" data-pk="{{$borrower->id}}" data-url="/admin/application/borrower/edit/{{$borrower->id}}" data-title="Enter PAN card number">{{$borrower->pan_card_number}} 
                    </a> 
                <br>
                <b>Aadhar Card</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="aadhar_card_number" 
                        data-type="text" data-pk="{{$borrower->id}}" data-url="/admin/application/borrower/edit/{{$borrower->id}}" data-title="Enter aadhar card number">{{$borrower->aadhar_card_number}}
                    </a>  
                <br>
                <b>ID Proof</b>: {{$borrower->id_proof_type}} ({{$borrower->id_proof_number}})
                <br>
                
            </div>
        </div>
    </div>
    @endforeach
    <!-- End of Display Co-Borrower Detail -->

    <!-- Display Guarantor Detail -->
    @foreach($application->guarantor as $key=>$borrower)
    <div>
        <div class="col-md-10">
            <h4> Borrower #{{++$count}} 
                (<a href="#" class="type editable-click" 
                    data-name="type" 
                    data-type="select" data-pk="{{$borrower->id}}" 
                    data-url="/admin/application/borrower/edit/{{$borrower->id}}" 
                    sourceCache="false" 
                    data-title="Select type">
                    {{$borrower->type}}
                </a>)
            </h4>
        </div>
        @if(Entrust::can('remove-borrowers'))
        <div class="col-md-2 remove-borrower-custom">
            <a type="button" data-toggle="modal" data-target="#delete-borrower{{$borrower->id}}">
                <i class="fa fa-times" aria-hidden="true"></i>
            </a>
        </div>
            <div class="modal fade" id="delete-borrower{{$borrower->id}}" tabindex="-1" role="dialog" aria-labelledby="modalLabel" 
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content col-sm-12">
                        <div class="modal-header">
                            <h5 class="modal-title">Delete Borrower</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form name="repaymentForm" action="/admin/application/borrower-delete/{{$borrower->id}}"       method="GET">
                                <h6 class="modal-title">Do you want to delete {{$borrower->first_name.' '.
                                    $borrower->middle_name.' '.$borrower->last_name}} Borrower ?</h6>
                                <div class="clearfix"></div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                </div>
                           </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <div class="box-body capitalize-field">
        <div class="row">
            <div class="col-md-4">
                <b>Full Name</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="first_name"  data-type="text" 
                        data-pk="{{$borrower->id}}" data-url="/admin/application/borrower/edit/{{$borrower->id}}" data-title="Enter first name">{{$borrower->first_name}}
                    </a>
                    <a href="#" class="editable-click inline-edit" data-name="middle_name"  data-type="text" 
                        data-pk="{{$borrower->id}}" data-url="/admin/application/borrower/edit/{{$borrower->id}}" data-title="Enter middle name">{{$borrower->middle_name}}
                    </a>
                    <a href="#" class="editable-click inline-edit" data-name="last_name"  data-type="text" 
                        data-pk="{{$borrower->id}}" data-url="/admin/application/borrower/edit/{{$borrower->id}}" data-title="Enter last name">{{$borrower->last_name}}
                    </a>
                <br>
                <b>Date Of Birth</b>:
                    <a href="#" class="datetime" data-name="date_of_birth" data-type="date" 
                        data-pk="{{$borrower->id}}" data-url="/admin/application/borrower/edit/{{$borrower->id}}" 
                        data-title="Select Date of Birth"> {{date('j M, Y',strtotime($borrower->date_of_birth))}}
                    </a>
                <br>
                <b>Gender</b>: 
                    <a href="#" class="gender editable-click" 
                        data-name="gender" 
                        data-type="select" data-pk="{{$borrower->id}}" 
                        data-url="/admin/application/borrower/edit/{{$borrower->id}}" 
                        sourceCache="false" 
                        data-title="Select gender">
                        {{$borrower->gender}}
                    </a> 
                <br>
                <b>Mobile Number</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="mobile_number" 
                        data-type="text" data-pk="{{$borrower->id}}" data-url="/admin/application/borrower/edit/{{$borrower->id}}" data-title="Enter mobile number">{{$borrower->mobile_number}}
                    </a> 
                <br>
                <b>Alternate mobile number</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="alternate_number" data-type="text"    data-pk="{{$borrower->id}}" data-url="/admin/application/borrower/edit/{{$borrower->id}}"   data-title="Enter alternate number">{{$borrower->alternate_number}}
                    </a> 
                <br>
                <b>Email</b>: 
                    <a  href="#" class="editable-click inline-edit email-not" data-name="email" data-type="text"    data-pk="{{$borrower->id}}" data-url="/admin/application/borrower/edit/{{$borrower->id}}"    data-title="Enter email">{{$borrower->email}}
                    </a> 
                <br>
                <b>Marital Status</b>: 
                    <a href="#" class="marital_status editable-click" 
                        data-name="marital_status" 
                        data-type="select" data-pk="{{$borrower->id}}" 
                        data-url="/admin/application/borrower/edit/{{$borrower->id}}" 
                        sourceCache="false" 
                        data-title="Select marital status">
                        {{$borrower->marital_status}}
                    </a> 
                <br>
                <b>Borrower's Relation with Patient</b>: 
                    <a href="#" class="relation_with_patient editable-click" 
                        data-name="relation_with_patient" 
                        data-type="select" data-pk="{{$borrower->id}}" 
                        data-url="/admin/application/borrower/edit/{{$borrower->id}}" 
                        sourceCache="false" 
                        data-title="Select relation status">
                        {{$borrower->relation_with_patient}}
                    </a> 
                <br>
            </div>
            <div class="col-md-4">
                @if($borrower->address_line_2)
                <b>Address Line 1</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="address_line_1" data-type="text"      data-pk="{{$borrower->id}}" data-url="/admin/application/borrower/edit/{{$borrower->id}}"      data-title="Enter address line 1">{{$borrower->address_line_1}}
                    </a>
                <br>
                <b>Address Line 2</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="address_line_2" data-type="text"      data-pk="{{$borrower->id}}" data-url="/admin/application/borrower/edit/{{$borrower->id}}"      data-title="Enter address line 2">{{$borrower->address_line_2}}
                    </a>
                <br>
                @else
                <b>Address</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="address_line_1" data-type="text"      data-pk="{{$borrower->id}}" data-url="/admin/application/borrower/edit/{{$borrower->id}}"      data-title="Enter address">{{$borrower->address_line_1}}
                    </a>
                <br>
                @endif

                
                <b>City</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="city" data-type="text" 
                        data-pk="{{$borrower->id}}" data-url="/admin/application/borrower/edit/{{$borrower->id}}" data-title="Enter city">{{$borrower->city}}
                    </a> 
                <br>
                <b>State</b>: 
                    <a href="#" class="state editable-click" 
                        data-name="state" 
                        data-type="select" data-pk="{{$borrower->id}}" 
                        data-url="/admin/application/borrower/edit/{{$borrower->id}}" 
                        sourceCache="false" 
                        data-title="Select state">
                        {{$borrower->state}}
                    </a> 
                <br>
                <b>Pincode</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="pincode" data-type="text" 
                        data-pk="{{$borrower->id}}" data-url="/admin/application/borrower/edit/{{$borrower->id}}" data-title="Enter pincode">{{$borrower->pincode}}</a> 
                <br>
                <b>Residence Type</b>: 
                    <a href="#" class="residence_type editable-click" 
                        data-name="residence_type" 
                        data-type="select" data-pk="{{$borrower->id}}" 
                        data-url="/admin/application/borrower/edit/{{$borrower->id}}" 
                        sourceCache="false" 
                        data-title="Select residence type">
                        {{$borrower->residence_type}}
                    </a>
                <br>
                <b>Residing Since </b>: 
                    <a href="#" class="residing_since editable-click" 
                        data-name="residing_since" 
                        data-type="select" data-pk="{{$borrower->id}}" 
                        data-url="/admin/application/borrower/edit/{{$borrower->id}}" 
                        sourceCache="false" 
                        data-title="Select residing since">
                        {{$borrower->residing_since}}
                    </a>
                <br>
            </div>
            <div class="col-md-4">
                <b>Permanent Address</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="permanent_address" data-type="text" 
                        data-pk="{{$borrower->id}}" data-url="/admin/application/borrower/edit/{{$borrower->id}}" data-title="Enter permanent address">{{$borrower->permanent_address}}
                    </a> 
                <br>
                <b>Permanent City</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="permanent_city" data-type="text" 
                        data-pk="{{$borrower->id}}" data-url="/admin/application/borrower/edit/{{$borrower->id}}" data-title="Enter permanent city">{{$borrower->permanent_city}}
                    </a> 
                <br>
                <b>Permanent State</b>: 
                    <a href="#" class="state editable-click" 
                        data-name="permanent_state" 
                        data-type="select" data-pk="{{$borrower->id}}" 
                        data-url="/admin/application/borrower/edit/{{$borrower->id}}" 
                        sourceCache="false" 
                        data-title="Select state">
                        {{$borrower->permanent_state}}
                    </a> 
                <br>
                <b>Permanent Pincode</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="permanent_pincode" data-type="text" 
                        data-pk="{{$borrower->id}}" data-url="/admin/application/borrower/edit/{{$borrower->id}}" data-title="Enter permanent pincode">{{$borrower->permanent_pincode}}
                    </a> 
                <br>
                
                <b>PAN Card</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="pan_card_number" 
                        data-type="text" data-pk="{{$borrower->id}}" data-url="/admin/application/borrower/edit/{{$borrower->id}}" data-title="Enter PAN card number">{{$borrower->pan_card_number}} 
                    </a> 
                <br>
                <b>Aadhar Card</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="aadhar_card_number" 
                        data-type="text" data-pk="{{$borrower->id}}" data-url="/admin/application/borrower/edit/{{$borrower->id}}" data-title="Enter aadhar card number">{{$borrower->aadhar_card_number}}
                    </a>  
                <br>
                <b>ID Proof</b>: {{$borrower->id_proof_type}} ({{$borrower->id_proof_number}})
                <br>
                
            </div>
        </div>
    </div>
    @endforeach
    <!-- End of Display Guarantor Detail -->

</div>

