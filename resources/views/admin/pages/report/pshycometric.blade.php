@extends('admin.app')

@section('styles')
<!-- DataTables -->
<link rel="stylesheet" href="/assets/admin/plugins/datatables/dataTables.bootstrap.css">
@endsection

@section('title') 
Reports
@endsection

@section('active-dashboard')
class="active"
@endsection

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" >

  <!-- Main content -->
  <section class="content" id="application" >
    <div class="row">
      <div class="col-xs-12">
        <!-- box -->

        <div class="box">

            <!-- box header -->
            <div class="box-header">
              <h3>Pshycometric Application Report</h3>
              <a href="/admin/report/lead" class="btn btn-primary btn-success">Application Leads</a>
              <a href="/admin/report/new" class="btn btn-primary btn-success">New</a>
              <a href="/admin/report/verified" class="btn btn-primary btn-success">Verified</a>
              <a href="/admin/report/sanctioned" class="btn btn-primary btn-success">Sanctioned</a>
              <a href="/admin/report/rejected" class="btn btn-primary btn-success">Rejected</a>
              <a href="/admin/report/disbursed" class="btn btn-primary btn-success">Disbursed</a>
              <!-- <a href="/admin/report/pshycometric" class="btn btn-primary btn-success">Psychometric</a> -->
              <a href="/admin/report/email-exceptions" class="btn btn-primary btn-success">Email Exceptions</a>
              <br><br>
              <div class="row m-t-10 m-b-10">
                  <form action="/admin/report/pshycometric" method="get">

                      <div class="col-md-4">
                          <div class="form-group contact-search m-b-30">
                              <label for="start-date">Start Date</label>
                              <input type="date" id="start-date" name="start-date" class="form-control datepicker-autoclose"  data-date-format="mm/dd/yyyy" placeholder="Start Date...">
                          </div>   
                      </div>
                      <div class="col-md-4">
                          <div class="form-group contact-search m-b-30">
                               <label for="end-date">End Date</label>
                              <input type="date" id="end-date" name="end-date"class="form-control datepicker-autoclose" placeholder="End Date...">
                              
                          </div>
                      </div>
                      <div class="col-md-2">
                           <div class="form-group contact-search m-b-30">
                              <label>&nbsp;</label>

                              <button type="submit" class="btn btn-block btn-primary">
                                  <i class="ion-funnel">&nbsp;&nbsp;</i>   Filter
                              </button>
                          </div>
                      </div>

                        <div class="col-md-2">
                           <div class="form-group contact-search m-b-30">
                              <label>&nbsp;</label>
                              <a class="btn btn-block btn-primary" href="/admin/report/pshycometric/export?start-date={{Request::get('start-date')}}&end-date={{Request::get('end-date')}}">
                                <i class="ion-archive">&nbsp;&nbsp;</i>    Export
                              </a>
                          </div>
                      </div>
                  </form>
              </div>
            </div>
            <!-- /.box-header -->


             <div class="box-body">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <table class="table table-bordered table-striped">
                <thead><tr>
                  <th>Application ID</th>
                  <th>PIN Number</th>
                  <th>Borrower Name</th>
                  <th>Ability</th>
                  <th>Integrity</th>
                  <th>Intension</th>
                  <th>Risk</th>
                  <th>Total Score/Result</th>
                </tr></thead>
                <tbody>
                @foreach($borrowers as $borrower)
                <tr>
                  <td>@if($borrower->application){{$borrower->application->id}} @endif</td>
                  <td>@if($borrower->application){{$borrower->application->pin_number}}@endif</td>  
                  <td>{{ucFirst($borrower->first_name)}} {{ucFirst($borrower->middle_name)}} {{ucFirst($borrower->last_name)}}</td> 

                  <td class="text-center psyco-test">
                      @if($borrower->result('total')== 'reject')
                        <span class="bg-red">{{$borrower->score('ability')}}</span> 
                      @else
                        <span class="bg-green">{{$borrower->score('ability')}}</span >
                      @endif
                  </td>
           
                  <td class="text-center psyco-test">
                      @if($borrower->result('total')== 'reject')
                        <span class="bg-red">{{$borrower->score('integrity')}}</span> 
                      @else
                        <span class="bg-green">{{$borrower->score('integrity')}}</span >
                      @endif
                  </td>

                  <td class="text-center psyco-test">
                      @if($borrower->result('total')== 'reject')
                        <span class="bg-red">{{$borrower->score('intention')}}</span> 
                      @else
                        <span class="bg-green">{{$borrower->score('intention')}}</span >
                      @endif
                  </td>
           
                  <td class="text-center psyco-test">
                      @if($borrower->result('total')== 'reject')
                        <span class="bg-red">{{$borrower->score('risk')}}</span> 
                      @else
                        <span class="bg-green">{{$borrower->score('risk')}}</span >
                      @endif
                  </td>

                  <td class="text-center psyco-test">
                      @if($borrower->result('total')== 'reject')
                        <span class="bg-red">{{ucFirst($borrower->result('total'))}}</span> 
                      @else
                        <span class="bg-green">{{ucFirst($borrower->result('total'))}}</span >
                      @endif
                  </td>
                </tr>
                @endforeach
              </tbody></table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /box -->
      </div>
    </div>
@include('admin.pages.application.partials.modal_confirm')
  </section><!-- /content -->

</div><!-- /content-wrapper -->

@endsection

@section('scripts')
<!-- DataTables -->
<script type="text/javascript" src="/assets/js/vue.min.js"></script>
<script type="text/javascript" src="/assets/js/admin.vue.js"></script>
<script src="/assets/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/assets/admin/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
$(function () {
  $(".table").DataTable({
    "order": [[ 0, "desc" ]]
  });

});
// function AlertIt() {

</script>


@endsection
