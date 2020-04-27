@extends('admin.app')

@section('styles')
<!-- DataTables -->
<link rel="stylesheet" href="/assets/admin/plugins/datatables/dataTables.bootstrap.css">
@endsection

@section('title') 
Turn Around Time
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
              <h3 class="box-title">Turn Around Time</h3>
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
                  <th>TAT</th>
                </tr></thead>
                  <tbody>
                <?php 
                  $last_status_created_at=[];
                ?>
                @foreach($logs as $index=>$log)
                <?php  
                array_push($last_status_created_at,$log->created_at);
                ?>
                  <tr>
                   @if($log->admin_id) 
                      <td>{{$log->admin->first_name}} {{$log->admin->last_name}}</td>   
                      <td>{{$log->field}}</td>
                      <td>{{$log->old_value}}</td>
                      <td>{{$log->new_value}}</td>
                      <td>{{$log->tat}}</td> 
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
