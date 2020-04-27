@extends('admin.app')

@section('styles')
<!-- DataTables -->
<link rel="stylesheet" href="/assets/admin/plugins/datatables/dataTables.bootstrap.css">
@endsection

@section('title') 
{{$title}}
@endsection

@section('active-dashboard')
class="active"
@endsection

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" >
  @include('admin.partials.content-header')
  <!-- Main content -->
  <section class="content content-fa">
    <div class="row">
      <div class="col-xs-12">
        <!-- box -->

        <div class="box">

            <!-- box header -->
            <div class="box-header">
              <div class="row m-t-10 m-b-10">
                  <form action="/admin/analytics/mis/summary/filter" method="get">
                      @include('admin.pages.analytics.partials.header')
                  </form>
              </div>
              <a href="/admin/lead/create" class="pull-right btn btn-success" target="_blank"><i class="fa fa-plus" aria-hidden="true" ></i> Create New Lead</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <h3>Total Leads {{count($leads)}}</h3>
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Id</th>
                      <th>Date</th>
                      <th>Lead Name</th>
                      <th>Mobile Number</th>
                      <th>location</th>
                      <th>Product</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  @forelse($leads as $lead)
                    <tr>
                      <td>{{$lead->id}}</td>
                      <td>{{Carbon\Carbon::parse($lead->date_of_contact)->format('d-m-Y')}}</td>
                      <td>{{$lead->first_name}} {{$lead->middle_name}} {{$lead->last_name}}</td>
                      <td>{{$lead->mobile_number}}</td>
                      <td>{{$lead->location}}</td>
                      <td>{{$lead->product}}</td>
                      @if($lead->status=='pending')
                        <td>
                          <a href="/apply/loan/personal-details?lead_id={{$lead->id}}&referrer_id={{$lead->referrer_id}}" target="_blank"><i data-toggle="tooltip" data-placement="top" title="Convert to Loan" class="fa fa-file-text-o" aria-hidden="true"></i></a>
                          <a href="/apply/card/personal-details?lead_id={{$lead->id}}" target="_blank"><i data-toggle="tooltip" data-placement="top" title="Convert to Card" class="fa fa-credit-card" aria-hidden="true"></i></a>                
                          <a  href="javascript:;" type="button" data-toggle="modal" data-target="#lead-{{$lead->id}}"  ><i data-toggle="tooltip" data-placement="top" title="Reject"  class="fa fa-times" aria-hidden="true"></i></a>
                        </td>
                      @elseif($lead->status=='rejected')
                        <td>
                          {{$lead->reject_reason}}
                        </td>
                      @elseif($lead->status=='converted-to-card' || $lead->status=='converted-to-loan')
                          
                      @endif                  
                    </tr>
                    <div id="lead-{{$lead->id}}" class="modal fade" role="dialog">
                      <div class="modal-dialog">
                        <form action="/admin/lead/reject/{{$lead->id}}" method="POST">
                        {{csrf_field()}}
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title">Warning!</h4>
                            </div>
                            <div class="modal-body">
                              <p class="danger">Are you sure you want to reject the Mis</p>
                            </div>
                            <div class="modal-body">
                              <p>Give Reason</p>
                              <select class="form-control" name="reject_reason_id">
                                @foreach($reject_reasons as $reason)
                                  <option value="{{$reason->id}}">{{$reason->text}}</option>
                                @endforeach
                              </select>
                            </div>
                            <div class="modal-footer">
                              <button type="submit" class="btn btn-danger">Submit</button>
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  @empty
                    <h4>No Data Available</h4>  
                  @endforelse
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>Id</th>
                      <th>Date</th>
                      <th>Lead Name</th>
                      <th>Mobile Number</th>
                      <th>location</th>
                      <th>Product</th>
                      <th>Action</th>
                    </tr>
                  </tfoot>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /box -->
      </div>
    </div>
  </section><!-- /content -->

</div><!-- /content-wrapper -->

@endsection          

@section('scripts')
<!-- DataTables -->
<script type="text/javascript" src="/assets/js/vue.min.js"></script>
<script src="/assets/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/assets/admin/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
$(function () {
  $(".table").DataTable({
    "order": [[ 0, "desc" ]],
     "columnDefs": [{
        "defaultContent": "-",
        "targets": "_all"
      }]
  });
});

// function AlertIt() {

</script>

@endsection


