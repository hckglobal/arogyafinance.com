@extends('admin.app')



@section('title') 

Dashboard- Admin | Arogya Finance

@endsection



@section('styles')

<!-- DataTables -->

<link rel="stylesheet" href="/assets/admin/plugins/datatables/dataTables.bootstrap.css">

@endsection



@section('active-dashboard')

class="active"

@endsection





@section('content')


<!-- Content Wrapper. Contains page content -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('admin.partials.content-header')
    <!-- <section class="content-header">
        <h1>
    
              Application Id:
              <big>#{{$form->user->id}} | Type: {{$form->form_type}} | Category: {{$form->category}}</big>
              @if($form->approval=="approved")
              <h4>Form Status:{{$form->approval}}</h4>
              @endif
    
          </h1>
        <ol class="breadcrumb">
            <li class="active">Application Id</li>
        </ol>
    </section> -->
    <!-- Main content -->
    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">

                <i class="fa fa-globe"></i> Arogya Finance

                <small class="pull-right">Date: {{$form->user->created_at->toDayDateTimeString()}}</small>

              </h2>
            </div>
            <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
            <div class="col-sm-4">
                <div class="user-photo">
                    <span class="text-left">From</span>
                    <img src="/documents/photos/{{$form->photo}}" alt="User Photo">
                </div>
            </div>
            <div class="col-sm-4 invoice-col">
                <address>
                    <br>
                    <strong>{{$form->user->first_name}} {{$form->user->last_name}}</strong>
                    <br> {{$form->user->address1}},
                    <br> {{$form->user->address2}},
                    <br> {{$form->user->city}},
                    <br> {{$form->user->state}}
                    <br> Email: {{$form->user->email}}
                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        <br>
        <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-tag"></i> Borrower Details</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-4">
                  <b>Full Name</b> : {{$form->user->first_name}} {{$form->user->middle_name}} {{$form->user->last_name}} <br>
                  <b>Email</b> : {{$form->user->email}} <br> 
                  <b>Address :</b> {{$form->user->address1}},{{$form->user->address2}} <br>
                  <b>Pincode :</b> {{$form->user->pincode}} <br>
                </div>
                <div class="col-md-4">
                   <b>Gender</b> : {{$form->user->gender}} <br>
                   <b>Id Proof</b> : {{$form->user->id_proof_type}} ({{$form->user->id_proof_number}})<br>
                   <b>City :</b> {{$form->user->city}} <br>
                </div>
                <div class="col-md-4">
                  <b>Mobile Number</b> : {{$form->user->mobile_number}} <br>
                  <b>Date Of Birth</b> : {{$form->user->date_of_birth->toFormattedDateString()}} <br> 
                  <b>Residence Type</b> : {{$form->user->residence_type}} <br>
                  <b>State :</b> {{$form->user->state}} <br>
                </div>
              </div><!-- /.row -->
            </div><!-- /.box-body -->
          </div>
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-tag"></i> Patient Details</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <b>Full Name</b> : {{$form->first_name_patient}} {{$form->middle_name_patient}} {{$form->last_name_patient}}<br>
                        <b>Date Of Birth</b> : {{$form->date_of_birth_patient->toFormattedDateString()}}<br>
                        <b>Mobile Number</b> : {{$form->patient_mobile_number}}<br>
                        
                    </div>
                    <div class="col-md-4">
                      <b>Treatment Type</b> : {{$form->treatment_type}}<br>
                        <b>Estimated Cost</b> :  &#8377;{{$form->estimate_cost}}<br>
                        <b>Loan Required</b> :  &#8377;{{$form->loan_required}}<br>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.box-body -->
        </div>
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-tag"></i> Assets</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <ul>
                        @foreach($form->assets as $asset)
                        <li>{{$asset->name}}</li>
                        @endforeach
                    </ul>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.box-body -->
        </div>
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-tag"></i> Financial Details</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <b>Borrower's Income</b> : &#8377;{{$form->borrowers_income}}
                        <br>
                        <b>Income as per ITR</b> : &#8377;{{$form->income_itr}}
                        <br>
                        <b>Earning Since</b> : {{$form->earning_since}}
                        <br> @if($form->other_earnings)
                        <b>Other Earning Type:</b> {{$form->other_earnings_type}}
                        <br>
                        <b>Other Earning :</b> &#8377;{{$form->other_earnings}}
                        <br> @else
                        <b>Other Earning :</b> None
                        <br> @endif
                        <b>Montly EMI Possible</b> : &#8377;{{$form->monthly_emi_possible}}
                        <br>
                    </div>
                    <div class="col-md-4">
                        <b>Current Loan EMI</b> : {{ $form->current_loan_emi ? '&#8377;'.$form->current_loan_emi : 'None'}}
                        <br>
                        <b>Education Expense</b> : {{ $form->education_expenses ? '&#8377;'.$form->education_expenses : 'None'}}
                        <br>
                        <b>House Rent :</b> {{ $form->house_rent ?'&#8377;'. $form->house_rent : 'None'}}
                        <br>
                        <b>Number Of Dependants :</b> {{$form->number_of_dependants}}
                        <br>
                    </div>
                    <div class="col-md-4">
                        <b>Nature Of Income</b> : {{$form->nature_of_income}}
                        <br>
                        <b>Name Of The Firm :</b> {{$form->name_of_firm}}
                        <br>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.box-body -->
        </div>
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-tag"></i> Calculated Financial Details</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <b>Total Borrower's Income</b> : &#8377;{{$form->total_borrowers_income}}
                        <br>
                        <b>Calculated Montly Income</b> : &#8377;{{$form->calculated_income}}
                        <br>
                    </div>
                    <div class="col-md-4">
                        <b>Calculated Loan Amount</b> : &#8377;{{$form->approved_loan_amount}}
                        <br>
                        <b>Calculated Loan EMI</b> : &#8377;{{$form->approved_loan_emi}}
                        <br>
                        <b>Calculated Loan Tenure :</b> {{$form->approved_loan_tenure}} Months (Requested : {{$form->requested_tenure}} Months)
                        <br>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.box-body -->
        </div>
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-tag"></i> Documents</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <div style="margin-bottom: 15px;">
                            <b>Id Proof</b>
                            <br> Document Type : {{$form->id_proof}}
                            <br>
                            <a href="/documents/{{$form->id_proof_doc}}">
                                <button class="btn btn-primary"><i class="fa fa-download"></i> Download </button>
                            </a>
                            <br>
                        </div>
                        <div style="margin-bottom: 15px;">
                            <b>Bank Statement</b>
                            <br> Document Type : {{$form->bank_statement}}
                            <br>
                            <a href="/documents/{{$form->bank_statement_doc}}">
                                <button class="btn btn-primary"><i class="fa fa-download"></i> Download </button>
                            </a>
                            <br>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div style="margin-bottom: 15px;">
                            <b>Residence Proof</b>
                            <br> Document Type : {{$form->residence_proof}}
                            <br>
                            <a href="/documents/{{$form->residence_proof_doc}}">
                                <button class="btn btn-primary"><i class="fa fa-download"></i> Download </button>
                            </a>
                            <br>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div style="margin-bottom: 15px;">
                            <b>Income Proof</b>
                            <br> Document Type : {{$form->income_proof}}
                            <br>
                            <a href="/documents/{{$form->income_proof_doc}}">
                                <button class="btn btn-primary"><i class="fa fa-download"></i> Download </button>
                            </a>
                            <br>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.box-body -->
        </div>
        @if($form->cibil_score==0)
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-tag"></i> Update Cibil</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <form action="/admin/form/update/{{$form->id}}" method="POST">
                        <input type="hidden" name="_token" value="{{csrf_token()}}"> Cibil Score: &nbsp;
                        <input type="text" name="cibil_score" placeholder="Cibil Score"> &nbsp;
                        <button class="btn btn-primary" type="submit" style="margin-right: 5px;"><i class="fa fa-download"></i> Update</button>
                    </form>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.box-body -->
        </div>
        @else
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-tag"></i> Cibil Score</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <b>Cibil score</b> : {{$form->cibil_score}}
                        <br>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.box-body -->
        </div>
        @endif
        <!-- this row will not appear when printing -->
        <div class="row no-print">
            <div class="col-xs-12">
                <a href="" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a> @if($form->approval=="unapproved")
                <a href="/form/approve/{{$form->id}}" style="margin-left: 15px;" class="btn btn-primary"><i class="fa fa-print"></i> Approve form</a> @endif @if($form->category== "two" || $form->category== "three")
                <a href="/admin/test-result/{{$form->user->id}}" style="margin-left: 15px;" class="btn btn-primary"><i class="fa fa-print"></i>Test Result</a> @endif
                <a href="/admin/application/pdfloan/{{$form->user->id}}">
                    <button class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> Generate PDF</button>
                </a>
            </div>
        </div>
    </section>
    <!-- /.content -->
    <div class="clearfix"></div>
</div>
<!-- /.content-wrapper -->


        @endsection






