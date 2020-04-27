<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-user-plus"></i><b> Patient Details</b></h3>
    </div>
    <div class="box-body capitalize-field">
        <div class="row">
            <div class="col-md-4">
                <b>Full Name</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="first_name" data-type="text" 
                        data-pk="{{$application->borrower->id}}" data-url="/admin/application/patient/edit/{{$application->id}}" data-title="Enter full-name">{{$application->patient->first_name}}
                    </a> 
                    <a href="#" class="editable-click inline-edit" data-name="middle_name" 
                        data-type="text" data-pk="{{$application->patient->id}}" data-url="/admin/application/patient/edit/{{$application->id}}" data-title="Enter middle-name">
                        {{$application->patient->middle_name}}
                    </a> 
                    <a href="#" class="editable-click inline-edit" data-name="last_name" data-type="text" 
                        data-pk="{{$application->patient->id}}" data-url="/admin/application/patient/edit/{{$application->id}}" data-title="Enter last-name">{{$application->patient->last_name}}
                    </a>
                <br>
                <b>Date Of Birth</b>:
                    <a href="#" class="datetime" data-name="date_of_birth" data-type="date" 
                        data-pk="{{$application->patient->id}}" data-url="/admin/application/patient/edit/{{$application->id}}" data-title="Select Date of Birth"> {{date('j M, Y',strtotime($application->patient->date_of_birth))}}
                    </a>
                <br>
                <b>Gender</b>: 
                    <!-- <a href="#" class="editable-click inline-edit" data-name="gender" data-type="text" 
                        data-pk="{{$application->patient->id}}" data-url="/admin/application/patient/edit/{{$application->id}}" data-title="Enter address">{{$application->patient->gender}}
                    </a> -->
                    <a href="#" class="gender editable-click" 
                        data-name="gender" 
                        data-type="select" data-pk="{{$application->patient->id}}" 
                        data-url="/admin/application/patient/edit/{{$application->id}}" 
                        sourceCache="false" 
                        data-title="Select gender">
                        {{$application->patient->gender}}
                    </a> 
                <br>
                <b>Mobile Number</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="mobile_number" 
                        data-type="text" data-pk="{{$application->patient->id}}" data-url="/admin/application/patient/edit/{{$application->id}}" data-title="Enter mobile-number">
                        {{$application->patient->mobile_number}}
                    </a>
                <br>
                <b>Marital Status </b>:
                    <a href="#" class="marital_status editable-click" 
                        data-name="marital_status" 
                        data-type="select" data-pk="{{$application->patient->id}}" 
                        data-url="/admin/application/patient/edit/{{$application->id}}"
                        sourceCache="false" 
                        data-title="Select marital status">
                        {{$application->patient->marital_status}}
                    </a>
                <br>
                <b>Treatment Type</b>: 
                    @if($application->treatment_type=="Others" ||
                    $application->treatment_type==null )
                    <a href="#" class="editable-click inline-edit" data-name="treatment_type" data-type="text" 
                        data-pk="{{$application->id}}" data-url="/admin/application/family-details/edit/{{$application->id}}" data-title="Enter treatment type">
                        {{$application->treatment_type}}
                    </a>
                    @else
                        <a href="#" class="treatment_type editable-click"
                            data-name="treatment_type" 
                            data-type="select" data-pk="{{$application->id}}" 
                            data-url="/admin/application/family-details/edit/{{$application->id}}"
                            sourceCache="false" 
                            data-title="Select treatment type">
                            {{$application->treatment_type}}
                        </a>
                    @endif
                    
                    
                <br>
                <b>Hospital Name</b>: {{$application->hospital_name}}
                    <!-- <a href="#" class="hospital_name editable-click" 
                        data-name="hospital_name" 
                        data-type="select" data-pk="{{$application->id}}" 
                        data-url="/admin/application/family-details/edit/{{$application->id}}"
                        sourceCache="false" 
                        data-title="Select Hospital">
                        {{$application->hospital_name}}
                    </a> -->
                    <!-- <a href="#" class="editable-click inline-edit" data-name="hospital_name" 
                        data-type="text" data-pk="{{$application->id}}" 
                        data-url="/admin/application/family-details/edit/{{$application->id}}" 
                        data-title="Enter hospital name">{{$application->hospital_name}}
                    </a> -->
                <br>
                <b>Loan to be disbursed to</b>: {{$application->approved_hospital_name}} <br>
            </div>
            <div class="col-md-4">
                @if($application->patient->address_line_2)
                <b>Address Line 1</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="address_line_1" 
                        data-type="text" data-pk="{{$application->patient->id}}" data-url="/admin/application/patient/edit/{{$application->id}}" data-title="Enter address line 1">
                        {{$application->patient->address_line_1}}
                    </a>
                <br>
                <b>Address Line 2</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="address_line_2" 
                        data-type="text" data-pk="{{$application->patient->id}}" data-url="/admin/application/patient/edit/{{$application->id}}" data-title="Enter address line 2">
                        {{$application->patient->address_line_2}}
                    </a>
                <br>
                @else
                <b>Address</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="address_line_1" 
                        data-type="text" data-pk="{{$application->patient->id}}" data-url="/admin/application/patient/edit/{{$application->id}}" data-title="Enter address">
                        {{$application->patient->address_line_1}}
                    </a>
                <br>
                @endif

                            
                <b>City</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="city" 
                        data-type="text" data-pk="{{$application->patient->id}}" data-url="/admin/application/patient/edit/{{$application->id}}" data-title="Enter city name">
                        {{$application->patient->city}}
                    </a>  
                <br>
                 <b>State</b>: 
                    <!-- <a href="#" class="editable-click inline-edit" data-name="state" 
                        data-type="text" data-pk="{{$application->patient->id}}" data-url="/admin/application/patient/edit/{{$application->id}}" data-title="Enter state name">
                        {{$application->patient->state}}
                    </a> -->
                    <a href="#" class="state editable-click" 
                        data-name="state" 
                        data-type="select" data-pk="{{$application->patient->id}}" 
                        data-url="/admin/application/patient/edit/{{$application->id}}" 
                        sourceCache="false" 
                        data-title="Select state">
                        {{$application->patient->state}}
                    </a>  
                <br>
                 <b>Pin Code</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="pincode" 
                        data-type="text" data-pk="{{$application->patient->id}}" data-url="/admin/application/patient/edit/{{$application->id}}" data-title="Enter pincode">
                        {{$application->patient->pincode}}
                    </a>  
                <br>
                <b>Residing Since </b>:
                    <!-- <a href="#" class="datetime" data-name="residing_since" data-type="text" 
                        data-pk="{{$application->patient->id}}" data-url="/admin/application/patient/edit/{{$application->id}}" data-title="Enter residing since in year (E.g 2010)"> 
                        {{$application->patient->residing_since}}
                    </a> -->
                    <a href="#" class="residing_since editable-click" 
                        data-name="residing_since" 
                        data-type="select" data-pk="{{$application->patient->id}}" 
                        data-url="/admin/application/patient/edit/{{$application->id}}"
                        sourceCache="false" 
                        data-title="Select residing since">
                        {{$application->patient->residing_since}}
                    </a>
                <br>
                
                
                
                
            </div>
            <div class="col-md-4">
                <b>Permanent Address</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="permanent_address" 
                        data-type="text" data-pk="{{$application->patient->id}}" data-url="/admin/application/patient/edit/{{$application->id}}" data-title="Enter permanent address">
                        {{$application->patient->permanent_address}}
                    </a>  
                <br>
                <b>Permanent City</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="permanent_city" 
                        data-type="text" data-pk="{{$application->patient->id}}" data-url="/admin/application/patient/edit/{{$application->id}}" data-title="Enter permanent city">
                        {{$application->patient->permanent_city}}
                    </a>  
                <br>
                <b>Permanent State</b>: 
                    <!-- <a href="#" class="editable-click inline-edit" data-name="permanent_state" 
                        data-type="text" data-pk="{{$application->patient->id}}" data-url="/admin/application/patient/edit/{{$application->id}}" data-title="Enter permanent state">
                        {{$application->patient->permanent_state}}
                    </a> -->
                    <a href="#" class="state editable-click" 
                        data-name="permanent_state" 
                        data-type="select" data-pk="{{$application->patient->id}}" 
                        data-url="/admin/application/patient/edit/{{$application->id}}" 
                        sourceCache="false" 
                        data-title="Select state">
                        {{$application->patient->permanent_state}}
                    </a>  
                <br>
                <b>Permanent PinCode</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="permanent_pincode" 
                        data-type="text" data-pk="{{$application->patient->id}}" data-url="/admin/application/patient/edit/{{$application->id}}" data-title="Enter permanent pincode">
                        {{$application->patient->permanent_pincode}}
                    </a>  
                <br>
               
                <b>PAN Card</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="pan_card" data-type="text" 
                        data-pk="{{$application->patient->id}}" data-url="/admin/application/patient/edit/{{$application->id}}" data-title="Enter pan_card">{{$application->patient->pan_card}}
                    </a>
                <br>
                <b>Aadhar Card</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="aadhar_card" data-type="text" 
                        data-pk="{{$application->patient->id}}" data-url="/admin/application/patient/edit/{{$application->id}}" data-title="Enter aadhar_card">{{$application->patient->aadhar_card}}
                    </a>
                <br>
                <b>Driving Id</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="driving_id" data-type="text" 
                        data-pk="{{$application->patient->id}}" data-url="/admin/application/patient/edit/{{$application->id}}" data-title="Enter driving_id">{{$application->patient->driving_id}}
                    </a>
                <br>
                <b>Voting Id</b>: 
                    <a href="#" class="editable-click inline-edit" data-name="voting_id" data-type="text" 
                        data-pk="{{$application->patient->id}}" data-url="/admin/application/patient/edit/{{$application->id}}" data-title="Enter voting_id">{{$application->patient->voting_id}}
                    </a>
                     
                
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.box-body -->
</div>
