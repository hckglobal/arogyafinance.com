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

  <!-- Main content -->
  <section class="content" id="application" >
    <div class="row">
      <div class="col-xs-12">
        <!-- box -->

        <div class="box">

            <!-- box header -->
            <div class="box-header">
              <div class="row m-t-10 m-b-10">
                  <form action="/admin/analytics/summary/filter" method="get">
                    <input type="hidden" name="month_year" value="{{$input->month_year}}">
                      @include('admin.pages.analytics.partials.header')
                      
                  </form>

              </div>
            </div>
            <!-- /.box-header -->


            <div class="box-body">
              <div class="box-footer">
                <h3>Total Applications {{count($applications)}}</h3>
                <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Application Id</th>
                        <th>PIN</th>
                        <th>Borrower Name</th>
                        <th>Location</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($applications as $application)
                      <tr>
                        <td>{{$application->id}}</td>
                        <td>{{$application->pin_number}}</td>
                        <td>{{$application->first_name}} {{$application->last_name}}</td>
                        <td>{{$application->location}}</td>
                        <td><a href="/admin/application/{{$application->type}}/detail/{{$application->id}}" target="_blank" class="btn btn-block btn-success">View</a></td>
                      </tr>
                      @endforeach
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>Application Id</th>
                        <th>PIN</th>
                        <th>Borrower Name</th>
                        <th>Location</th>
                        <th>Action</th>
                      </tr>
                    </tfoot>
                </table>
              </div>
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
