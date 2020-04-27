@extends('website.app')

@section('title')
Dashboard (Apply for Loan)
@endsection

@section('styles')
<!-- boootsrap -->
<link rel="stylesheet" href="/assets/admin/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="/assets/css/form-wizard.css">
<link rel="stylesheet" href="/assets/admin/dist/css/AdminLTE.min.css">

@endsection
@section('content')

<div class="container">
    <div class="row">
        <div class="dashboard-padding">
            <!-- Side Menu -->
            @include('website.pages.dashboard.partials.side_menu')
            <!-- End Side Menu -->
            <div class="row document-upload">
                <div class="col-md-8">
                    <div class="box box-primary">
                        <div class="box-body">
                            <div class="panel-body">
                                <!-- Wizard Content -->
                                <form class="wizard-content" action="/update-patient" method="POST" id="application-loan" enctype="multipart/form-data">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <input type="hidden" name="borrower_id" value="{{$borrower->id}}">
                                    <div class="form-group">
                                        <h3><i class="glyphicon glyphicon-user"></i> Patient's Info</h3> @if(Session::has('danger'))
                                        <!-- alert -->
                                        <div class="alert alert-danger alert-dismissible">
                                            <h4><i class="icon fa fa-ban"></i> Alert!</h4> Estimated Cost is higher than Pre approved Loan Amounts. ( Your limit is ₹ {{$borrower->application->approved_loan_amount}} )
                                        </div>
                                        @endif
                                        <div class="small-box bg-green">
                                            <div class="inner">
                                                @if($application->type == "card" && $application->card_no)
                                                <p><i class="fa fa-check"></i> Pre approved Loan Amount: &#8377; {{ucfirst($application->approved_loan_amount)}}</p>
                                                @endif
                                            </div>
                                            <div class="icon">
                                                <i class="ion ion-stats-bars"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Select Patient Name</label>
                                            <select aria-label="Month" class="form-control" name="family_member_id" id="month" title="Month" v-model='patient_birthday_month'>
                                                <option selected="" disabled="">Family Members</option>
                                                <option value="self">{{$borrower->first_name}} {{$borrower->last_name}} (Self)</option>
                                                @foreach($application->familyMembers as $family)
                                                <option value="{{$family->id}}">{{$family->first_name}} {{$family->last_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="col-md-6">
                                            <label>Mobile Number*</label>
                                            <input class="form-control" type="text" name="patient_mobile_number" required placeholder="Mobile Number" aria-required="true" aria-invalid="true">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Treatment Type</label>
                                            <input type="text" class="form-control treatment_type" name="treatment_type_lac" placeholder="Treatment Type" area-required="false">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Hospital Name</label>
                                            <input type="text" name="hospital_name_lac" class="form-control hospital_name" placeholder="Hospital Name" area-required="false">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Estimated Cost*</label>
                                            <input class="form-control" type="text" name="estimated_cost" required placeholder="Estimated Cost" aria-required="true" aria-invalid="true">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Tenure in months*</label>
                                            <select name="requested_tenure" class="form-control" v-model="requested_tenure">
                                                <option selected="" disabled="">Select Tenure</option>
                                                <option value="6">6</option>
                                                <option value="12">12</option>
                                                <option value="18">18</option>
                                                <option value="24">24</option>
                                                <option value="36">36</option>
                                            </select>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="wizard-pane active" id="documents" role="tabpanel">
                                        <button type="submit" class="btn btn-primary pull-right">Submit</button>
                                    </div>
                                </form>
                                <!-- Wizard Content -->
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script type="text/javascript" src="/assets/js/formvalidation.bootstrap.min.js"></script>
<script type="text/javascript" src="/assets/js/form-wizard-config.js"></script>
@endsection
