@extends('admin.app')

@section('styles')
<!-- DataTables -->
<link rel="stylesheet" href="/assets/admin/plugins/datatables/dataTables.bootstrap.css">
@endsection

@section('title') 
Treatment Type
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
            <a href="/admin/treatment-type/create" class="pull-right btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Create New Treatment</a>
          </div><!-- /.box-header -->
          <div class="box-body">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                    <th>ID</th>
                    <th>Treatment Type NAME</th>
                    <th>ACTIONS</th>
                    
                </tr>
              </thead>
                  <tbody>
                     @foreach($treatment_types as $treatment_type)
                <tr>
                   <td>{{$treatment_type->id}}</td>
                   <td>{{$treatment_type->name}}</td>
                   <td class="location-fa">
                   <a href="/admin/treatment-type/edit/{{$treatment_type->id}}" data-toggle="tooltip" data-placement="top" title="Edit Location"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                   <a href="/admin/treatment-type/delete/{{$treatment_type->id}}" data-toggle="tooltip" data-placement="top" title="Delete Location"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                   </td>
                </tr>
                @endforeach
                </tbody>
                
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
        
        <!-- page script -->
        <script>
        $(function () {
          $(".table").DataTable();

        });
        </script>
        @endsection

