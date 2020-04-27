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
        <section class="content-header">
          <h1>
            Application Id:
            <big>#{{$form->user->id}} | Type: {{$form->form_type}} | Category: {{$form->category}}</big>
          @if($form->sanction=="sanction")
              <h4>Form Status:{{$form->sanction}}</h4>
              @endif
              </h1>

          <ol class="breadcrumb">
            <li class="active">Application Id</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="invoice">
          <!-- title row -->
          <div class="row">
            <div class="col-xs-12">
              <h2 class="page-header">
                <i class="fa fa-globe"></i> Arogya Finance
                <small class="pull-right">Date: {{$form->user->created_at}}</small>
              </h2>
            </div><!-- /.col -->
          </div>
          <!-- info row -->
          <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
              From
              <div class="user-photo">
                   <img src="/documents/photos/{{$form->photo}}" alt="User Photo">
               </div>
              <address>
                <strong>{{$form->user->first_name}} {{$form->user->last_name}}</strong><br>
                {{$form->user->address1}},<br>
                {{$form->user->address2}},<br>
                {{$form->user->city}},<br>
                {{$form->user->state}}<br>

                Email: {{$form->user->email}}
              </address>
            </div><!-- /.col -->
            <div class="col-sm-4 invoice-col">
              To
              <address>
                <strong>Arogya Finance</strong><br>
                Sir Mathuradas Vasanji Rd, Mota Nagar,<br>
                Andheri East, Mumbai, <br>
                Maharashtra 400053 <br>
                Email: info@arogyafinance.com
              </address>
            </div><!-- /.col -->
          </div><!-- /.row -->
          <br>         
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-tag"></i> Patient Details</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-4">
                  <b>Full Name</b> : {{$form->first_name_patient}} {{$form->middle_name_patient}} {{$form->last_name_patient}} <br>
                  <b>Type Of Treatement</b> : {{$form->treatment_type}}
                </div>
                <div class="col-md-4">
                  <b>Date Of Birth</b> : {{$form->date_of_birth_patient}} <br>
                  <b>Estimate Cost</b> : &#8377;{{$form->estimate_cost}}
                </div>
                <div class="col-md-4">
                  <b>Mobile Number</b> : {{$form->patient_mobile_number}} <br>
                  <b>Loan Required</b> : &#8377;{{$form->loan_required}}
                </div>
              </div><!-- /.row -->
            </div><!-- /.box-body -->
          </div>

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
                  <b>PAN Number</b> : {{$form->user->pan_number}}<br>
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
              <h3 class="box-title"><i class="fa fa-tag"></i> Financial Details</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-4">
                  <b>Borrower's Income</b> : &#8377;{{$form->borrowers_income}} <br>
                  <b>Income as per ITR</b> : &#8377;{{$form->income_itr}} <br> 
                  <b>Earning Since</b> : {{$form->earning_since}} <br> 
                  @if($form->other_earning)
                    <b>Other Earning :</b> &#8377;{{$form->other_earning}} <br>
                    <b>Other Earning Type:</b> &#8377;{{$form->other_earning_type}} <br>
                  @endif
                  <b>Proposed Loan EMI</b> : &#8377;{{$form->monthly_emi_possible}} <br> 
                </div>
                <div class="col-md-4">
                  <b>Current Loan EMI</b> : &#8377;{{$form->current_loan_emi}} <br>
                  <b>Education Expense</b> : &#8377;{{$form->education_expenses}}<br>
                  <b>House Rent :</b> &#8377;{{$form->house_rent}} <br>
                  <b>Assets :</b> @if($form->asset_tv!=null){{$form->asset_tv}}@endif, 
                                  @if($form->asset_refrigerator!=null){{$form->asset_refrigerator}},@endif
                                  @if($form->asset_washing!=null){{$form->asset_washing}},@endif
                                  @if($form->asset_vechile!=null){{$form->asset_vechile}},@endif
                                  @if($form->asset_mobile!=null){{$form->asset_mobile}}@endif <br>
                </div>
                <div class="col-md-4">
                  <b>Nature Of Income</b> : {{$form->nature_of_income}} <br>
                  <b>Employer Details</b> : {{$form->employer_details}} <br>
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
                  <b>Calculated Loan Tenure :</b> {{$form->approved_loan_tenure}} Months<br>
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
     
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-tag"></i> Calculated Financial Details</h3>
            </div>
            <form action="/admin/update-form" method="post">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" name="id" value="{{$form->id}}">
            <div class="box-body">
              <div class="row">
                <div class="col-md-6 form-group">
                 
                  @if($form->validate=="unvalidated")
                  <label>Please select</label>
                  <select class="form-control" name="employee_id">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                  </select>
                  @else
                   Validate by: {{$form->employee_id}} 
                  @endif
                </div>
                
                <div class="col-md-6 form-group">
                 
                 @if($form->validate=="unvalidated")
                  <label>Notes</label>
                  <textarea class="form-control" name="notes" rows="3" placeholder="Enter a note..."></textarea>
                @else
                   Notes: {{$form->notes}} 
                  @endif
                </div>
              </div><!-- /.row -->
            </div><!-- /.box-body -->
            </form>
          </div>

          <!-- this row will not appear when printing -->
          <div class="row no-print">
            <div class="col-xs-12">
              <a href="" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
              @if($form->sanction=="unsanctioned")
              <a href="/admin/sanction/{{$form->id}}" style="margin-left: 15px;" class="btn btn-primary"><i class="fa fa-print"></i> Sanction form</a>
              @endif
              @if($form->category== "two" || $form->category== "three")
              <a href="/admin/test-result/{{$form->id}}" style="margin-left: 15px;" class="btn btn-primary"><i class="fa fa-print"></i>Test Result</a>
              @endif
              @if($form->validate=="unvalidated")
              <a href="/admin/validate/{{$form->id}}" style="margin-left: 15px;" class="btn btn-primary"><i class="fa fa-print"></i>Validate</a>
              @endif
              <a href="/admin/application/pdfloan/{{$form->user->id}}"><button class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> Generate PDF</button></a>
            </div>
          </div>
        </section><!-- /.content -->
        <div class="clearfix"></div>
      </div><!-- /.content-wrapper -->
        @endsection

        @section('scripts')
        <!-- DataTables -->
        <script src="/assets/admin/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="/assets/admin/plugins/datatables/dataTables.bootstrap.min.js"></script>
        <!-- SlimScroll -->
        <script src="/assets/admin/plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <!-- FastClick -->
        <script src="/assets/admin/plugins/fastclick/fastclick.min.js"></script>
        <!-- AdminLTE App -->
        <script src="/assets/admin/dist/js/app.min.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="/assets/admin/dist/js/demo.js"></script>
        <!-- page script -->
        <script>
        $(function () {
          $(".table").DataTable();

        });
        </script>
        @endsection

