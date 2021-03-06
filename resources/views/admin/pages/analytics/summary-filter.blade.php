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
        <!-- filter -->
        <div class="box">
          <!-- box header -->
            <div class="box-header">
              <div class="row m-t-10 m-b-10">
                  <form action="/admin/analytics/summary" method="get">
                    <input type="hidden" name="type" value="{{$input->type}}">
                      @include('admin.pages.analytics.partials.header')
                  </form>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">              
              
              <div class="box-footer col-md-2">
                <strong>Applications</strong>
                @include('admin.pages.analytics.partials.applications')  
              </div>
              
              <div class="box-footer col-md-3">
                <strong>Applications Status</strong>
                @include('admin.pages.analytics.partials.status')                 
              </div>              
              
              <div class="box-footer col-md-3">
                <strong>Location</strong>
                @include('admin.pages.analytics.partials.location')  
              </div>

              <div class="box-footer col-md-4">
                <strong>Disbursement</strong>
                @include('admin.pages.analytics.partials.disbursement')  
              </div>

            </div>
            <!-- /.box-body -->
        </div>
        <!-- /filter -->
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
    "order": [[ 0, "desc" ]]
  });

});
// function AlertIt() {

</script>


@endsection
