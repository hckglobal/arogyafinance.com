@extends('admin.app')

@section('styles')
<!-- DataTables -->
<link rel="stylesheet" href="/assets/admin/plugins/datatables/dataTables.bootstrap.css">
@endsection

@section('title') 
DMI
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
                <h3>{{ucFirst($status)}} DMI</h3>
                <a href="/admin/application/dmi/new"      class="btn btn-primary btn-success">New</a>
                <a href="/admin/application/dmi/accepted" class="btn btn-primary btn-success">Accepted</a>
                <a href="/admin/application/dmi/rejected" class="btn btn-primary btn-success">Rejected</a>
                <a class="btn btn-primary btn-success" type="button" data-toggle="modal" 
                    data-target="#send-bulk-pin">Send in Bulk
                </a>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Application ID</th>
                            <th>Category</th>
                            <th>Refernce Number</th>
                            <th>Application Type</th>
                            <th>Borrower Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($applications as $application)
                    <tr>
                        <td>{{$application->id}}</td>
                        <td>Category Name</td>
                        <td>{{$application->reference_code}}</td>
                        <td>{{$application->type}}</td>
                        @if($application->borrower)                   
                        <td>{{$application->borrower->first_name}} {{$application->borrower->middle_name}} {{$application->borrower->last_name}}</td>
                        @else
                        <td></td>
                        @endif   
                        <td>
                          <a href="/admin/application/{{$application->type}}/detail/{{$application->id}}" class="btn btn-block btn-success">View</a>
                        </td>
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
<!-- Modal -->
<div id="send-bulk-pin" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form action="/admin/application/send-bulk-pin" method="GET">
            {{csrf_field()}}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Send PIN Numbers to DMI</h4>
                </div>                    
                <div class="modal-body">
                    <strong>Please enter the application PIN Numbers</strong><br>
                    <mark>use , for multiple values (e.g  AF10211,BF30145,AD20152)</mark>
                    <textarea name="pin_numbers" id="" class="form-control"></textarea>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- line modal -->
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