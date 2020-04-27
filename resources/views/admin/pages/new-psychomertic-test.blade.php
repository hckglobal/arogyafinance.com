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
<div class="content-wrapper" >
    <!-- Content Header (Page header) -->
    @include('admin.partials.content-header')

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-8">
          
          <!-- general form elements disabled -->
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Generate New Reference Code</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body ">
              <form role="form" method="post" action="/admin/new-psychometric-test/create">
                <!-- text input -->
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <div class="form-group">
                  <label>First Name</label>
                  <input type="text" class="form-control" name="first_name" placeholder="Enter First Name">
                </div>
                <div class="form-group">
                  <label>Middle Name</label>
                  <input type="text" class="form-control" name="middle_name" placeholder="Enter Middle Name">
                </div>
                <div class="form-group">
                  <label>Last Name</label>
                  <input type="text" class="form-control" name="last_name" placeholder="Enter Last Name">
                </div>
                <div class="form-group">
                  <label>Mobile Number</label>
                  <input type="number" class="form-control" name="mobile_number" placeholder="Enter Mobile Number">
                </div>
                <div class="form-group">
                  <label>Email</label>
                  <input type="text" class="form-control" name="email" placeholder="Enter Email">
                </div>

              
                <div class="box-footer">
                <button type="submit" id="ref_code" class="btn btn-primary">Generate Reference Code</button>
              </div>
              </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    <!-- /.content -->
</div>
@endsection





