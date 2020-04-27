@extends('admin.app')

@section('title')
 {{$title}}
@endsection

@section('styles')
<!-- DataTables -->
<link rel="stylesheet" href="/assets/admin/plugins/datatables/dataTables.bootstrap.css">
@endsection
<style type="text/css">
.box {
    margin-bottom: 0px !important;
}
.box-title {
    margin-bottom: -5px;
}
.box-header {
    padding-top: 5px !important;
    padding-bottom: 0px !important;
}
.box-body {
    padding-top: 5px !important;
    padding-bottom: 0px !important;
}
</style>
@section('active-dashboard')
class="active"
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="invoice">
            <div class="row invoice-info">
                <div class="col-xs-12">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <div class="header" align="center">
                                <img src="/assets/images/logo2.jpg">
                            </div>
                            <h3 class="box-title"><i class="fa fa-tag"></i> Application Form</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-6"><b>Application ID:</b> {{$application->id}}</div>
                                @if($application->type=="loan")
                                <div class="col-xs-6"><b>Reference Number:</b> {{$application->pin_number}}</div>
                                @else
                                 <div class="col-xs-6"><b>Arogya Card Number:</b> {{$application->card_no}}</div>
                                @endif
                                <div class="col-xs-6"><b>Reference Code:</b> {{strtoupper($application->reference_code)}}</div>
                                <div class="col-xs-6"><b>Location:</b> {{$application->location? $application->location->name : ''}}</div>
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.col -->
                </div>
                @if($application->type=="loan")
                <div class="col-xs-12">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-tag"></i> Patient Details</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                               <div class="col-xs-6"> <b>Full Name:</b> {{$application->patient->first_name}}  {{$application->patient->middle_name}} {{$application->patient->last_name}}</div>
                                <div class="col-xs-6"><b>Date Of Birth : </b>{{date('j M, Y',strtotime($application->patient->date_of_birth))}}

                                </div>
                                <div class="col-xs-6"><b>Gender:</b> {{$application->patient->gender}}</div>
                                <div class="col-xs-6"><b>Mobile Number:</b> {{$application->patient->mobile_number}}</div>
                                <div class="col-xs-6"><b>Treatment Type:</b> {{$application->treatment_type}}</div>
                                <div class="col-xs-6"><b>Estimated Cost:</b> &#8377; {{$application->estimated_cost}}</div>
                                <div class="col-xs-6"><b>Hospital Name:</b> {{$application->hospital_name}}</div>
                                <div class="col-xs-6"><b>Loan Required:</b> &#8377; {{$application->loan_required}}</div>
                                <div class="col-xs-6"><b>Loan to be disbursed to:</b> {{$application->approved_hospital_name}}</div>
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.box-body -->
                </div>
                @endif
                <div class="col-xs-12">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-tag"></i> Borrower Details</h3>
                        </div>
                        @foreach($application->borrowers as $key=>$borrower)
                        <div>
                            <div class="col-xs-12">
                                <b> Borrower #{{++$key}} ({{$borrower->type}})</b>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="col-xs-6"><b>Full Name:</b> {{$borrower->first_name}} {{$borrower->middle_name}} {{$borrower->last_name}}</div>
                                    <div class="col-xs-6"><b>Date Of Birth : </b> 
                                        {{date('j M, Y',strtotime($borrower->date_of_birth))}}
                                    </div>
                                    <div class="col-xs-6"><b>Gender:</b> {{$borrower->gender}}</div>
                                    <div class="col-xs-6"><b>Mobile Number:</b> {{$borrower->mobile_number}}</div>
                                    <div class="col-xs-6"><b>Email:</b> {{$borrower->email}}</div>
                                    @if($borrower->address_line_2)
                                    <div class="col-xs-6"><b>Address Line 1:</b> {{$borrower->address_line_1}}</div>
                                    <div class="col-xs-6"><b>Address Line 2:</b>{{$borrower->address_line_2}}</div>
                                    @else
                                    <div class="col-xs-6"><b>Address:</b> {{$borrower->address_line_1}}</div>
                                    @endif
                                    <div class="col-xs-6"><b>City:</b> {{$borrower->city}}</div>
                                    <div class="col-xs-6"><b>State:</b> {{$borrower->state}}</div>
                                    <div class="col-xs-6"><b>Pincode:</b> {{$borrower->pincode}}</div>
                                    <div class="col-xs-6"><b>Residence Type:</b> {{$borrower->residence_type}}</div>
                                    <div class="col-xs-6"><b>PAN Card:</b> {{$borrower->pan_card_number}}</div>
                                    <div class="col-xs-6"><b>Aadhar Card:</b> {{$borrower->aadhar_card_number}}</div>
                                    <div class="col-xs-6"><b>ID Proof:</b> {{$borrower->id_proof_type}} ({{$borrower->id_proof_number}})</div>
                                </div>
                            </div>
                            <!-- /.row -->
                        </div>
                        @endforeach
                        <!-- /.box-body -->
                    </div>
                </div>
                <!-- <div class="col-xs-12">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-tag"></i> Assets</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                @foreach($application->assets as $asset)
                                 <div class="col-xs-6"> &bull; {{$asset->name}} </div>
                                @endforeach
                            </div>                            
                        </div>                        
                    </div>
                </div> -->
                @if($application->type=="card")
                <div class="col-xs-12">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-tag"></i> Family Details</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                @foreach($application->familyMembers as $key=>$family)
                                <div class="col-xs-6">
                                    <b> {{++$key}}) Name:</b> {{$family->first_name}} {{$family->last_name}} ({{$family->relation}})
                                </div>
                                @endforeach
                                <div class="clearfix"></div>
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
                @endif
                <div class="col-xs-12">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-tag"></i> Financial Details</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-6"> <b>Borrower's Income:</b> &#8377; {{$application->borrower->borrowers_income}}</div>
                                <div class="col-xs-6"><b>Income as per ITR:</b> &#8377; {{$application->borrower->income_itr}}</div>
                                <div class="col-xs-6"><b>Earning Since:</b> {{$application->borrower->earning_since}}</div>
                                @if($application->other_earnings)
                                <div class="col-xs-6"><b>Other Earning Type:</b> {{$application->borrower->other_earnings_type}}</div>
                                <div class="col-xs-6"><b>Other Earnings:</b> &#8377; {{$application->borrower->other_earnings}}</div>
                                @else
                                <div class="col-xs-6"><b>Other Earnings:</b> None @endif </div>
                                    <div class="col-xs-6"><b>EMI Willing to Pay:</b> &#8377; {{$application->requested_emi}}</div>
                                    <div class="col-xs-6"><b>Requested Tenure:</b> {{$application->requested_tenure}} Months</div>
                                    <div class="col-xs-6"><b>Current Loan EMI:</b> {{ $application->borrower->current_loan_emi ? '&#8377;'.$application->current_loan_emi : 'None'}}</div>
                                    <div class="col-xs-6"><b>Education Expense:</b> {{ $application->borrower->education_expenses ? '&#8377;'.$application->education_expenses : 'None'}}</div>
                                    <div class="col-xs-6"><b>House Rent:</b> {{ $application->borrower->house_rent ?'&#8377;'. $application->house_rent : 'None'}}</div>
                                    <div class="col-xs-6"><b>Number of Dependants:</b> {{$application->borrower->number_of_dependants}}</div>
                                    <div class="col-xs-6"><b>Nature of Income:</b> {{$application->borrower->nature_of_income}}</div>
                                    <div class="col-xs-6"><b>Name of the Firm:</b> {{$application->borrower->name_of_firm}}</div>
                                    <div class="col-xs-6"><b>Type:</b> {{$application->borrower->type}}</div>
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <p style="margin-top:5px; font-size:14px; font-weight:bold;" >I hereby declare that all the information provided in this application is true to the best of my Knowledge and Belief.</p>
                    </div>

                    <div class="clearfix"></div>
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-tag"></i> Photograph and Signature</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                    @if($application->type=='loan')
                                    <div class="user-avatar col-xs-6">
                                        <b>Patient Name: {{$application->patient->first_name}} {{$application->patient->middle_name}} {{$application->patient->last_name}}</b>
                                        <img src="/assets/images/photo.png">
                                    </div>
                                    @endif

                                    <div class="user-avatar col-xs-6">
                                        <b>Borrower Name: {{$application->borrower->first_name}} {{$application->borrower->middle_name}} {{$application->borrower->last_name}}</b>
                                        <img src="/assets/images/photo.png">
                                    </div>
                                    
                                    @foreach($application->coborrower as  $coborrower)
                                    <div class="user-avatar col-xs-6">
                                        <b>Co-Borrower Name: {{$coborrower->first_name}} {{$coborrower->middle_name}} {{$coborrower->last_name}}</b>
                                        <img src="/assets/images/photo.png">
                                    </div>
                                     @endforeach

                                    @foreach($application->guarantor as  $guarantor)
                                    <div class="user-avatar col-xs-6">
                                        <b>Guarantor Name: {{$guarantor->first_name}} {{$guarantor->middle_name}} {{$guarantor->last_name}}</b>
                                        <img src="/assets/images/photo.png">
                                    </div>
                                    @endforeach                                    
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.box-body -->
                    </div>
                    
                  
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection

