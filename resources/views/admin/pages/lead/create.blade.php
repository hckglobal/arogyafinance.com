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
        <div class="col-md-12">
          
          <!-- general form elements disabled -->
          <div class="box box-warning">
            <!-- /.box-header -->
            <div class="box-body ">
              <form role="form" method="post" action="/admin/lead/create">
                <!-- text input -->
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">               
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>First Name</label>
                      <input type="text" class="form-control" name="first_name" 
                        placeholder="Enter first name">
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Middle Name</label>
                      <input type="text" class="form-control" name="middle_name" 
                        placeholder="Enter middle name">
                    </div>
                  </div>
                  
                  <div class="col-md-4">                
                    <div class="form-group">
                      <label>Last Name</label>
                      <input type="text" class="form-control" name="last_name" 
                        placeholder="Enter last name">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Mobile Number *</label>
                      <input type="text" class="form-control" name="mobile_number" placeholder="Enter your mobile number" required>
                    </div>
                  </div>
                  <div class="col-md-4">  
                    <div class="form-group">
                      <label>Email</label>
                      <input type="text" class="form-control" name="email" placeholder="Enter your email-id">
                    </div>
                  </div>
                  <div class="col-md-4">  
                    <div class="form-group">
                      <label>Required Loan Amount</label>
                      <input type="text" class="form-control" name="requested_loan_amount" placeholder="Enter required loan amount">
                    </div>
                  </div>
                  <div class="col-md-4">  
                    <div class="form-group">
                      <label>Hospital Name</label>
                      <input type="text" class="form-control" name="hospital_name" placeholder="Enter hospital name">
                    </div>
                  </div>
                  <div class="col-md-4">  
                    <div class="form-group">
                      <label>Location</label>
                      <select class="form-control" name="location_id">
                            @foreach($locations as $location)
                              <option value="{{$location->id}}">{{$location->name}}</option>
                            @endforeach
                        </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                        <label>Product </label>
                        <select class="form-control" name="product_id">
                            @foreach($products as $product)
                              <option value="{{$product->id}}">{{$product->name}}</option>
                            @endforeach
                        </select>
                    </div>
                  </div>                  
                </div>
                <div class="box-footer">
                  <button type="submit" class="btn btn-primary pull-right">Submit</button>
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
