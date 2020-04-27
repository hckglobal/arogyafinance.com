@extends('admin.app')

@section('styles')
<!-- DataTables -->
<link rel="stylesheet" href="/assets/admin/plugins/datatables/dataTables.bootstrap.css">
@endsection

@section('title') 
Logs
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
              <h3 class="box-title">Logs</h3>
              <!-- <button class="btn btn-default pull-right  action-btn" type="button" id="menu1" data-toggle="dropdown">
            <i class="fa fa-bars margin-icon"></i>
            Back to Application
            </button> -->
            <a href="/admin/application/{{$application->type}}/detail/{{$application->id}}">
                    <button class="btn btn-default pull-right">Back to Application</button>
                </a>
            </div>
            
            <!-- /.box-header -->

             <div class="box-body">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <table class="table table-bordered table-striped">
                <thead><tr>
                  <th>User</th>
                  <th>Field</th>
                  <th>Old Details</th>
                  <th>New Details</th>
                  <th>Notes</th>
                  <th>Date</th>
                </tr></thead>
                <tbody>
                @foreach($logs as $log)
                  <tr>
                    @if($log->admin_id) 
                      <td>{{$log->admin->first_name}} {{$log->admin->last_name}}</td>   
                      <td>{{$log->field}}</td>
                      <td>{{$log->old_value}}</td>
                      <td>{{$log->new_value}}</td>
                      <td>{{$log->notes}}</td>
                      <td>{{$log->created_at}}</td>
                    @else
                    
                    @endif
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
