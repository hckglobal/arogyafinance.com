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
            </div><!-- /.col -->
          </div>
          <!-- info row -->
          <div class="row invoice-info">
          <div class="col-sm-4"> 
            <div class="user-avatar" style="background-image:url(/documents/photos/{{$form->photo}})"></div>
          </div>
            <div class="col-sm-4 invoice-col">
              <address>
              <br>
                <strong>{{$form->user->first_name}} {{$form->user->last_name}}</strong><br>
                {{$form->user->address1}},<br>
                {{$form->user->address2}},<br>
                {{$form->user->city}},<br>
                {{$form->user->state}}<br>

                Email: {{$form->user->email}}
              </address>
            </div><!-- /.col -->
            <div class="col-sm-4 invoice-col">
            </div><!-- /.col -->
          </div><!-- /.row -->
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
                  <b>Residence Type</b> : {{$form->user->residence_type}} <br>
                  <b>State :</b> {{$form->user->state}} <br>
                </div>
              </div><!-- /.row -->
            </div><!-- /.box-body -->
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
              </div><!-- /.row -->
            </div><!-- /.box-body -->
          </div>
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-tag"></i> Family Details</h3>
            </div>
            <div class="box-body">
              <div class="row">
              @foreach($form->user->familyMembers as $family)
                <div class="col-md-4">
                  <b>First Name</b> : {{$family->first_name}} <br>
                  <b>Last Name</b> : {{$family->last_name}} <br> 
                  <b>Relation</b> : {{$family->relation}} <br> 
                  
                </div>
              @endforeach
              <div class="clearfix"></div>
                
              </div><!-- /.row -->
            </div><!-- /.box-body -->
          </div>
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-tag"></i> Financial Details</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-4">
                  <b>Borrower's Income</b> : &#8377;{{$form->borrowers_income}} <br>
                  <b>Income as per ITR</b> : &#8377;{{$form->income_itr}} <br> 
                  <b>Earning Since</b> : {{$form->earning_since}} <br> 

                  @if($form->other_earnings)
                    <b>Other Earning Type:</b> {{$form->other_earnings_type}} <br>
                    <b>Other Earning :</b> &#8377;{{$form->other_earnings}} <br>
                  @else
                   <b>Other Earning :</b> None <br>
                  @endif
                  <b>Montly EMI Possible</b> : &#8377;{{$form->monthly_emi_possible}} <br> 
                </div>
                <div class="col-md-4">
                  <b>Loan Required</b> :  &#8377;{{$form->loan_required}}<br>
                  <b>Current Loan EMI</b> : {{ $form->current_loan_emi ? '&#8377;'.$form->current_loan_emi : 'None'}} <br>
                  <b>Education Expense</b> : {{ $form->education_expenses ? '&#8377;'.$form->education_expenses : 'None'}}<br>
                  <b>House Rent :</b> {{ $form->house_rent ?'&#8377;'. $form->house_rent : 'None'}} <br>
                  <b>Number Of Dependants :</b> {{$form->number_of_dependants}} <br>

                </div>
                <div class="col-md-4">
                  <b>Nature Of Income</b> : {{$form->nature_of_income}} <br>
                  <b>Name Of The Firm :</b> {{$form->name_of_firm}} <br>
                </div>
              </div><!-- /.row -->
            </div><!-- /.box-body -->
          </div>
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-tag"></i> Calculated Financial Details</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-4">
                  <b>Total Borrower's Income</b> : &#8377;{{$form->total_borrowers_income}} <br>
                  <b>Calculated Montly Income</b> : &#8377;{{$form->calculated_income}} <br>
              
                </div>
                
                <div class="col-md-4">
                  <b>Calculated Loan Amount</b> : &#8377;{{$form->approved_loan_amount}} <br>
                  <b>Calculated Loan EMI</b> : &#8377;{{$form->approved_loan_emi}} <br>
                  <b>Calculated Loan Tenure :</b> {{$form->approved_loan_tenure}} Months (Requested : {{$form->requested_tenure}} Months)<br>
                </div>
              </div><!-- /.row -->
            </div><!-- /.box-body -->
          </div>
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-tag"></i> Documents</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-4">
                  <div style="margin-bottom: 15px;">
                    <b>Id Proof</b><br>
                    Document Type : {{$form->id_proof}} <br> 
                    <a href="/documents/{{$form->id_proof_doc}}">
                      <button class="btn btn-primary"><i class="fa fa-download"></i> Download </button>
                    </a><br>
                  </div>
                  <div style="margin-bottom: 15px;">
                    <b>Bank Statement</b><br>
                    Document Type : {{$form->bank_statement}} <br> 
                    <a href="/documents/{{$form->bank_statement_doc}}">
                      <button class="btn btn-primary"><i class="fa fa-download"></i> Download </button>
                    </a><br>
                  </div>
                </div>
                <div class="col-md-4">
                  <div style="margin-bottom: 15px;">
                    <b>Residence Proof</b><br>
                    Document Type : {{$form->residence_proof}} <br> 
                    <a href="/documents/{{$form->residence_proof_doc}}">
                      <button class="btn btn-primary"><i class="fa fa-download"></i> Download </button>
                    </a><br>
                  </div>
                </div>
                <div class="col-md-4">
                  <div style="margin-bottom: 15px;">
                    <b>Income Proof</b><br>
                    Document Type : {{$form->income_proof}} <br> 
                    <a href="/documents/{{$form->income_proof_doc}}">
                      <button class="btn btn-primary"><i class="fa fa-download"></i> Download </button>
                    </a><br>
                  </div>
                </div>
              </div><!-- /.row -->
            </div><!-- /.box-body -->
          </div>
     
       @if($form->cibil_score==0)
       <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-tag"></i> Update Cibil</h3>
            </div>
            <div class="box-body">
              <div class="row">
                    <form action="/admin/form/update/{{$form->id}}" method="POST">
                      <input type="hidden" name="_token" value="{{csrf_token()}}">
                       Cibil Score: &nbsp; <input type="text" name="cibil_score" placeholder="Cibil Score"> &nbsp;
                      <button class="btn btn-primary" type="submit" style="margin-right: 5px;"><i class="fa fa-download"></i> Update</button>
                    </form>
              </div><!-- /.row -->
            </div><!-- /.box-body -->
          </div>
          @else
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-tag"></i> Cibil Score</h3>
            </div>
            <div class="box-body">
              <div class="row">
                 <div class="col-md-12">
                    <b>Cibil score</b> : {{$form->cibil_score}}<br>
                 </div>
              </div><!-- /.row -->
            </div><!-- /.box-body -->
          </div>
          @endif

           <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-tag"></i> Internal Details</h3>
            </div>
            <div class="box-body">
              <div class="row">
                 <div class="col-md-6">
              <!-- DIRECT CHAT -->
              <div class="box box-warning direct-chat direct-chat-warning">
                <!-- <div class="box-header with-border">
                  <h3 class="box-title">Direct Chat</h3>
                
                  <div class="box-tools pull-right">
                    <span data-toggle="tooltip" title="3 New Messages" class="badge bg-yellow">3</span>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle">
                      <i class="fa fa-comments"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                    </button>
                  </div>
                </div> -->
                <!-- /.box-header -->
                <div class="box-body">
                  <!-- Conversations are loaded here -->
                  <div class="direct-chat-messages">
                    <!-- Message. Default to the left -->
                     

                    <div class="direct-chat-msg">
                      <div class="direct-chat-info clearfix">
                        <span class="direct-chat-name pull-left">Alexander Pierce</span>
                        <span class="direct-chat-timestamp pull-right">23 Jan 2:00 pm</span>
                      </div>
                      <!-- /.direct-chat-info -->
                      <img class="direct-chat-img" src="/assets/admin/dist/img/user2-160x160.jpg" alt="message user image"><!-- /.direct-chat-img -->
                      <div class="direct-chat-text">
                        Is this template really for free? That's unbelievable!
                      </div>
                      <!-- /.direct-chat-text -->
                    </div>
                    <!-- /.direct-chat-msg -->

                    

                    <!-- Message. Default to the left -->
                    <div class="direct-chat-msg">
                      <div class="direct-chat-info clearfix">
                        <span class="direct-chat-name pull-left">Alexander Pierce</span>
                        <span class="direct-chat-timestamp pull-right">23 Jan 5:37 pm</span>
                      </div>
                      <!-- /.direct-chat-info -->
                      <img class="direct-chat-img" src="/assets/admin/dist/img/user2-160x160.jpg" alt="message user image"><!-- /.direct-chat-img -->
                      <div class="direct-chat-text">
                        Working with AdminLTE on a great new app! Wanna join?
                      </div>
                      <!-- /.direct-chat-text -->
                    </div>
                    <!-- /.direct-chat-msg -->

                   

                  </div>
                  <!--/.direct-chat-messages-->

                  <!-- Contacts are loaded here -->
                 
                  <!-- /.direct-chat-pane -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                  <form action="#" method="post">
                    <div class="input-group">
                      <input type="text" name="message" placeholder="Type Message ..." class="form-control">
                          <span class="input-group-btn">
                            <button type="button" class="btn btn-warning btn-flat">Send</button>
                          </span>
                    </div>
                  </form>
                </div>
                <!-- /.box-footer-->
              </div>
              <!--/.direct-chat -->
            </div>
            <div class="col-md-6">
              <div class="box box-warning">
           <div class="box-body">
              <form role="form">
                <!-- text input -->
                <div class="form-group">
                  <label>Tenure</label>
                  <input type="text" class="form-control" name="tenure" placeholder="Enter Tenure">
                </div>
                <div class="form-group">
                  <label>Loan</label>
                  <input type="text" class="form-control" name="loan" placeholder="Enter Loan">
                </div>
                <div class="form-group">
                  <label>Emi</label>
                  <input type="text" class="form-control" name="emi" placeholder="Enter Emi">
                </div>

                <a href="#" class="btn btn-primary">Submit</a>
                
              </form>
            </div>
            
          </div>
              
            </div>
              </div><!-- /.row -->

            </div><!-- /.box-body -->
          </div>

          
      

        <!-- this row will not appear when printing -->
          <div class="row no-print">
            <div class="col-xs-12">
              <a href="" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
              @if($form->verified==0)
              <a href="/form/verify/{{$form->id}}" style="margin-left: 15px;" class="btn btn-primary"><i class="fa fa-print"></i>Verified</a>
              @endif
              @if($form->sanctioned==0 && $form->verified==1)
              <a href="/form/sanction/{{$form->id}}" style="margin-left: 15px;" class="btn btn-primary"><i class="fa fa-print"></i>Sanctioned</a>
              @endif
              @if($form->category== "two" || $form->category== "three")
              <a href="/admin/test-result/{{$form->id}}" style="margin-left: 15px;" class="btn btn-primary"><i class="fa fa-print"></i>Test Result</a>
              @endif
              <a href="/admin/application/pdfloan/{{$form->user->id}}"><button class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> Generate PDF</button></a>
            </div>
          </div>
        </section><!-- /.content -->
        <div class="clearfix"></div>
      </div><!-- /.content-wrapper -->
        @endsection

    

