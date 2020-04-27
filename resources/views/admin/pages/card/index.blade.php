@extends('admin.app')

@section('title') 
Card Applications - Admin | Arogya Finance
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
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  @include('admin.partials.content-header')

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <!-- /.box -->
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Category - {{ucfirst($category)}} | Total: {{$forms->count()}} Applications</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                    <th>Application Id</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email Id</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
              </thead>
              <tbody>
                 @foreach($forms as $form)
                <tr>
                   <td>AF-C-#{{$form->user->id}}</td>
                   <td>{{$form->user->first_name}}</td>
                   <td>{{$form->user->last_name}}</td>
                   <td>{{$form->user->email}}</td>
                   <td>{{$form->user->created_at->toFormattedDateString()}}</td>
                   <td><a href="/admin/application/card/{{$form->id}}" class="btn btn-block btn-success">VIEW APPLICATION</a></td>
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th>Id</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email Id</th>
                    <th>Date</th>
                    <th>Action</th>
                  </tr>
                </tfoot>
              </table>
            </div><!-- /.box-body -->
          </div><!-- /.box -->

  
        
          </section><!-- /.content -->
        </div><!-- /.content-wrapper -->
        @endsection

        @section('scripts')
        <!-- DataTables -->
        <script src="/assets/admin/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="/assets/admin/plugins/datatables/dataTables.bootstrap.min.js"></script>
      
        <script>
        $(function () {
          $(".table").DataTable();

        });
        </script>
        @endsection

