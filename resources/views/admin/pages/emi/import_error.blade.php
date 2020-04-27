@extends('admin.app')

@section('styles')
<!-- DataTables -->
<link rel="stylesheet" href="/assets/admin/plugins/datatables/dataTables.bootstrap.css">
@endsection

@section('title') 
Import ACH Summary
@endsection

@section('active-dashboard')
class="active"
@endsection

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" >
  <section class="content" id="application" >
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3>Failed to import ACH</h3> 
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>PIN</th>
                            <th>Reason</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($import_error as $error)
                        <tr>
                            <td>{{$error['pin_number']}}</td>
                            <td>{{$error['error']}}</td>
                        </tr>                            
                    @endforeach    
                  </tbody>
                </table>
            </div>
        </div>
      </div>
    </div>
  </section>
</div>

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