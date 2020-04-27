@extends('admin.app')

@section('title')
{{$title}}
@endsection

@section('styles')
<!-- DataTables -->
<link rel="stylesheet" href="/assets/admin/plugins/datatables/dataTables.bootstrap.css">
<style type="text/css">
.highlight{background-color:yellow}
</style>
@endsection

@section('active-dashboard')
class="active"
@endsection

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" >
  <!-- Content Header (Page header) -->
  @include('admin.partials.content-header')

  <!-- Main content -->
  <section class="content" id="application" >
    <div class="row">
      <div class="col-xs-12">
        <!-- /.box -->
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Search Result for : {{$keyword}} | Total : {{count($results)}}</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Application Id</th>
                  <th>Borrower Type</th>
                  <th>Borrower Name</th>
                  <th>Location</th>
                  <th>Action</th>
                  <!-- <th></th> -->
                </tr>
              </thead>
              <tbody>
                @forelse($results as $application)
                  <tr>
                    <td>{{$application->id}}</td>
                    <td>{{ucfirst($application->borrower_type)}}</td>
                    <td>{{$application->first_name}} {{$application->last_name}}</td>
                    <td>{{$application->location}}</td>
                    <td><a href="/admin/application/{{$application->type}}/detail/{{$application->id}}" class="btn btn-block btn-success">View</a></td>                   
                    <!-- <td><a @click="showConfirmModal('/admin/application/{{$application->type}}/delete/{{$application->id}}','delete')" href="javascript:;" class="btn btn-block btn-danger delete-cofirmation">Delete</a></td> -->
                  </tr>
                @empty
                  <tr>
                    <td colspan="5">
                      Application not available.
                    </td>
                  </tr>  
                @endforelse
              </tbody>
              <tfoot>
                <tr>
                  <th>Application Id</th>
                  <th>Borrower Type</th>
                  <th>Borrower Name</th>
                  <th>Location</th>
                  <th>Action</th>
                  <!-- <th></th> -->
                </tr>
              </tfoot>
            </table>
          </div><!-- /.box-body -->

        </div><!-- /.box -->
      </div>
    </div>
    @include('admin.pages.application.partials.modal_confirm')
  </section><!-- /.content -->
  <script type="text/javascript" src="/assets/js/admin.vue.js"></script>
</div><!-- /.content-wrapper -->

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
