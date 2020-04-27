@extends('admin.app')

@section('title')
{{$title}}
@endsection

@section('styles')
<!-- DataTables -->
<link rel="stylesheet" href="/assets/admin/plugins/datatables/dataTables.bootstrap.css">
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
            <h3 class="box-title">Category - {{ucfirst($category)}} | Total: {{$applications->count()}} Applications</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Application Id</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Location</th>
                  <th>Test Result</th>
                  <th>Date</th>
                  <th>Last Updated</th>
                  <th>Action</th>
                  <!-- <th></th> -->
                </tr>
              </thead>
              <tbody>
                @foreach($applications as $application)
                <tr>
                  <td>{{$application->id}} </td>
                  <td>{{{$application->borrower?$application->borrower->first_name : 'NA'}}}</td>
                  <td>{{{$application->borrower?$application->borrower->last_name : 'NA'}}}</td>
                  <td>{{$application->location->name}}</td>
                  <td class="text-center psyco-test">
                    @if(!$application->psychometricTest->isEmpty())
                      @if($application->psychometricTest()->where('test_url','!=','')->count()>0)
                        @if($application->psychometricTest()->where('test_url','!=','')->latest()->first()->result == 'Rejected')
                          <span class="bg-red">Rejected</span> 
                        @endif
                        @if($application->psychometricTest()->where('test_url','!=','')->latest()->first()->result == 'Accepted')
                          <span class="bg-green">Accepted</span >
                        @endif
                        @if($application->psychometricTest()->where('test_url','!=','')->latest()->first()->result == 'Inconsistent')
                          <span class="bg-red">Inconsistent</span >
                        @endif
                      @endif                
                    @else
                        <span class="bg-orange">Pending</span >
                    @endif
                  </td>
                  <td>{{{$application->borrower?$application->borrower->created_at : 'NA'}}}</td>
                  <td>{{$application->last_update}}</td>
                  <td><a href="/admin/application/{{$application->type}}/detail/{{$application->id}}" class="btn btn-block btn-success">View</a></td>
                  <!-- <td><a href="/admin/application/{{$application->type}}/delete/{{$application->id}}" class="btn btn-block btn-danger">Delete</a></td> -->
                  <!--<td> <a @click="showConfirmModal('/admin/application/{{$application->type}}/delete/{{$application->id}}','delete')" href="javascript:;" class="btn btn-block btn-danger delete-cofirmation">Delete</a> </td>-->

                </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th>Application Id</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Location</th>
                  <th>Test Result</th>
                  <th>Date</th>
                  <th>Last Updated</th>
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
    "order": [[ 0, "desc" ]]
  });

});
// function AlertIt() {

</script>


@endsection
