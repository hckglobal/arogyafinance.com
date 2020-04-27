@extends('admin.app')

@section('title') 
Dashboard - Admin | Arogya Finance
@endsection

@section('styles')
<!-- DataTables -->
<link rel="stylesheet" href="/assets/admin/plugins/datatables/dataTables.bootstrap.css">
@endsection

@section('active-dashboard')
class="active"
@endsection


@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('admin.partials.content-header')

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-8">
          
          <!-- general form elements disabled -->
          <div class="box box-warning">
            <!-- /.box-header -->
            <div class="box-body">
              <form role="form" method="post" action="/admin/treatment-type/edit/{{$treatment_type->id}}">
                <!-- text input -->

                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <div class="form-group">
                  <label>Treatment Type name</label>
                  <input type="text" class="form-control" name="name" value="{{$treatment_type->name}}" placeholder="Enter Treatment Type Name">
                </div>
                <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
              </form>
            </div>
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    <!-- /.content -->
  </div>
@endsection

@section('scripts')

<!-- page script -->
@endsection


