@extends('admin.app')

@section('styles')
<!-- DataTables -->
<link rel="stylesheet" href="/assets/admin/plugins/datatables/dataTables.bootstrap.css">
@endsection

@section('title') 
Account Activity Logs
@endsection

@section('active-dashboard')
class="active"
@endsection

@section('content')
<div class="content-wrapper" >
    <section class="content" id="application" >
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Account Activity Logs</h3>
                    </div>
                    <div class="box-body">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Admin</th>
                                    <th>Message</th>
                                    <th>User</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($activity_logs as $log)
                                <tr>
                                    <td>{{$log->admin->first_name}} {{$log->admin->last_name}}</td>   
                                    <td>{{$log->message}}</td>
                                    <td>{{$log->user->first_name}} {{$log->user->last_name}}</td>
                                    <td>{{$log->created_at}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
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
